@props(['active' => null])

<nav class="border-b border-gray-800 bg-[#12141c] py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
    <a href="{{ url('/') }}" class="flex items-center gap-2">
        <span class="flex h-4 w-4 rotate-45 items-center justify-center rounded-sm bg-amber-500"></span>
        <span class="text-sm font-bold tracking-wide text-white uppercase">GADGETRENT</span>
    </a>

    <div class="hidden md:flex gap-8 text-sm font-medium text-gray-400">
        <a href="{{ url('/') }}" class="{{ $active === 'home' ? 'text-white border-b-2 border-amber-500 pb-1' : 'hover:text-white transition' }}">Home</a>
        <a href="{{ route('catalog.index') }}" class="{{ $active === 'catalog' ? 'text-white border-b-2 border-amber-500 pb-1' : 'hover:text-white transition' }}">Katalog</a>
        <a href="{{ route('blog.index') }}" class="{{ $active === 'blog' ? 'text-white border-b-2 border-amber-500 pb-1' : 'hover:text-white transition' }}">Blog</a>
        <a href="{{ route('about') }}" class="{{ $active === 'about' ? 'text-white border-b-2 border-amber-500 pb-1' : 'hover:text-white transition' }}">Tentang Kami</a>
    </div>

    <div class="flex items-center gap-4">
        <x-navbar-cart />
        <x-navbar-return-reminder />

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
