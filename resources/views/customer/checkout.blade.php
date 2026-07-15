<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0b0c10] text-gray-200 flex flex-col min-h-screen">
    
    @php
        $isDirect = request()->has('gadget_id');
        $gadgetId = $isDirect ? request()->gadget_id : null;
        
        $subtotal = 0;
        foreach($items as $item) {
            $subtotal += $item->gadget->price_per_day * $item->quantity;
        }
    @endphp

    <!-- Navbar -->
    <nav class="border-b border-gray-900 bg-[#0b0c10] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <span class="flex h-4 w-4 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
            <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
        </div>
        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-400">
            <a href="/" class="hover:text-white transition">Home</a>
            <a href="{{ route('catalog.index') }}" class="hover:text-white transition">Katalog</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-400 hover:text-white">{{ auth()->user()->name }}</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-6 md:px-12 py-10" x-data="checkoutForm()">
        
        <div class="mb-10">
            <h4 class="text-amber-500 font-bold text-[10px] tracking-widest uppercase mb-2">Checkout</h4>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Selesaikan pemesanan kamu</h1>
            <p class="text-gray-400 text-sm">Lengkapi verifikasi, pengiriman, dan pembayaran sebelum unit dijadwalkan.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            @if($isDirect)
                <input type="hidden" name="gadget_id" value="{{ $gadgetId }}">
            @endif
            <input type="hidden" name="voucher_id" x-model="selectedVoucherId">
            <input type="hidden" name="payment_method" x-model="paymentMethod">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Address Section -->
                    <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-800 pb-4">
                            <div class="flex items-center gap-2 text-white font-bold">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Alamat Pengiriman
                            </div>
                            <a href="{{ route('addresses.index') }}" class="bg-[#1e222e] border border-gray-700 hover:bg-gray-700 text-white text-xs px-3 py-1.5 rounded transition font-medium">Ubah Alamat</a>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-sm font-bold text-white">{{ auth()->user()->name }}</h3>
                                <span class="text-xs text-gray-400">{{ auth()->user()->phone }}</span>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed max-w-lg">
                                {{ $customer->address }}
                            </p>
                        </div>
                    </div>

                    <!-- Delivery & Pickup Selection -->
                    <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-6 h-6 rounded-full bg-[#1a1d26] border border-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-400 shrink-0">1</div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Pengiriman & Pengambilan</h3>
                                <p class="text-gray-500 text-xs">Pilih cara kamu menerima unit</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 rounded-xl border cursor-pointer transition"
                                :class="deliveryMethod === 'delivery' ? 'bg-[#1a1d26] border-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700'">
                                <div class="flex items-start gap-4">
                                    <div class="relative flex items-center justify-center w-5 h-5 rounded-full border shrink-0 mt-0.5"
                                        :class="deliveryMethod === 'delivery' ? 'border-amber-500' : 'border-gray-600'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-amber-500 transition-transform scale-0"
                                            :class="deliveryMethod === 'delivery' ? 'scale-100' : ''"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white mb-1">Kirim ke Alamat</h4>
                                        <p class="text-xs text-gray-400">Unit akan diantar ke alamat Anda.</p>
                                    </div>
                                </div>
                                <input type="radio" x-model="deliveryMethod" name="delivery_option" value="delivery" class="hidden" @change="checkCod()">
                            </label>

                            <label class="flex items-center justify-between p-4 rounded-xl border cursor-pointer transition"
                                :class="deliveryMethod === 'pickup' ? 'bg-[#1a1d26] border-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700'">
                                <div class="flex items-start gap-4">
                                    <div class="relative flex items-center justify-center w-5 h-5 rounded-full border shrink-0 mt-0.5"
                                        :class="deliveryMethod === 'pickup' ? 'border-amber-500' : 'border-gray-600'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-amber-500 transition-transform scale-0"
                                            :class="deliveryMethod === 'pickup' ? 'scale-100' : ''"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white mb-1">Ambil di Hub / Toko</h4>
                                        <p class="text-xs text-gray-400">Self pick-up di lokasi hub terdekat.</p>
                                    </div>
                                </div>
                                <input type="radio" x-model="deliveryMethod" name="delivery_option" value="pickup" class="hidden" @change="checkCod()">
                            </label>
                        </div>
                    </div>

                    <!-- Duration & Schedule -->
                    <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-6 h-6 rounded-full bg-[#1a1d26] border border-gray-700 flex items-center justify-center text-[10px] font-bold text-amber-500 shrink-0">2</div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Durasi & Jadwal Peminjaman</h3>
                                <p class="text-gray-500 text-xs">Tentukan tanggal mulai dan selesai</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-[#12141c] border border-gray-800 rounded-xl p-4">
                                <label class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2 block">Tanggal Mulai</label>
                                <input type="date" name="start_date" x-model="startDate" @change="calculateDuration()" class="w-full bg-transparent border-none text-white focus:ring-0 p-0" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="bg-[#12141c] border border-gray-800 rounded-xl p-4">
                                <label class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2 block">Tanggal Pengembalian</label>
                                <input type="date" name="end_date" x-model="endDate" @change="calculateDuration()" class="w-full bg-transparent border-none text-white focus:ring-0 p-0" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                        </div>

                        <div class="bg-[#1a1d26] border border-gray-800 rounded-lg p-4 flex justify-between items-center">
                            <span class="text-sm text-gray-300 font-medium">Total Durasi Sewa</span>
                            <span class="text-amber-500 font-bold" x-text="duration + ' Hari'"></span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-6 h-6 rounded-full bg-[#1a1d26] border border-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-400 shrink-0">3</div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Metode Pembayaran</h3>
                                <p class="text-gray-500 text-xs">Pilih cara pembayaran</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                            <button type="button" @click="paymentMethod = 'bank_transfer'" 
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                    :class="paymentMethod === 'bank_transfer' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                                <span class="text-[11px] font-bold">Transfer Bank (Seabank)</span>
                            </button>
                            
                            <button type="button" @click="paymentMethod = 'qris'" 
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                    :class="paymentMethod === 'qris' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                                <span class="text-[11px] font-bold">QRIS</span>
                            </button>

                            <button type="button" @click="if(deliveryMethod === 'pickup') { paymentMethod = 'cod' }" 
                                    class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                    :class="{
                                        'bg-[#1a1d26] border-amber-500 text-amber-500': paymentMethod === 'cod',
                                        'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400': paymentMethod !== 'cod' && deliveryMethod === 'pickup',
                                        'opacity-50 cursor-not-allowed bg-gray-900 border-gray-800': deliveryMethod === 'delivery'
                                    }">
                                <span class="text-[11px] font-bold text-center">Bayar di Tempat (COD)</span>
                            </button>
                        </div>
                        <p x-show="deliveryMethod === 'delivery' && paymentMethod === 'cod'" class="text-red-500 text-xs mt-2">COD hanya bisa digunakan jika memilih opsi Ambil di Toko.</p>
                    </div>

                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6 sticky top-24">
                        <h3 class="text-white font-bold mb-6">Ringkasan Pesanan</h3>

                        <div class="space-y-4 mb-6">
                            @foreach($items as $item)
                                <div class="flex justify-between items-start text-sm">
                                    <div class="text-gray-400 max-w-[150px]">
                                        <p>{{ $item->gadget->name }}</p>
                                        <p class="text-[10px]">Qty: {{ $item->quantity }} x Rp {{ number_format($item->gadget->price_per_day, 0, ',', '.') }}/hari</p>
                                    </div>
                                    <span class="text-gray-300 font-mono text-right" x-text="formatRupiah({{ $item->gadget->price_per_day * $item->quantity }} * duration)"></span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Voucher Section -->
                        <div class="mb-6">
                            <p class="text-xs text-gray-400 mb-2">Pilih Voucher</p>
                            <select x-model="selectedVoucherId" @change="calculateDiscount()" class="w-full bg-[#12141c] border border-gray-800 rounded-lg text-sm text-white focus:ring-amber-500 focus:border-amber-500 p-3">
                                <option value="">Tidak pakai voucher</option>
                                @foreach($vouchers as $v)
                                    <option value="{{ $v->id }}" data-type="{{ $v->discount_type }}" data-amount="{{ $v->discount_amount }}">
                                        {{ $v->code }} - {{ $v->discount_type == 'percentage' ? $v->discount_amount.'%' : 'Rp '.number_format($v->discount_amount,0,',','.') }} (Min: Rp {{ number_format($v->min_transaction,0,',','.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-gray-800 border-dashed mb-6">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Subtotal</span>
                                <span class="text-gray-300 font-mono" x-text="formatRupiah(subtotalPrice)"></span>
                            </div>
                            <div class="flex justify-between items-center text-sm" x-show="discount > 0">
                                <span class="text-green-400">Diskon</span>
                                <span class="text-green-400 font-mono" x-text="'- ' + formatRupiah(discount)"></span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mb-8 pt-4 border-t border-gray-800">
                            <span class="text-white font-bold text-lg">Total</span>
                            <span class="text-amber-500 font-bold text-xl font-mono" x-text="formatRupiah(totalPrice)"></span>
                        </div>

                        <button type="submit" :disabled="duration <= 0 || (deliveryMethod === 'delivery' && paymentMethod === 'cod')" class="w-full bg-amber-500 hover:bg-amber-600 disabled:opacity-50 disabled:cursor-not-allowed text-[#12141c] font-bold py-3.5 rounded-xl transition shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                            Buat Pesanan
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutForm', () => ({
                deliveryMethod: 'pickup',
                paymentMethod: 'bank_transfer',
                startDate: '',
                endDate: '',
                duration: 0,
                baseSubtotal: {{ $subtotal }}, // per day subtotal
                subtotalPrice: 0,
                discount: 0,
                totalPrice: 0,
                selectedVoucherId: '',

                init() {
                    const today = new Date();
                    const tomorrow = new Date(today);
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    
                    this.startDate = today.toISOString().split('T')[0];
                    this.endDate = tomorrow.toISOString().split('T')[0];
                    this.calculateDuration();
                },

                checkCod() {
                    if (this.deliveryMethod === 'delivery' && this.paymentMethod === 'cod') {
                        this.paymentMethod = 'bank_transfer';
                    }
                },

                calculateDuration() {
                    if(this.startDate && this.endDate) {
                        const start = new Date(this.startDate);
                        const end = new Date(this.endDate);
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                        this.duration = diffDays > 0 ? diffDays : 0;
                    } else {
                        this.duration = 0;
                    }
                    this.calculateTotals();
                },

                calculateDiscount() {
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotalPrice = this.baseSubtotal * this.duration;
                    
                    this.discount = 0;
                    if(this.selectedVoucherId) {
                        const select = document.querySelector('select[x-model="selectedVoucherId"]');
                        const option = select.options[select.selectedIndex];
                        if(option) {
                            const type = option.getAttribute('data-type');
                            const amount = parseFloat(option.getAttribute('data-amount'));
                            
                            if(type === 'percentage') {
                                this.discount = (this.subtotalPrice * amount) / 100;
                            } else {
                                this.discount = amount;
                            }
                        }
                    }

                    this.totalPrice = Math.max(0, this.subtotalPrice - this.discount);
                },

                formatRupiah(amount) {
                    return 'Rp ' + amount.toLocaleString('id-ID');
                }
            }));
        });
    </script>
</body>
</html>
