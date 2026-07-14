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

    <!-- Navbar -->
    <nav class="border-b border-gray-900 bg-[#0b0c10] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <span class="flex h-4 w-4 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
            <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
        </div>

        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-400">
            <a href="/" class="hover:text-white transition">Home</a>
            <a href="{{ route('catalog.index') }}" class="hover:text-white transition">Katalog</a>
            <a href="#" class="hover:text-white transition">Blog</a>
            <a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a>
        </div>

        <div class="flex items-center gap-4">
            <!-- Dropdown Keranjang -->
            <div class="relative" x-data="{ cartOpen: false }" @click.outside="cartOpen = false">
                <button @click="cartOpen = !cartOpen" class="flex items-center gap-2 text-sm font-medium bg-[#1a1d26] border border-amber-500/50 text-amber-500 px-4 py-2 rounded-lg hover:bg-[#222632] transition focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="hidden sm:inline">Keranjang</span>
                    <span class="bg-amber-500 text-black text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold ml-1">2</span>
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
                        <div class="flex items-center gap-3 p-2 hover:bg-gray-800/50 rounded-lg transition">
                            <div class="w-12 h-12 bg-[#12141c] rounded border border-gray-700 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-grow">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Kamera</p>
                                <h5 class="text-xs font-bold text-white leading-tight">Sony A7 III</h5>
                                <p class="text-[10px] text-gray-500 mt-0.5">3 Hari</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-white">Rp 1.050.000</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-2 hover:bg-gray-800/50 rounded-lg transition">
                            <div class="w-12 h-12 bg-[#12141c] rounded border border-gray-700 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-grow">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Konsol Game</p>
                                <h5 class="text-xs font-bold text-white leading-tight">PlayStation 5</h5>
                                <p class="text-[10px] text-gray-500 mt-0.5">2 Hari</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-white">Rp 300.000</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-800 bg-[#12141c]">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-gray-400">Total (2 Item)</span>
                            <span class="text-sm font-bold text-white">Rp 1.350.000</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="block w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] text-center text-sm font-bold py-2.5 rounded-lg transition">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
            @auth
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-3 hover:opacity-80 transition focus:outline-none bg-[#1a1d26] rounded-lg p-1 pr-4">
                        <div class="h-8 w-8 bg-amber-500 rounded-md flex items-center justify-center text-[#12141c] font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-bold text-white hidden sm:block">{{ auth()->user()->name }}</span>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-44 bg-[#1a1d26] border border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden"
                        x-cloak
                    >
                        <div class="px-4 py-3 border-b border-gray-800">
                            <p class="text-xs text-gray-400">Masuk sebagai</p>
                            <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition text-left border-b border-gray-800/50">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="bg-[#1a1d26] border border-gray-700 hover:bg-gray-800 text-white text-sm px-5 py-2 rounded-lg transition font-medium">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-6 md:px-12 py-10" x-data="{
        deliveryMethod: 'pickup', // 'pickup' or 'delivery'
        paymentMethod: 'va', // 'va', 'ewallet', 'cc', 'cod'
        bank: 'mandiri' // 'mandiri', 'bca', 'bni', 'bri'
    }">
        
        <div class="mb-10">
            <h4 class="text-amber-500 font-bold text-[10px] tracking-widest uppercase mb-2">Checkout</h4>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Selesaikan pemesanan kamu</h1>
            <p class="text-gray-400 text-sm">Lengkapi verifikasi, pengiriman, dan pembayaran sebelum unit dijadwalkan.</p>
        </div>

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
                        <button class="bg-[#1e222e] border border-gray-700 hover:bg-gray-700 text-white text-xs px-3 py-1.5 rounded transition font-medium">Ganti Alamat</button>
                    </div>
                    
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-sm font-bold text-white">Budi Santoso</h3>
                            <span class="text-xs text-gray-400">081234567890</span>
                            <span class="bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[9px] px-2 py-0.5 rounded uppercase font-bold tracking-wider flex items-center gap-1">
                                <span class="w-1 h-1 bg-amber-500 rounded-full"></span> Utama
                            </span>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed max-w-lg">
                            Jl. Merdeka No. 10, RT 04/RW 02, Kel. Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114
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
                                    <p class="text-xs text-gray-400">Unit akan diantar oleh kurir rekanan kami (Gojek/Grab).</p>
                                </div>
                            </div>
                            <input type="radio" x-model="deliveryMethod" value="delivery" class="hidden">
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
                                    <p class="text-xs text-gray-400">Self pick-up di lokasi hub GadgetRent terdekat.</p>
                                </div>
                            </div>
                            <input type="radio" x-model="deliveryMethod" value="pickup" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Duration & Schedule -->
                <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-6 h-6 rounded-full bg-[#1a1d26] border border-gray-700 flex items-center justify-center text-[10px] font-bold text-amber-500 shrink-0">2</div>
                        <div>
                            <h3 class="text-white font-bold text-sm">Durasi & Jadwal Peminjaman</h3>
                            <p class="text-gray-500 text-xs">Cek kembali agar tidak salah input</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-[#12141c] border border-gray-800 rounded-xl p-4">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Tanggal Mulai</p>
                            <h4 class="text-white font-bold mb-1">Sabtu, 11 Juli 2026</h4>
                            <p class="text-xs text-gray-400">Jam Pengiriman &middot; Pukul 10:00 WIB</p>
                        </div>
                        <div class="bg-[#12141c] border border-gray-800 rounded-xl p-4">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Tanggal Pengembalian</p>
                            <h4 class="text-white font-bold mb-1">Sabtu, 18 Juli 2026</h4>
                            <p class="text-xs text-gray-400">Jam Penjemputan &middot; Pukul 10:00 WIB</p>
                        </div>
                    </div>

                    <div class="bg-[#1a1d26] border border-gray-800 rounded-lg p-4 flex justify-between items-center">
                        <span class="text-sm text-gray-300 font-medium">Total Durasi Sewa</span>
                        <span class="text-amber-500 font-bold">7 Hari</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-6 h-6 rounded-full bg-[#1a1d26] border border-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-400 shrink-0">3</div>
                        <div>
                            <h3 class="text-white font-bold text-sm">Metode Pembayaran</h3>
                            <p class="text-gray-500 text-xs">Pilih cara pembayaran yang paling nyaman buat kamu</p>
                        </div>
                    </div>

                    <!-- Payment Tabs -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                        <button @click="paymentMethod = 'va'" 
                                class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                :class="paymentMethod === 'va' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            <span class="text-[11px] font-bold">Virtual Account</span>
                        </button>
                        
                        <button @click="paymentMethod = 'ewallet'" 
                                class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                :class="paymentMethod === 'ewallet' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-[11px] font-bold">E-Wallet</span>
                        </button>

                        <button @click="paymentMethod = 'cc'" 
                                class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                :class="paymentMethod === 'cc' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            <span class="text-[11px] font-bold text-center">Kartu Kredit/Debit</span>
                        </button>

                        <button @click="paymentMethod = 'cod'" 
                                class="flex flex-col items-center justify-center p-4 rounded-xl border transition gap-2"
                                :class="paymentMethod === 'cod' ? 'bg-[#1a1d26] border-amber-500 text-amber-500' : 'bg-transparent border-gray-800 hover:border-gray-700 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            <span class="text-[11px] font-bold text-center">Bayar di Tempat (COD)</span>
                        </button>
                    </div>

                    <!-- Virtual Account Details -->
                    <div x-show="paymentMethod === 'va'" x-collapse>
                        <div class="flex gap-2 mb-4">
                            <button @click="bank = 'mandiri'" class="px-4 py-2 rounded-lg text-xs font-bold transition" :class="bank === 'mandiri' ? 'bg-amber-500 text-[#12141c]' : 'bg-[#1a1d26] border border-gray-800 text-gray-400 hover:bg-gray-800'">Mandiri</button>
                            <button @click="bank = 'bca'" class="px-4 py-2 rounded-lg text-xs font-bold transition" :class="bank === 'bca' ? 'bg-amber-500 text-[#12141c]' : 'bg-[#1a1d26] border border-gray-800 text-gray-400 hover:bg-gray-800'">BCA</button>
                            <button @click="bank = 'bni'" class="px-4 py-2 rounded-lg text-xs font-bold transition" :class="bank === 'bni' ? 'bg-amber-500 text-[#12141c]' : 'bg-[#1a1d26] border border-gray-800 text-gray-400 hover:bg-gray-800'">BNI</button>
                            <button @click="bank = 'bri'" class="px-4 py-2 rounded-lg text-xs font-bold transition" :class="bank === 'bri' ? 'bg-amber-500 text-[#12141c]' : 'bg-[#1a1d26] border border-gray-800 text-gray-400 hover:bg-gray-800'">BRI</button>
                        </div>
                        <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 flex gap-3 text-blue-400 items-start">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[11px] leading-relaxed">Pembayaran manual via transfer bank & cek mutasi tidak tersedia karena memperlambat proses verifikasi pesanan.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-[#15171e] border border-gray-800 rounded-xl p-6 sticky top-24">
                    <h3 class="text-white font-bold mb-6">Ringkasan Pesanan</h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Sony A7 III (3 hari)</span>
                            <span class="text-gray-300 font-mono">Rp 1.050.000</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">PlayStation 5 (2 hari)</span>
                            <span class="text-gray-300 font-mono">Rp 300.000</span>
                        </div>
                    </div>

                    <!-- Voucher Section -->
                    <div class="mb-6">
                        <div class="flex items-center bg-[#12141c] border border-gray-800 rounded-lg overflow-hidden focus-within:border-gray-600 transition">
                            <div class="pl-3 pr-2 text-amber-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <input type="text" placeholder="Masukkan kode voucher toko" class="w-full bg-transparent border-none text-sm text-white focus:ring-0 placeholder-gray-600 py-3">
                            <button class="bg-[#1a1d26] text-white text-xs font-bold px-4 py-2 mr-1 rounded-md hover:bg-gray-700 transition border border-gray-700">Terapkan</button>
                        </div>
                    </div>

                    <div class="space-y-3 pt-6 border-t border-gray-800 border-dashed mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Biaya Layanan</span>
                            <span class="text-gray-300 font-mono">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-400">Biaya Pengiriman</span>
                            <span class="text-gray-300 font-mono">Rp 20.000</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-end mb-8 pt-4 border-t border-gray-800">
                        <span class="text-white font-bold text-lg">Total</span>
                        <span class="text-white font-bold text-xl font-mono">Rp 1.385.000</span>
                    </div>

                    <button class="w-full bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold py-3.5 rounded-xl transition shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                        Buat Pesanan
                    </button>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#0b0c10] pt-16 pb-8 px-6 md:px-12 border-t border-gray-900 mt-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex h-3 w-3 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
                    <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed max-w-xs">
                    Sewa kamera, laptop, dan konsol game harian dengan proses klaim seperti tiket — tinggal ambil, pakai, kembalikan.
                </p>
            </div>

            <!-- Navigasi -->
            <div>
                <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-4">Navigasi</h3>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li><a href="/" class="hover:text-amber-500 transition">Home</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-amber-500 transition">Katalog</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Blog</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-amber-500 transition">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div>
                <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-4">Bantuan</h3>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-amber-500 transition">Informasi Customer</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Checkout</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-4">Kontak</h3>
                <ul class="space-y-3 text-xs text-gray-400 mb-5">
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-gray-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Jl. Kreatif No. 12, Bandung
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        halo@gadgetrent.id
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +62 812-3456-7890
                    </li>
                </ul>
                <!-- Social Media -->
                <div class="flex gap-2 mt-4">
                    <a href="#" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-pink-400 hover:border-pink-500/40 transition" title="Instagram">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-white hover:border-gray-600 transition" title="TikTok">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-green-400 hover:border-green-500/40 transition" title="WhatsApp">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-800/50 flex items-center justify-center">
            <p class="text-[10px] text-gray-600 font-mono">&copy; {{ date('Y') }} GadgetRent. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
