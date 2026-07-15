<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $gadget->name }} - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#12141c] text-gray-200 flex flex-col min-h-screen">

    <!-- Navbar -->
    <x-customer-navbar active="catalog" />

    @php
        $statusMap = [
            'available' => ['bg-emerald-500/10 text-emerald-400 border-emerald-500/20', 'bg-emerald-400', 'available'],
            'rented' => ['bg-amber-500/10 text-amber-400 border-amber-500/20', 'bg-amber-400', 'disewa'],
            'maintenance' => ['bg-red-500/10 text-red-400 border-red-500/20', 'bg-red-400', 'maintenance'],
        ];
        [$badgeClasses, $dotClass, $statusLabel] = $statusMap[$gadget->status] ?? $statusMap['available'];

        $icons = [
            'kamera' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z',
            'laptop' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ];
        $iconPath = $icons[strtolower($gadget->category->name ?? '')] ?? 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z';

        $reviews = [
            ['name' => 'Budi Santoso', 'stars' => 5, 'date' => now()->subDays(9)->translatedFormat('d M Y'), 'text' => 'Unitnya bersih dan lengkap sama box aslinya. Baterai awet dipakai seharian buat hunting foto. Proses ambil di hub juga cepat.'],
            ['name' => 'Siti Rahayu', 'stars' => 5, 'date' => now()->subDays(16)->translatedFormat('d M Y'), 'text' => 'Kondisi unit mulus, hasil sewa sesuai ekspektasi. Bakal sewa lagi kalau butuh unit yang sama.'],
            ['name' => 'Andi Ramadhan', 'stars' => 4, 'date' => now()->subDays(29)->translatedFormat('d M Y'), 'text' => 'Overall bagus, cuma pas dikirim agak telat 1 jam dari jadwal. Unitnya sendiri berfungsi normal semua.'],
        ];
        $ratingBreakdown = [5 => 19, 4 => 3, 3 => 1, 2 => 0, 1 => 1];
        $totalReviews = array_sum($ratingBreakdown);
        $maxBar = max($ratingBreakdown);
    @endphp

    <section class="flex-1 px-6 md:px-12 py-8">
        <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition mb-6">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Katalog
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Galeri -->
            <div>
                <div class="relative bg-[#1a1d26] border border-gray-800 rounded-xl aspect-square flex items-center justify-center mb-4 overflow-hidden">
                    <span class="absolute top-4 left-4 {{ $badgeClasses }} text-[10px] font-bold px-2.5 py-1 rounded-full border flex items-center gap-1 uppercase tracking-wider z-10">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span> {{ $statusLabel }}
                    </span>
                    @if ($gadget->image)
                        <img src="{{ asset('images/gadgets/'.$gadget->image) }}" alt="{{ $gadget->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-28 h-28 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="{{ $iconPath }}"></path></svg>
                    @endif
                </div>
                <div class="grid grid-cols-3 gap-4">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-[#1a1d26] border border-gray-800 rounded-xl aspect-square flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="{{ $iconPath }}"></path></svg>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Info -->
            <div>
                <p class="text-amber-500 font-medium tracking-widest text-[11px] uppercase mb-2">{{ $gadget->category->name ?? 'Lainnya' }}</p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">{{ $gadget->name }}</h1>
                <p class="text-sm text-gray-400 mb-4">{{ $gadget->brand }} &middot; {{ $gadget->category->name ?? 'Lainnya' }}</p>

                <div class="flex items-center gap-2 mb-5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium border {{ $badgeClasses }}">
                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $dotClass }}"></span> {{ $statusLabel }}
                    </span>
                    <span class="font-mono text-xs text-gray-500">{{ $gadget->serial_number }}</span>
                </div>

                @if ($gadget->description)
                    <p class="text-sm text-gray-300 leading-relaxed mb-5">{{ $gadget->description }}</p>
                @endif

                @if (!empty($gadget->specs))
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach ($gadget->specs as $spec)
                            <span class="bg-[#1a1d26] border border-gray-800 text-[11px] text-gray-300 px-2.5 py-1 rounded font-mono">{{ $spec }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="bg-[#1a1d26] border border-gray-800 rounded-lg px-4 py-3 flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-400">Harga Sewa</span>
                    <span class="text-lg font-bold text-white">Rp {{ number_format($gadget->price_per_day, 0, ',', '.') }}<span class="text-xs text-gray-500 font-normal"> / hari</span></span>
                </div>

                <p class="text-xs text-gray-500 mb-5 leading-relaxed">Tanggal sewa, durasi, dan opsi perlindungan bisa kamu atur nanti di halaman Checkout.</p>

                <div class="flex flex-wrap gap-3 mb-10">
                    @if ($gadget->status == 'available')
                        <form action="{{ route('checkout.direct', $gadget->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold px-6 py-2.5 rounded-lg transition text-sm">Pinjam Sekarang</button>
                        </form>
                        <form action="{{ route('cart.store') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="gadget_id" value="{{ $gadget->id }}">
                            <button type="submit" class="bg-[#1a1d26] border border-gray-700 hover:bg-gray-800 text-white font-bold px-6 py-2.5 rounded-lg transition text-sm">Tambah ke Keranjang</button>
                        </form>
                    @else
                        <button type="button" disabled class="bg-gray-800 text-gray-500 font-bold px-6 py-2.5 rounded-lg text-sm cursor-not-allowed">Unit Sedang Tidak Tersedia</button>
                    @endif
                </div>

                <!-- Ulasan Pembeli -->
                <div>
                    <h2 class="text-base font-bold text-white mb-4">Ulasan Pembeli</h2>
                    <div class="flex items-start gap-6 mb-6">
                        <div>
                            <p class="text-3xl font-bold text-white">4.8</p>
                            <div class="flex gap-0.5 text-amber-500 my-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <p class="text-[11px] text-gray-500">{{ $totalReviews }} ulasan</p>
                        </div>
                        <div class="flex-1 max-w-xs space-y-1.5 mt-1">
                            @foreach ($ratingBreakdown as $star => $count)
                                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                                    <span class="w-2">{{ $star }}</span>
                                    <div class="flex-1 h-1.5 bg-[#1a1d26] rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500" style="width: {{ $maxBar > 0 ? ($count / $maxBar) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="w-4 text-right">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($reviews as $review)
                            <div class="bg-[#1a1d26] border border-gray-800 p-4 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-indigo-500/20 border border-indigo-500/50 flex items-center justify-center text-[10px] font-bold text-indigo-400">
                                            {{ strtoupper(substr($review['name'], 0, 1)).strtoupper(substr(strrchr($review['name'], ' ') ?: '', 1, 1)) }}
                                        </div>
                                        <span class="text-xs font-bold text-white">{{ $review['name'] }}</span>
                                    </div>
                                    <span class="text-[10px] text-gray-500">{{ $review['date'] }}</span>
                                </div>
                                <div class="flex gap-0.5 text-amber-500 mb-2">
                                    @for ($i = 0; $i < $review['stars']; $i++)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <p class="text-[13px] text-gray-300 leading-relaxed">{{ $review['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0b0c10] pt-12 pb-8 px-6 md:px-12 border-t border-gray-900 mt-auto">
        <div class="flex items-center justify-center">
            <p class="text-[10px] text-gray-600 font-mono">&copy; {{ date('Y') }} GadgetRent. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
