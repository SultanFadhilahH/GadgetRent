<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#12141c] text-gray-200 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="border-b border-gray-800 bg-[#12141c] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <span class="flex h-4 w-4 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
            <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
        </div>

        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-400">
            <a href="#" class="text-white border-b-2 border-amber-500 pb-1">Home</a>
            <a href="#" class="hover:text-white transition">Katalog</a>
            <a href="#" class="hover:text-white transition">Blog</a>
            <a href="#" class="hover:text-white transition">Tentang Kami</a>
        </div>

        <div class="flex items-center gap-4">
            <button class="flex items-center gap-2 text-sm font-medium bg-[#1a1d26] border border-gray-700 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="hidden sm:inline">Keranjang</span>
                <span class="bg-amber-500 text-black text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold ml-1">2</span>
            </button>
            @auth
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-3 hover:opacity-80 transition focus:outline-none">
                        <div class="h-9 w-9 bg-amber-500 rounded-lg flex items-center justify-center text-[#12141c] font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-bold text-white hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 hidden sm:block transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <!-- Dropdown Menu -->
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

    <!-- TAHAPAN BARU: TAMBAHKAN LINK PROFILE INI -->
    <a href="{{ route('profile.edit') }}" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition text-left border-b border-gray-800/50">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profile Saya
    </a>

    <!-- Form Logout bawaan Anda -->
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
                <a href="{{ route('login') }}" class="bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold text-sm px-5 py-2 rounded-lg transition">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20 md:py-0 md:h-[600px] flex items-center px-6 md:px-12" style="background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop');">
        <!-- Overlay for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#12141c] via-[#12141c]/90 to-[#12141c]/40 md:to-transparent"></div>

        <div class="max-w-2xl relative z-10 pt-4 md:pt-0">
            <p class="text-amber-500 font-medium tracking-widest text-[10px] md:text-[11px] uppercase mb-4 flex items-center gap-2">
                <span class="w-6 md:w-8 h-[1px] bg-amber-500"></span> Sewa Gadget, Bukan Beli
            </p>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4 md:mb-6">
                Peralatan kreatif & gaming, siap pakai <span class="text-amber-500">hari ini.</span>
            </h1>
            <p class="text-gray-400 text-xs sm:text-sm md:text-base mb-6 md:mb-8 max-w-lg leading-relaxed">
                Sewa kamera, laptop, dan konsol game harian dengan proses klaim seperti tiket — tinggal ambil, pakai, kembalikan.
            </p>

            <div class="flex gap-6 md:gap-8 mb-8 text-sm">
                <div>
                    <div class="text-xl md:text-2xl font-bold text-white mb-1">5</div>
                    <div class="text-gray-500 text-[10px] tracking-wider uppercase font-bold">Unit Tersedia</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white mb-1">3</div>
                    <div class="text-gray-500 text-[10px] tracking-wider uppercase font-bold">Kategori</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white mb-1">4.9</div>
                    <div class="text-gray-500 text-[10px] tracking-wider uppercase font-bold">Rating Penyewa</div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <button class="bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold px-6 py-3 rounded-lg transition text-sm">
                    Lihat Katalog
                </button>
                <button class="bg-[#1a1d26] border border-gray-700 hover:bg-gray-800 text-white font-bold px-6 py-3 rounded-lg transition text-sm">
                    Tentang Kami
                </button>
            </div>
        </div>
    </section>

    <!-- Gadget Populer -->
    <section class="py-16 px-6 md:px-12 bg-[#12141c]">
        <div class="flex justify-between items-end mb-8 border-b border-gray-800 pb-4">
            <h2 class="text-xl font-bold text-white">Gadget Populer</h2>
            <p class="text-[11px] text-gray-500 font-mono tracking-widest lowercase">pilihan terlaris minggu ini</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @forelse ($gadgets as $gadget)
                <div class="bg-[#1a1d26] border border-gray-800 rounded-xl overflow-hidden hover:border-gray-600 transition flex flex-col h-full group">
                    <div class="relative bg-[#151821] aspect-square flex flex-col items-center justify-center p-4">
                        <span class="absolute top-3 right-3 bg-emerald-500/10 text-emerald-400 text-[9px] font-bold px-2.5 py-1 rounded-full border border-emerald-500/20 flex items-center gap-1 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> available
                        </span>

                        @if(strtolower($gadget->category->name ?? '') == 'kamera')
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @elseif(strtolower($gadget->category->name ?? '') == 'laptop')
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        @else
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-grow justify-between border-t border-gray-800 border-dashed">
                        <div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">{{ $gadget->category->name ?? 'Lainnya' }}</p>
                            <h3 class="text-sm font-bold text-white mb-1 line-clamp-1" title="{{ $gadget->name }}">{{ $gadget->name }}</h3>
                            <p class="text-[11px] text-gray-400 mb-4 line-clamp-1">{{ $gadget->brand }} &middot; {{ $gadget->serial_number }}</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto">
                            <div>
                                <p class="text-sm font-bold text-white">Rp {{ number_format($gadget->price_per_day, 0, ',', '.') }}<span class="text-[9px] text-gray-500 font-normal"> /hari</span></p>
                            </div>
                            <button class="bg-amber-500 hover:bg-amber-600 text-[#12141c] text-xs font-bold px-3 py-1.5 rounded transition">Sewa</button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Dummy Data if database is empty -->
                @foreach(['Kamera' => 'Sony A7 III', 'Laptop' => 'MacBook Air M2', 'Konsol Game' => 'PlayStation 5', 'Kamera' => 'Canon EOS R', 'Laptop' => 'Asus ROG Zephyrus'] as $category => $name)
                <div class="bg-[#1a1d26] border border-gray-800 rounded-xl overflow-hidden hover:border-gray-600 transition flex flex-col h-full group">
                    <div class="relative bg-[#151821] aspect-square flex flex-col items-center justify-center p-4">
                        <span class="absolute top-3 right-3 bg-emerald-500/10 text-emerald-400 text-[9px] font-bold px-2.5 py-1 rounded-full border border-emerald-500/20 flex items-center gap-1 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> available
                        </span>
                        @if($category == 'Kamera')
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @elseif($category == 'Laptop')
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        @else
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-grow justify-between border-t border-gray-800 border-dashed">
                        <div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">{{ $category }}</p>
                            <h3 class="text-sm font-bold text-white mb-1">{{ $name }}</h3>
                            <p class="text-[11px] text-gray-400 mb-4">Brand &middot; Spesifikasi</p>
                        </div>
                        <div class="flex items-end justify-between mt-auto">
                            <div>
                                <p class="text-sm font-bold text-white">Rp 250rb<span class="text-[9px] text-gray-500 font-normal"> /hari</span></p>
                            </div>
                            <button class="bg-amber-500 hover:bg-amber-600 text-[#12141c] text-xs font-bold px-3 py-1.5 rounded transition">Sewa</button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforelse
        </div>
    </section>

    <!-- Info Section (Cara Sewa + Review) -->
    <section class="py-16 px-6 md:px-12 bg-[#12141c]">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Cara Sewa -->
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Cara sewa di GadgetRent</h2>
                <p class="text-sm text-gray-400 mb-10">Lima langkah sederhana dari memilih unit sampai unit kembali ke toko.</p>

                <div class="relative border-l border-gray-800 ml-4 space-y-8 pb-4">
                    <div class="relative pl-8">
                        <span class="absolute -left-3.5 top-0 flex items-center justify-center w-7 h-7 bg-[#1a1d26] border border-gray-700 text-gray-400 text-xs font-bold rounded-full">1</span>
                        <h3 class="text-sm font-bold text-white mb-1">Pilih Gadget & Tanggal</h3>
                        <p class="text-[13px] text-gray-400 leading-relaxed">Jelajahi katalog, pilih unit yang sesuai kebutuhan, lalu tentukan tanggal mulai dan tanggal selesai sewa.</p>
                    </div>
                    <div class="relative pl-8">
                        <span class="absolute -left-3.5 top-0 flex items-center justify-center w-7 h-7 bg-[#1a1d26] border border-gray-700 text-gray-400 text-xs font-bold rounded-full">2</span>
                        <h3 class="text-sm font-bold text-white mb-1">Isi Data Diri</h3>
                        <p class="text-[13px] text-gray-400 leading-relaxed">Masukkan NIK dan nomor HP aktif. Data ini dipakai untuk verifikasi saat pengambilan unit.</p>
                    </div>
                    <div class="relative pl-8">
                        <span class="absolute -left-3.5 top-0 flex items-center justify-center w-7 h-7 bg-[#1a1d26] border border-gray-700 text-gray-400 text-xs font-bold rounded-full">3</span>
                        <h3 class="text-sm font-bold text-white mb-1">Konfirmasi & Bayar</h3>
                        <p class="text-[13px] text-gray-400 leading-relaxed">Tinjau estimasi biaya sewa di checkout, lalu konfirmasi pemesanan dan selesaikan pembayaran.</p>
                    </div>
                    <div class="relative pl-8">
                        <span class="absolute -left-3.5 top-0 flex items-center justify-center w-7 h-7 bg-[#1a1d26] border border-gray-700 text-gray-400 text-xs font-bold rounded-full">4</span>
                        <h3 class="text-sm font-bold text-white mb-1">Ambil Unit</h3>
                        <p class="text-[13px] text-gray-400 leading-relaxed">Datang ke counter GadgetRent sesuai tanggal mulai, tunjukkan invoice dan KTP asli untuk mengambil unit.</p>
                    </div>
                    <div class="relative pl-8">
                        <span class="absolute -left-3.5 top-0 flex items-center justify-center w-7 h-7 bg-[#1a1d26] border border-gray-700 text-amber-500 text-xs font-bold rounded-full border-amber-500/50">5</span>
                        <h3 class="text-sm font-bold text-white mb-1">Kembalikan Tepat Waktu</h3>
                        <p class="text-[13px] text-gray-400 leading-relaxed">Kembalikan unit dalam kondisi baik sebelum tanggal selesai agar status sewa tidak menjadi overdue.</p>
                    </div>
                </div>
            </div>

            <!-- Review (Customer feedback) -->
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Kata Mereka</h2>
                <p class="text-sm text-gray-400 mb-10">Review jujur dari para penyewa setia GadgetRent.</p>

                <div class="space-y-4">
                    <!-- Review 1 -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl hover:border-gray-700 transition">
                        <div class="flex gap-1 text-amber-500 mb-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-[13px] text-gray-300 italic mb-4 leading-relaxed">"Sangat membantu saat butuh kamera untuk project dadakan. Unitnya terawat dengan sangat baik dan proses pengambilannya cepat tanpa ribet."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 border border-indigo-500/50 flex items-center justify-center text-xs font-bold text-indigo-400">AD</div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Andi Darmawan</h4>
                                <p class="text-[10px] text-gray-500">Sewa Sony A7 III</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl hover:border-gray-700 transition">
                        <div class="flex gap-1 text-amber-500 mb-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-[13px] text-gray-300 italic mb-4 leading-relaxed">"Sewa PS5 buat weekend sama teman-teman. Harganya make sense banget dibanding beli baru. Bakal langganan terus!"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-pink-500/20 border border-pink-500/50 flex items-center justify-center text-xs font-bold text-pink-400">SA</div>
                            <div>
                                <h4 class="text-xs font-bold text-white">Siti Aisyah</h4>
                                <p class="text-[10px] text-gray-500">Sewa PlayStation 5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <li><a href="#" class="hover:text-amber-500 transition">Home</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Katalog</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Blog</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Tentang Kami</a></li>
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
                <ul class="space-y-3 text-xs text-gray-400">
                    <li>Jl. Kreatif No. 12, Bandung</li>
                    <li>halo@gadgetrent.id</li>
                    <li>+62 812-3456-7890</li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-800/50 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-[10px] text-gray-600 font-mono">&copy; {{ date('Y') }} GadgetRent. Semua hak dilindungi.</p>
            <div class="flex gap-3">
                <a href="#" class="w-8 h-8 rounded-lg bg-[#1a1d26] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-white hover:border-gray-600 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                </a>
                <a href="#" class="w-8 h-8 rounded-lg bg-[#1a1d26] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-white hover:border-gray-600 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>

