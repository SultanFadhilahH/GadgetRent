<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Gadget;
use App\Models\Rental;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function validateProfile($user): bool
    {
        // Semua data wajib harus terisi
        if (!$user->name || !$user->nik || !$user->email || !$user->phone || !$user->ktp_verified_at) {
            return false;
        }

        // Alamat wajib sudah diisi di profil
        if (!$user->hasAddress()) {
            return false;
        }

        return true;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (!$this->validateProfile($user)) {
            return redirect()->route('addresses.index')->with('error', 'Lengkapi data diri (Nama, NIK, Email, No HP, Verifikasi KTP) dan Alamat pengiriman sebelum checkout.');
        }

        $carts = Cart::with('gadget')->where('user_id', $user->id)->get();

        if ($carts->isEmpty() && !$request->has('gadget_id')) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang Anda kosong.');
        }

        $items = [];
        if ($request->has('gadget_id')) {
            $gadget = Gadget::findOrFail($request->gadget_id);
            $items[] = (object) [
                'gadget' => $gadget,
                'quantity' => 1,
            ];
        } else {
            $items = $carts;
        }

        $vouchers = Voucher::where('is_active', true)
            ->where('end_date', '>=', now())
            ->get();

        return view('customer.checkout', compact('items', 'vouchers', 'user'));
    }

    public function direct(Request $request, Gadget $gadget)
    {
        return redirect()->route('checkout.index', ['gadget_id' => $gadget->id]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after:start_date',
            'delivery_option' => 'required|in:pickup,delivery',
            'payment_method'  => 'required|in:bank_transfer,qris,cod',
            'voucher_id'      => 'nullable|exists:vouchers,id',
        ]);

        $user = $request->user();

        if (!$this->validateProfile($user)) {
            return redirect()->route('addresses.index')->with('error', 'Lengkapi profil dan alamat Anda terlebih dahulu.');
        }

        if ($request->delivery_option === 'delivery' && $request->payment_method === 'cod') {
            return back()->with('error', 'COD hanya tersedia untuk opsi Ambil di Toko.');
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $duration  = $startDate->diffInDays($endDate);

        $items = [];
        if ($request->has('gadget_id') && $request->gadget_id) {
            $gadget  = Gadget::findOrFail($request->gadget_id);
            $items[] = (object) ['gadget' => $gadget, 'quantity' => 1];
        } else {
            $items = Cart::with('gadget')->where('user_id', $user->id)->get();
        }

        if (count($items) === 0) {
            return redirect()->route('catalog.index')->with('error', 'Tidak ada barang untuk di-checkout.');
        }

        $voucher        = null;
        $discountAmount = 0;
        if ($request->voucher_id) {
            $voucher = Voucher::find($request->voucher_id);
        }

        $invoiceCode = 'INV-' . strtoupper(Str::random(10));
        $totalPrice  = 0;

        foreach ($items as $item) {
            $totalPrice += $item->gadget->price_per_day * $duration * $item->quantity;
        }

        if ($voucher) {
            $discountAmount = $voucher->discount_type === 'percent'
                ? ($totalPrice * $voucher->discount_value) / 100
                : $voucher->discount_value;
        }

        $finalAmount    = max(0, $totalPrice - $discountAmount);
        $shippingAddress = $request->delivery_option === 'delivery' ? $user->full_address : null;

        foreach ($items as $item) {
            $itemTotal = $item->gadget->price_per_day * $duration * $item->quantity;
            $itemFinal = $totalPrice > 0
                ? max(0, $itemTotal - ($discountAmount * ($itemTotal / $totalPrice)))
                : $itemTotal;

            for ($i = 0; $i < $item->quantity; $i++) {
                Rental::create([
                    'invoice_code'    => $invoiceCode,
                    'user_id'         => $user->id,
                    'gadget_id'       => $item->gadget->id,
                    'start_date'      => $startDate,
                    'end_date'        => $endDate,
                    'total_price'     => $itemTotal / $item->quantity,
                    'total_amount'    => $itemFinal / $item->quantity,
                    'status'          => 'pending',
                    'payment_method'  => $request->payment_method,
                    'payment_status'  => 'pending',
                    'delivery_option' => $request->delivery_option,
                    'shipping_address' => $shippingAddress,
                    'voucher_id'      => $voucher ? $voucher->id : null,
                ]);
            }
        }

        // Hapus keranjang jika bukan direct checkout
        if (!$request->has('gadget_id') || !$request->gadget_id) {
            Cart::where('user_id', $user->id)->delete();
        }

        return view('customer.payment', [
            'invoiceCode'   => $invoiceCode,
            'finalAmount'   => $finalAmount,
            'paymentMethod' => $request->payment_method,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'invoice_code' => 'required|exists:rentals,invoice_code',
        ]);

        Rental::where('invoice_code', $request->invoice_code)->update([
            'payment_status' => 'paid',
            'status'         => 'ongoing',
        ]);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses.');
    }
}
