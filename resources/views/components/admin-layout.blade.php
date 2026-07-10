@props(['title' => 'Admin', 'role' => 'ADMIN'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'GadgetRent') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js (dipakai halaman Laporan) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>
</head>
<body class="h-full font-sans antialiased bg-[#0b0e14] text-slate-200" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex flex-col">

        {{-- ================= TOP BAR ================= --}}
        <header class="sticky top-0 z-40 bg-[#12151d] border-b border-white/5">
            <div class="flex items-center justify-between gap-3 px-4 sm:px-6 h-16">

                <div class="flex items-center gap-3">
                    {{-- Mobile hamburger --}}
                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden inline-flex items-center justify-center h-9 w-9 rounded-md text-slate-300 hover:bg-white/5"
                        aria-label="Buka menu"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 shrink-0">
                        <span class="text-amber-500 text-lg">&#9670;</span>
                        <span class="font-bold tracking-wide text-white text-sm sm:text-base whitespace-nowrap">GADGETRENT</span>
                    </a>
                </div>

                {{-- Role pill switcher (visual saja) --}}
                <div class="hidden md:flex items-center bg-[#1c202b] rounded-full p-1 gap-1">
                    @php $role = $role ?? 'ADMIN'; @endphp
                    @foreach (['ADMIN', 'STAFF', 'CUSTOMER'] as $r)
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide transition
                            {{ $role === $r ? 'bg-amber-500 text-black' : 'text-slate-400' }}">
                            {{ $r }}
                        </span>
                    @endforeach
                </div>

                <div class="hidden sm:block text-[11px] text-slate-500 whitespace-nowrap">
                    Panel Admin &mdash; kelola laporan & data peminjaman
                </div>
            </div>
        </header>

        <div class="flex flex-1 min-h-0">

            {{-- ================= SIDEBAR ================= --}}
            {{-- Overlay mobile --}}
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-black/60 lg:hidden"
                style="display: none;"
            ></div>

            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed lg:static z-40 inset-y-0 left-0 top-16 lg:top-0 w-64 shrink-0 bg-[#12151d] border-r border-white/5 overflow-y-auto transition-transform duration-200 ease-out"
            >
                <nav class="py-6 px-3 space-y-6">
                    <div>
                        <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Menu</p>
                        <ul class="space-y-1">
                            @php
                                $menu = [
                                    ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
                                    ['label' => 'Kategori', 'route' => 'admin.kategori', 'icon' => 'grid'],
                                    ['label' => 'Gadget', 'route' => 'admin.gadget', 'icon' => 'device'],
                                    ['label' => 'Rental', 'route' => 'admin.rental', 'icon' => 'list'],
                                    ['label' => 'Pengembalian & Denda', 'route' => 'admin.pengembalian', 'icon' => 'undo'],
                                    ['label' => 'Customer', 'route' => 'admin.customer', 'icon' => 'user'],
                                ];
                            @endphp
                            @foreach ($menu as $item)
                                <li>
                                    <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 hover:bg-white/5 hover:text-white transition">
                                        <x-admin-icon :name="$item['icon']" class="h-4.5 w-4.5 shrink-0" />
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Sistem</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ Route::has('admin.users') ? route('admin.users') : '#' }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 hover:bg-white/5 hover:text-white transition">
                                    <x-admin-icon name="users" class="h-4.5 w-4.5 shrink-0" />
                                    <span>Manajemen User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white bg-white/5 ring-1 ring-white/10">
                                    <x-admin-icon name="report" class="h-4.5 w-4.5 shrink-0 text-amber-500" />
                                    <span>Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside>

            {{-- ================= MAIN CONTENT ================= --}}
            <main class="flex-1 min-w-0 px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>