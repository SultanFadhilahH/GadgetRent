@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Judul Halaman -->
    <div>
        <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-xs text-gray-400 mt-1">Selamat datang kembali di panel manajemen GadgetRent.</p>
    </div>

    <!-- Kotak Pesan Logged In -->
    <div class="overflow-hidden rounded-xl border border-gray-800 bg-[#1a1d26] shadow-sm">
        <div class="p-6 text-gray-300">
            <div class="flex items-center gap-3">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ __("You're logged in!") }} Selamat bekerja, {{ auth()->user()->name }}.</span>
            </div>
        </div>
    </div>
</div>
@endsection