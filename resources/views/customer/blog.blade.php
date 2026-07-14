<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - GadgetRent</title>
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
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <a href="{{ route('catalog.index') }}" class="hover:text-white transition">Katalog</a>
            <a href="{{ route('blog.index') }}" class="text-white border-b-2 border-amber-500 pb-1">Blog</a>
            <a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami</a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-3 hover:opacity-80 transition focus:outline-none">
                        <div class="h-9 w-9 bg-amber-500 rounded-lg flex items-center justify-center text-[#12141c] font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-bold text-white hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 hidden sm:block transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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
                <a href="{{ route('login') }}" class="bg-amber-500 hover:bg-amber-600 text-[#12141c] font-bold text-sm px-5 py-2 rounded-lg transition">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <!-- Header -->
    <section class="px-6 md:px-12 pt-12 pb-8">
        <p class="text-amber-500 font-medium tracking-widest text-[10px] md:text-[11px] uppercase mb-3 flex items-center gap-2">
            <span class="w-6 md:w-8 h-[1px] bg-amber-500"></span> Blog & Artikel
        </p>
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">Berita & Panduan Terbaru</h1>
        <p class="text-gray-400 text-sm max-w-lg">Baca ulasan, tips merawat gadget, dan berita teknologi terkini dari sumber terpercaya.</p>
    </section>

    <!-- Grid -->
    <section class="flex-1 py-6 px-6 md:px-12 bg-[#12141c]">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($blogs as $blog)
                <a href="{{ $blog->external_link }}" target="_blank" class="bg-[#1a1d26] border border-gray-800 rounded-xl overflow-hidden hover:border-gray-600 transition flex flex-col h-full group -translate-y-0 hover:-translate-y-1">
                    <div class="relative bg-[#151821] aspect-video flex flex-col items-center justify-center border-b border-gray-800 overflow-hidden w-full">
                        @if ($blog->image_url)
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-600 group-hover:text-gray-400 transition relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-[10px] text-amber-500 font-bold uppercase tracking-wider mb-2 font-mono">{{ $blog->category }}</p>
                        <h3 class="text-base font-bold text-white mb-2 line-clamp-2 leading-tight group-hover:text-amber-400 transition" title="{{ $blog->title }}">{{ $blog->title }}</h3>
                        <p class="text-[12.5px] text-gray-400 mb-4 line-clamp-3 leading-relaxed">{{ $blog->excerpt }}</p>
                        <div class="mt-auto pt-4 border-t border-gray-800 border-dashed flex items-center justify-between">
                            <span class="text-[11px] text-gray-500 font-mono">{{ $blog->published_at ? $blog->published_at->diffForHumans() : '' }}</span>
                            <span class="text-[11px] text-amber-500 font-medium flex items-center gap-1 group-hover:underline">
                                Baca Artikel
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 text-gray-500 text-sm">
                    Belum ada artikel blog yang diterbitkan.
                </div>
            @endforelse
        </div>

        @if ($blogs->hasPages())
            <div class="mt-10">
                {{ $blogs->links() }}
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
