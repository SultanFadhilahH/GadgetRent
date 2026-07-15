<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Gadget;
use App\Models\Rental;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function validateProfile($user)
    {
        if (!$user->name || !$user->nik || !$user->email || !$user->phone || !$user->ktp_verified_at) {
            return false;
        }

        // Check if user is a customer and has address
        $customer = Customer::where('user_id', $user->id)->first();
        if (!$customer || !$customer->address) {
            return false;
        }

        return true;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (!$this->validateProfile($user)) {
            return redirect()->route('profile.edit')->with('error', 'Lengkapi data diri (Nama, NIK, Email, No HP, Verifikasi KTP) dan Alamat sebelum checkout.');
        }

        $carts = Cart::with('gadget')->where('user_id', $user->id)->get();

        if ($carts->isEmpty() && !$request->has('gadget_id')) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang Anda kosong.');
        }

        $items = [];
        if ($request->has('gadget_id')) {
            // Direct checkout logic
            $gadget = Gadget::findOrFail($request->gadget_id);
            $items[] = (object) [
                'gadget' => $gadget,
                'quantity' => 1,
            ];
        } else {
            $items = $carts;
        }

        $vouchers = Voucher::where('status', 'active')
            ->where('valid_until', '>=', now())
            ->get();

        $customer = Customer::where('user_id', $user->id)->first();

        return view('customer.checkout', compact('items', 'vouchers', 'customer'));
    }

    public function direct(Request $request, Gadget $gadget)
    {
        return redirect()->route('checkout.index', ['gadget_id' => $gadget->id]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'delivery_option' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:bank_transfer,qris,cod',
            'voucher_id' => 'nullable|exists:vouchers,id',
        ]);

        $user = $request->user();

        if (!$this->validateProfile($user)) {
            return redirect()->route('profile.edit')->with('error', 'Lengkapi profil Anda.');
        }

        if ($request->delivery_option === 'delivery' && $request->payment_method === 'cod') {
            return back()->with('error', 'COD hanya tersedia untuk opsi Ambil di Toko.');
        }

        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $duration = $startDate->diffInDays($endDate);

        $items = [];
        if ($request->has('gadget_id') && $request->gadget_id) {
            $gadget = Gadget::findOrFail($request->gadget_id);
            $items[] = (object) ['gadget' => $gadget, 'quantity' => 1];
        } else {
            $items = Cart::with('gadget')->where('user_id', $user->id)->get();
        }

        if (count($items) === 0) {
            return redirect()->route('catalog.index')->with('error', 'Tidak ada barang untuk di-checkout.');
        }

        $voucher = null;
        $discountAmount = 0;
        if ($request->voucher_id) {
            $voucher = Voucher::find($request->voucher_id);
        }

        $invoiceCode = 'INV-' . strtoupper(Str::random(10));
        $totalPrice = 0;

        foreach ($items as $item) {
            $itemTotalPrice = $item->gadget->price_per_day * $duration * $item->quantity;
            $totalPrice += $itemTotalPrice;
        }

        if ($voucher) {
            if ($voucher->discount_type === 'percentage') {
                $discountAmount = ($totalPrice * $voucher->discount_amount) / 100;
            } else {
                $discountAmount = $voucher->discount_amount;
            }
        }

        $finalAmount = max(0, $totalPrice - $discountAmount);
        
        // Buat order untuk setiap item (dalam sistem rental, bisa dipecah atau disatukan. Kita pecah per gadget)
        foreach ($items as $item) {
            $itemTotal = $item->gadget->price_per_day * $duration * $item->quantity;
            $itemFinal = $itemTotal;
            if ($totalPrice > 0) {
                 // Pro-rate discount
                 $itemFinal = max(0, $itemTotal - ($discountAmount * ($itemTotal / $totalPrice)));
            }

            for($i=0; $i<$item->quantity; $i++){
                Rental::create([
                    'invoice_code' => $invoiceCode,
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'gadget_id' => $item->gadget->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_price' => $itemTotal / $item->quantity, // original price per item per duration
                    'total_amount' => $itemFinal / $item->quantity, // final price per item
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'delivery_option' => $request->delivery_option,
                    'shipping_address' => $request->delivery_option === 'delivery' ? $customer->address : null,
                    'voucher_id' => $voucher ? $voucher->id : null,
                ]);
            }
        }

        // Hapus keranjang jika bukan direct checkout
        if (!$request->has('gadget_id') || !$request->gadget_id) {
            Cart::where('user_id', $user->id)->delete();
        }

        // Redirect to payment view
        return view('customer.payment', [
            'invoiceCode' => $invoiceCode,
            'finalAmount' => $finalAmount,
            'paymentMethod' => $request->payment_method
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'invoice_code' => 'required|exists:rentals,invoice_code'
        ]);

        // Mock payment confirmation
        Rental::where('invoice_code', $request->invoice_code)->update([
            'payment_status' => 'paid',
            'status' => 'ongoing' // Atau pending_approval, disesuaikan. ongoing for simplicity
        ]);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses.');
    }
}
