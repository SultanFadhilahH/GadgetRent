<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') &mdash; GadgetRent</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#12141c] text-gray-200" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen lg:flex">

        {{-- ============ SIDEBAR ============ --}}
        <div
            class="fixed inset-0 z-40 bg-black/60 lg:hidden"
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            @click="sidebarOpen = false"
        ></div>

        <aside class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 transform bg-[#1a1d26] border-r border-gray-800 transition-transform duration-200 ease-in-out lg:static lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>
            <div class="flex h-full flex-col">
                <!-- Logo -->
                <div class="flex items-center gap-2 px-6 py-5">
                    <span class="flex h-6 w-6 rotate-45 items-center justify-center rounded-md bg-amber-500"></span>
                    <span class="text-sm font-bold tracking-wide text-white">GADGETRENT</span>
                </div>

                <nav class="flex-1 overflow-y-auto px-4 pb-6">
                    <p class="px-2 pb-2 pt-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Menu</p>
                    <ul class="space-y-1">
                        @php
                            // Sesuaikan nama rute dengan web.php
                            $menu = [
                                ['label' => 'Dashboard',            'route' => 'admin.dashboard',         'icon' => 'home'],
                                ['label' => 'Kategori',             'route' => 'admin.categories.index',  'icon' => 'grid'],
                                ['label' => 'Gadget',               'route' => 'admin.gadgets.index',     'icon' => 'device'],
                                ['label' => 'Rental',               'route' => 'admin.rentals.index',     'icon' => 'file'],
                                ['label' => 'Pengembalian & Denda', 'route' => null,                      'icon' => 'refresh'],
                                ['label' => 'Customer',             'route' => 'admin.customers.index',   'icon' => 'users'],
                            ];
                        @endphp

                        @foreach ($menu as $item)
                            @php
                                $isActive = $item['route'] && (
                                    request()->routeIs($item['route'])
                                    || ($item['route'] === 'admin.dashboard' && request()->routeIs('dashboard'))
                                    || (str_contains((string)$item['route'], 'gadgets')    && request()->routeIs('admin.gadgets.*'))
                                    || (str_contains((string)$item['route'], 'rentals')    && request()->routeIs('admin.rentals.*'))
                                    || (str_contains((string)$item['route'], 'categories') && request()->routeIs('admin.categories.*'))
                                    || (str_contains((string)$item['route'], 'customers')  && request()->routeIs('admin.customers.*'))
                                );
                                $href = $item['route'] ? route($item['route']) : '#';
                            @endphp
                            <li>
                                <a href="{{ $href }}"
                                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                                    {{ $isActive ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}"
                                >
                                    <x-admin-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <p class="px-2 pb-2 pt-6 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Sistem</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                <x-admin-icon name="user-cog" class="h-5 w-5 shrink-0" />
                                <span>Manajemen User</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.laporan*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                <x-admin-icon name="report" class="h-5 w-5 shrink-0" />
                                <span>Laporan</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User card -->
                <div class="border-t border-gray-800 bg-[#151821] px-4 py-4">
                    <div class="flex items-center gap-3 rounded-lg px-2 py-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-500 text-xs font-bold text-slate-950">
                            {{ strtoupper(substr(auth()->user()->name ?? 'AT', 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin Toko' }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()?->getRoleNames()->first() ?? 'Admin' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Keluar" class="text-slate-500 hover:text-slate-300">
                                <x-admin-icon name="logout" class="h-5 w-5" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ============ MAIN ============ --}}
        <div class="flex min-w-0 flex-1 flex-col">

            {{-- Topbar --}}
            <header class="sticky top-0 z-30 border-b border-gray-800 bg-[#12141c]/95 backdrop-blur">
                <div class="flex items-center gap-3 px-4 py-3 sm:px-6">
                    <button class="text-slate-400 hover:text-white lg:hidden" @click="sidebarOpen = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex flex-1 justify-center sm:justify-center">
                        <!-- Role indicator removed -->
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 4000)"
                        x-transition
                        class="mb-6 flex items-start justify-between gap-3 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300"
                    >
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-200">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
