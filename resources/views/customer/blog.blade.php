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
    <x-customer-navbar active="blog" />

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
