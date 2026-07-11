<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - GadgetRent</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-[#12141c] text-gray-300 min-h-screen flex flex-col justify-between antialiased">

    <div>
        <!-- ================= NAVBAR ATAS CUSTOMER ================= -->
        <nav class="bg-[#12141c] border-b border-gray-800/60 sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">

                <!-- LOGO GADGETRENT -->
                <div class="flex items-center gap-2">
                    <span class="text-amber-500 text-sm">◆</span>
                    <span class="font-bold tracking-wider text-white text-sm font-display">GADGETRENT</span>
                </div>

                <!-- MENU NAVIGASI TENGAH -->
                <div class="flex items-center space-x-6 text-xs font-medium">
                    <a href="/" class="text-gray-400 hover:text-white transition">Home</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Katalog</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Blog</a>
                    <a href="{{ route('about') }}" class="text-white relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-amber-500 font-semibold">
                        Tentang Kami
                    </a>
                </div>

                <!-- KANAN: KERANJANG & USER PROFILE -->
                <div class="flex items-center gap-3">
                    <button class="relative flex items-center gap-2 bg-[#1a1d26] border border-gray-800 px-3 py-1.5 rounded-lg text-xs text-white font-medium hover:bg-[#222632] transition">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <span>Keranjang</span>
                        <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-amber-500 text-[#12141c] text-[9px] font-bold rounded-full flex items-center justify-center">
                            2
                        </span>
                    </button>

                    <div class="w-7 h-7 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-lg shadow-sm">
                        {{ substr(Auth::user()->name ?? 'BS', 0, 2) }}
                    </div>
                </div>

            </div>
        </nav>

        <!-- ================= MAIN CONTENT ================= -->
        <main class="max-w-5xl mx-auto space-y-12 py-12 px-4">

            <!-- SECTION 1: HERO CONTAINER -->
            <div class="relative bg-[#1a1d26] border border-gray-800 p-8 md:p-12 rounded-2xl overflow-hidden shadow-xl">
                <div class="max-w-2xl space-y-4 relative z-10">
                    <div class="flex items-center gap-2 text-[10px] font-bold text-amber-500 uppercase tracking-widest font-display">
                        <span class="w-4 h-[1px] bg-amber-500"></span> Tentang Kami
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight font-display">
                        Kenalan dengan <br>GadgetRent
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 leading-relaxed font-normal">
                        Kami membantu kreator, pekerja, dan gamer mengakses gadget berkualitas tanpa perlu membeli unit baru — cukup sewa, pakai, kembalikan.
                    </p>
                </div>
            </div>

            <!-- SECTION 2: STATISTIK ANGKA -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 py-2 border-b border-gray-800/40">
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-white font-display tracking-tight">2026</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Berdiri Sejak</p>
                </div>
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-white font-display tracking-tight">5</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Unit Tersedia</p>
                </div>
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-white font-display tracking-tight">4.9</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Rating Penyewa</p>
                </div>
                <div class="space-y-1">
                    <h2 class="text-xl font-bold text-white font-display tracking-tight">1</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Kota Layanan</p>
                </div>
            </div>

            <!-- SECTION 3: KISAH KAMI -->
            <div class="space-y-3">
                <div class="text-[9px] font-bold text-amber-500 uppercase tracking-widest font-display">Kisah Kami</div>
                <div class="bg-[#1a1d26] border border-gray-800 p-6 rounded-xl shadow-sm">
                    <p class="text-xs text-gray-400 leading-relaxed font-normal">
                        GadgetRent lahir dari kebutuhan sederhana: banyak orang hanya perlu gadget bagus untuk beberapa hari, bukan untuk selamanya. Daripada membeli kamera atau laptop mahal yang jarang dipakai, kami menyediakan unit siap pakai dengan proses sewa yang cepat dan transparan — mirip alur tiket, tinggal ambil, pakai, lalu kembalikan. Berawal dari satu kota, kami terus menambah unit dan memperbaiki pengalaman sewa agar makin mudah dipercaya.
                    </p>
                </div>
            </div>

            <!-- SECTION 4: MENGAPA MEMILIH KAMI -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="text-[9px] font-bold text-amber-500 uppercase tracking-widest font-display">Kenapa Kami</div>
                    <h2 class="text-base font-bold text-white font-display tracking-wide">Mengapa Memilih Kami</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Card 1: Harga Transparan -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Harga Transparan</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Biaya sewa, perlindungan, dan layanan ditampilkan jelas sejak awal — tanpa biaya tersembunyi di akhir.
                        </p>
                    </div>
                    <!-- Card 2: Terawat -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Unit Terawat</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Setiap gadget dicek kondisinya sebelum dan sesudah disewa, jadi kamu selalu dapat unit yang siap pakai.
                        </p>
                    </div>
                    <!-- Card 3: Proses Cepat -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Proses Cepat</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Pilih tanggal, konfirmasi, ambil unit di counter — alur sewa kami dirancang seringkas mungkin dari awal sampai akhir.
                        </p>
                    </div>
                    <!-- Card 4: Dukungan -->
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Dukungan Responsif</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Tim kami siap membantu lewat WhatsApp maupun counter kalau ada kendala sebelum, saat, atau sesudah sewa.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 5: TIM KAMI -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="text-[9px] font-bold text-amber-500 uppercase tracking-widest font-display">Orang di Balik GadgetRent</div>
                    <h2 class="text-base font-bold text-white font-display tracking-wide">Tim Kami</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl flex flex-col items-center text-center space-y-3">
                        <div class="w-11 h-11 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-xl font-display">SFH</div>
                        <div>
                            <h4 class="font-bold text-white text-xs tracking-wide">Sultan Fadilah H</h4>
                            <p class="text-[10px] text-gray-500">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl flex flex-col items-center text-center space-y-3">
                        <div class="w-11 h-11 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-xl font-display">FFN</div>
                        <div>
                            <h4 class="font-bold text-white text-xs tracking-wide">Fachri Fatrian N</h4>
                            <p class="text-[10px] text-gray-500">Operations Lead</p>
                        </div>
                    </div>
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl flex flex-col items-center text-center space-y-3">
                        <div class="w-11 h-11 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-xl font-display">DSD2</div>
                        <div>
                            <h4 class="font-bold text-white text-xs tracking-wide">Darel Safana D</h4>
                            <p class="text-[10px] text-gray-500">Customer Support Lead</p>
                        </div>
                    </div>
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl flex flex-col items-center text-center space-y-3">
                        <div class="w-11 h-11 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-xl font-display">DSD1</div>
                        <div>
                            <h4 class="font-bold text-white text-xs tracking-wide">Darel Safana D</h4>
                            <p class="text-[10px] text-gray-500">Fleet & Maintenance Lead</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

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
                    <li><a href="#" class="hover:text-amber-500 transition">Katalog</a></li>
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
            <div id="tentang-kami">
                <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-4">Kontak</h3>
                <ul class="space-y-3 text-xs text-gray-400 mb-5">
                    <li class="flex items-start gap-2">
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
                <div class="flex gap-2">
                    <a href="#" title="Instagram" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-pink-400 hover:border-pink-500/40 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="#" title="TikTok" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-white hover:border-gray-600 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                    <a href="#" title="WhatsApp" class="w-8 h-8 rounded-lg bg-[#12141c] border border-gray-800 flex items-center justify-center text-gray-500 hover:text-green-400 hover:border-green-500/40 transition">
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
