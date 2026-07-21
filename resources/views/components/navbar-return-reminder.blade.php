@php
    $activeRentals = collect();
    $overdueCount = 0;
    $dueSoonCount = 0;

    if (auth()->check()) {
        $today = \Carbon\Carbon::today();

        $activeRentals = \App\Models\Rental::with('gadget')
            ->where('user_id', auth()->id())
            ->where('status', 'ongoing')
            ->whereNull('actual_return_date')
            ->orderBy('end_date')
            ->get()
            ->map(function ($rental) use ($today) {
                $endDate = \Carbon\Carbon::parse($rental->end_date)->startOfDay();
                $rental->days_left = $today->diffInDays($endDate, false);
                $rental->is_overdue = $rental->days_left < 0;
                return $rental;
            });

        $overdueCount = $activeRentals->where('is_overdue', true)->count();
        $dueSoonCount = $activeRentals->where('is_overdue', false)->where('days_left', '<=', 2)->count();
    }

    $notifCount = $overdueCount + $dueSoonCount;
@endphp

@auth
<!-- Dropdown Reminder Pengembalian -->
<div class="relative" x-data="{ remindOpen: false }" @click.outside="remindOpen = false">
    <button @click="remindOpen = !remindOpen" class="relative flex items-center gap-2 text-sm font-medium bg-[#1a1d26] border border-gray-700 px-3 py-2 rounded-lg hover:bg-gray-800 transition focus:outline-none" title="Reminder Pengembalian">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        @if($notifCount > 0)
            <span class="absolute -top-1.5 -right-1.5 {{ $overdueCount > 0 ? 'bg-red-500' : 'bg-amber-500' }} text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold">{{ $notifCount }}</span>
        @endif
    </button>

    <div
        x-show="remindOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-[#1a1d26] border border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden"
        x-cloak
    >
        <div class="p-4 border-b border-gray-800">
            <h4 class="text-sm font-bold text-white">Reminder Pengembalian</h4>
            <p class="text-[11px] text-gray-500 mt-0.5">Cek jadwal pengembalian gadget yang kamu sewa</p>
        </div>
        <div class="p-2 max-h-72 overflow-y-auto">
            @forelse($activeRentals as $rental)
                <div class="flex items-center gap-3 p-2 hover:bg-gray-800/50 rounded-lg transition">
                    <div class="w-10 h-10 bg-[#12141c] rounded border border-gray-700 flex items-center justify-center shrink-0 overflow-hidden">
                        @if($rental->gadget->image)
                            <img src="{{ asset('images/gadgets/'.$rental->gadget->image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        <h5 class="text-xs font-bold text-white leading-tight truncate">{{ $rental->gadget->name }}</h5>
                        <p class="text-[10px] text-gray-500 mt-0.5">Batas: {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        @if($rental->is_overdue)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20 whitespace-nowrap">
                                Telat {{ abs($rental->days_left) }} hari
                            </span>
                        @elseif($rental->days_left == 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 whitespace-nowrap">
                                Kembalikan hari ini
                            </span>
                        @elseif($rental->days_left <= 2)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 whitespace-nowrap">
                                H-{{ $rental->days_left }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-700/30 text-gray-400 border border-gray-700/50 whitespace-nowrap">
                                Sisa {{ $rental->days_left }} hari
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 text-xs">
                    Tidak ada sewa aktif yang perlu dikembalikan
                </div>
            @endforelse
        </div>
        @if($overdueCount > 0)
        <div class="p-3 border-t border-gray-800 bg-red-500/5">
            <p class="text-[11px] text-red-400 text-center font-medium">
                {{ $overdueCount }} gadget sudah lewat batas waktu, segera kembalikan.
            </p>
        </div>
        @endif
    </div>
</div>
@endauth
