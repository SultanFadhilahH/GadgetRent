<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - GadgetRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#12141c] text-gray-200 flex flex-col min-h-screen">

    <!-- Navbar -->
    <x-customer-navbar active="catalog" />

    <!-- Header -->
    <section class="px-6 md:px-12 pt-12 pb-6">
        <p class="text-amber-500 font-medium tracking-widest text-[10px] md:text-[11px] uppercase mb-3 flex items-center gap-2">
            <span class="w-6 md:w-8 h-[1px] bg-amber-500"></span> Katalog
        </p>
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">Semua Gadget Tersedia</h1>
        <p class="text-gray-400 text-sm max-w-lg">Jelajahi seluruh unit kamera, laptop, dan konsol game yang siap disewa hari ini.</p>
    </section>

    <!-- Filter & Search -->
    <section class="px-6 md:px-12 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('catalog.index') }}"
                   class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ !request('category_id') ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('catalog.index', array_filter(['category_id' => $cat->id, 'search' => request('search')])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('category_id') == $cat->id ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('catalog.index') }}" method="GET" class="relative">
                @if (request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari gadget atau brand..." class="bg-[#1a1d26] border border-gray-800 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full md:w-72 pl-10 py-2 px-3 text-white">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
        </div>
        <p class="text-[11px] text-gray-500 font-mono tracking-widest lowercase">{{ $totalUnit }} unit total &middot; {{ $gadgets->total() }} hasil ditemukan</p>
    </section>

    <!-- Grid -->
    <section class="flex-1 py-6 px-6 md:px-12 bg-[#12141c]">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse ($gadgets as $gadget)
                @php
                    $statusMap = [
                        'available' => ['bg-emerald-500/10 text-emerald-400 border-emerald-500/20', 'bg-emerald-400', 'available'],
                        'rented' => ['bg-amber-500/10 text-amber-400 border-amber-500/20', 'bg-amber-400', 'disewa'],
                        'maintenance' => ['bg-red-500/10 text-red-400 border-red-500/20', 'bg-red-400', 'maintenance'],
                    ];
                    [$badgeClasses, $dotClass, $statusLabel] = $statusMap[$gadget->status] ?? $statusMap['available'];
                @endphp
                <a href="{{ route('catalog.show', $gadget) }}" class="bg-[#1a1d26] border border-gray-800 rounded-xl overflow-hidden hover:border-gray-600 transition flex flex-col h-full group">
                    <div class="relative bg-[#151821] aspect-square flex flex-col items-center justify-center p-4">
                        <span class="absolute top-3 right-3 {{ $badgeClasses }} text-[9px] font-bold px-2.5 py-1 rounded-full border flex items-center gap-1 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span> {{ $statusLabel }}
                        </span>

                        @if ($gadget->image)
                            <img src="{{ asset('images/gadgets/'.$gadget->image) }}" alt="{{ $gadget->name }}" class="w-full h-full object-cover">
                        @elseif (strtolower($gadget->category->name ?? '') == 'kamera')
                            <svg class="w-14 h-14 text-gray-600 group-hover:text-gray-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        @elseif (strtolower($gadget->category->name ?? '') == 'laptop')
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
                            <p class="text-sm font-bold text-white">Rp {{ number_format($gadget->price_per_day, 0, ',', '.') }}<span class="text-[9px] text-gray-500 font-normal"> /hari</span></p>
                            @if ($gadget->status == 'available')
                                <span class="bg-amber-500 group-hover:bg-amber-600 text-[#12141c] text-xs font-bold px-3 py-1.5 rounded transition">Sewa</span>
                            @else
                                <span class="bg-gray-800 text-gray-500 text-xs font-bold px-3 py-1.5 rounded">Sewa</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 text-gray-500 text-sm">
                    Tidak ada gadget yang cocok dengan pencarianmu.
                </div>
            @endforelse
        </div>

        @if ($gadgets->hasPages())
            <div class="mt-10">
                {{ $gadgets->links() }}
            </div>
        @endif
    </section>

    <!-- Footer -->
    <footer class="bg-[#0b0c10] pt-12 pb-8 px-6 md:px-12 border-t border-gray-900 mt-auto">
        <div class="flex items-center justify-center">
            <p class="text-[10px] text-gray-600 font-mono">&copy; {{ date('Y') }} GadgetRent. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
