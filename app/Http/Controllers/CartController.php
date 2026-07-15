<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Gadget;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gadget_id' => 'required|exists:gadgets,id',
        ]);

        $user = $request->user();
        $gadget = Gadget::findOrFail($request->gadget_id);

        if ($gadget->status !== 'available') {
            return back()->with('error', 'Gadget tidak tersedia untuk disewa.');
        }

        // Check if item already in cart
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('gadget_id', $gadget->id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $user->id,
                'gadget_id' => $gadget->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Berhasil ditambahkan ke keranjang.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function getCartData(Request $request)
    {
        $carts = Cart::with('gadget')->where('user_id', $request->user()->id)->get();
        
        $totalItems = $carts->sum('quantity');
        
        $items = $carts->map(function ($cart) {
            return [
                'id' => $cart->id,
                'gadget_name' => $cart->gadget->name,
                'gadget_image' => $cart->gadget->image ? asset('images/gadgets/'.$cart->gadget->image) : null,
                'price' => number_format($cart->gadget->price_per_day, 0, ',', '.'),
                'quantity' => $cart->quantity
            ];
        });

        return response()->json([
            'count' => $totalItems,
            'items' => $items
        ]);
    }
}
