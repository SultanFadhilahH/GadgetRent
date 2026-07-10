<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GadgetRent') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#12141c] text-gray-200">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-[#1a1d26] border-r border-gray-800 flex flex-col justify-between">
            <div>
                <div class="h-16 flex items-center px-6 border-b border-gray-800 gap-2">
                    <span class="text-amber-500 text-xl">◆</span>
                    <span class="font-bold tracking-wider text-white">GADGETRENT</span>
                </div>

                <nav class="p-4 space-y-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#222632] hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#222632] hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z"/></svg>
                                    <span>Kategori</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.gadgets.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.gadgets.*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span>Gadget</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.rentals.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.rentals.*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Rental</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#222632] hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    <span>Pengembalian & Denda</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-[#222632] hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Customer</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sistem</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <span>Manajemen User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.laporan*') ? 'bg-[#222632] text-white border-l-4 border-amber-500 rounded-l-none' : 'text-gray-400 hover:bg-[#222632] hover:text-white transition' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-800 bg-[#151821]">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center font-bold text-[#12141c]">
                        {{ substr(Auth::user()->name ?? 'AT', 0, 2) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Admin Toko' }}</h4>
                        <p class="text-xs text-gray-500">Admin · {{ Auth::user()->email ?? 'admin@example.com' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="h-16 flex items-center justify-end px-8 bg-[#12141c]">
                </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>
