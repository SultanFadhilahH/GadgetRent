<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - GadgetRent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-[#12141c] text-gray-300 min-h-screen flex flex-col justify-between antialiased">

    <div>
        <nav class="bg-[#12141c] border-b border-gray-800/60 sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">

                <div class="flex items-center gap-2">
                    <span class="text-amber-500 text-sm">◆</span>
                    <span class="font-bold tracking-wider text-white text-sm font-display">GADGETRENT</span>
                </div>

                <div class="flex items-center space-x-6 text-xs font-medium">
                    <a href="#" class="text-gray-400 hover:text-white transition">Home</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Katalog</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Blog</a>
                    <a href="{{ route('customer.about') }}" class="text-white relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-amber-500 font-semibold">
                        Tentang Kami
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    @include('components.navbar-cart')

                    <div class="w-7 h-7 bg-amber-500 text-[#12141c] font-bold text-xs flex items-center justify-center rounded-lg shadow-sm">
                        {{ substr(Auth::user()->name ?? 'BS', 0, 2) }}
                    </div>
                </div>

            </div>
        </nav>

        <main class="max-w-5xl mx-auto space-y-12 py-12 px-4">

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

            <div class="space-y-3">
                <div class="text-[9px] font-bold text-amber-500 uppercase tracking-widest font-display">Kisah Kami</div>
                <div class="bg-[#1a1d26] border border-gray-800 p-6 rounded-xl shadow-sm">
                    <p class="text-xs text-gray-400 leading-relaxed font-normal">
                        GadgetRent lahir dari kebutuhan sederhana: banyak orang hanya perlu gadget bagus untuk beberapa hari, bukan untuk selamanya. Daripada membeli kamera atau laptop mahal yang jarang dipakai, kami menyediakan unit siap pakai dengan proses sewa yang cepat dan transparan — mirip alur tiket, tinggal ambil, pakai, lalu kembalikan. Berawal dari satu kota, kami terus menambah unit dan memperbaiki pengalaman sewa agar makin mudah dipercaya.
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="text-[9px] font-bold text-amber-500 uppercase tracking-widest font-display">Kenapa Kami</div>
                    <h2 class="text-base font-bold text-white font-display tracking-wide">Mengapa Memilih Kami</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Harga Transparan</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Biaya sewa, perlindungan, dan layanan ditampilkan jelas sejak awal — tanpa biaya tersembunyi di akhir.
                        </p>
                    </div>
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Unit Terawat</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Setiap gadget dicek kondisinya sebelum dan sesudah disewa, jadi kamu selalu dapat unit yang siap pakai.
                        </p>
                    </div>
                    <div class="bg-[#1a1d26] border border-gray-800 p-5 rounded-xl space-y-2.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-white text-xs tracking-wide">Proses Cepat</h3>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Pilih tanggal, konfirmasi, ambil unit di counter — alur sewa kami dirancang seringkas mungkin dari awal sampai akhir.
                        </p>
                    </div>
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

            <div class="space-y-4 pt-4">
                <div class="space-y-1">
                    <div class="text-[25px] font-bold text-amber-500 uppercase tracking-widest font-display">Lokasi Kami</div>
                    <h2 class="text-base font-bold text-white font-display tracking-wide"></h2>
                </div>
                <div class="bg-[#1a1d26] border border-gray-800 p-2 rounded-2xl overflow-hidden shadow-md">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5513759325694!2d107.68417937510103!3d-6.944081093056086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c2b7ca9069d3%3A0xed499ed711eb677f!2sUniversitas%20Muhammadiyah%20Bandung!5e0!3m2!1sid!2sid!4v1716380000000!5m2!1sid!2sid"
                        width="100%"
                        height="380"
                        style="border:0; border-radius: 12px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- ================= BUTTON SOSIAL MEDIA YANG DIURUTKAN & DIPERBESAR ================= -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Button Instagram -->
                    <a href="https://www.instagram.com/fachri_fatriann/" target="_blank" class="flex items-center justify-center gap-3 bg-[#1a1d26] border border-gray-800 rounded-xl py-3.5 px-6 font-medium text-sm text-gray-300 hover:text-white hover:bg-[#222632] hover:border-amber-500/50 transition duration-300 shadow-sm group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                        <span>Follow Instagram</span>
                    </a>

                    <!-- Button WhatsApp -->
                    <a href="https://wa.me/628996845669" target="_blank" class="flex items-center justify-center gap-3 bg-[#1a1d26] border border-gray-800 rounded-xl py-3.5 px-6 font-medium text-sm text-gray-300 hover:text-white hover:bg-[#222632] hover:border-amber-500/50 transition duration-300 shadow-sm group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>Hubungi Via WhatsApp Hub</span>
                    </a>
                </div>
            </div>

        </main>
    </div>

    <footer class="bg-[#12141c] border-t border-gray-800/60 mt-20 pt-16 pb-8 px-4">
        <div class="max-w-6xl mx-auto space-y-12">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-500 text-sm">◆</span>
                        <span class="font-bold tracking-wider text-white text-sm font-display">GADGETRENT</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed font-normal">
                        Sewa kamera, laptop, dan konsol game harian dengan proses klaim seperti tiket — tinggal ambil, pakai, kembalikan.
                    </p>
                </div>

                <div class="space-y-3">
                    <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest font-display">Navigasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Katalog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="{{ route('customer.about') }}" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest font-display">Bantuan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Informasi Customer</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Checkout</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest font-display">Kontak</h4>
                    <ul class="space-y-2 text-xs text-gray-400">
                        <li>Jl. Soekarno Hatta No.752, Cipadung Kidul, Gedebage, Bandung</li>
                        <li>halo@gadgetrent.id</li>
                        <li>+62 899-684-5669</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800/40 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-gray-500">
                <div>
                    © 2026 GadgetRent. Semua hak dilindungi.
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
