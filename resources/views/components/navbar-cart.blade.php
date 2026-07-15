@php
    $cartItems = [];
    $cartCount = 0;
    $cartTotal = 0;
    if (auth()->check()) {
        $cartItems = \App\Models\Cart::with('gadget')->where('user_id', auth()->id())->get();
        $cartCount = $cartItems->sum('quantity');
        foreach ($cartItems as $item) {
            $cartTotal += $item->gadget->price_per_day * $item->quantity;
        }
    }
@endphp

<!-- Dropdown Keranjang -->
<div class="relative" x-data="{ cartOpen: false }" @click.outside="cartOpen = false">
    <button @click="cartOpen = !cartOpen" class="flex items-center gap-2 text-sm font-medium bg-[#1a1d26] border border-gray-700 px-4 py-2 rounded-lg hover:bg-gray-800 transition focus:outline-none">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        <span class="hidden sm:inline">Keranjang</span>
        @if($cartCount > 0)
            <span class="bg-amber-500 text-black text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold ml-1">{{ $cartCount }}</span>
        @endif
    </button>

    <div 
        x-show="cartOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 bg-[#1a1d26] border border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden"
        x-cloak
    >
        <div class="p-4 border-b border-gray-800">
            <h4 class="text-sm font-bold text-white">Keranjang Kamu</h4>
        </div>
        <div class="p-2 max-h-64 overflow-y-auto">
            @if($cartCount > 0)
                @foreach($cartItems as $item)
                <div class="flex items-center gap-3 p-2 hover:bg-gray-800/50 rounded-lg transition relative group">
                    <div class="w-12 h-12 bg-[#12141c] rounded border border-gray-700 flex items-center justify-center shrink-0 overflow-hidden">
                        @if($item->gadget->image)
                            <img src="{{ asset('images/gadgets/'.$item->gadget->image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h5 class="text-xs font-bold text-white leading-tight truncate max-w-[130px]">{{ $item->gadget->name }}</h5>
                        <p class="text-[10px] text-gray-500 mt-0.5">Qty: {{ $item->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] font-bold text-white">Rp {{ number_format($item->gadget->price_per_day * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                    
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded-full text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            @else
                <div class="p-4 text-center text-gray-500 text-xs">
                    Keranjang kosong
                </div>
            @endif
        </div>
        @if($cartCount > 0)
        <div class="p-4 border-t border-gray-800 bg-[#12141c]">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs text-gray-400">Subtotal</span>
                <span class="text-sm font-bold text-white">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="block w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] text-center text-sm font-bold py-2.5 rounded-lg transition">
                Checkout
            </a>
        </div>
        @endif
    </div>
</div>
