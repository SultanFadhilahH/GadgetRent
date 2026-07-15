@extends('layouts.admin')

@section('title', 'Pengembalian & Denda')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Pengembalian & Denda</h1>
            <p class="text-sm text-gray-400 mt-1">Proses pengembalian unit dan hitung denda keterlambatan</p>
        </div>
        <form action="{{ route('admin.returns.index') }}" method="GET" class="relative">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama customer atau gadget..." class="bg-[#1a1d26] border border-gray-800 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-72 pl-10 py-2 px-3 text-white">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
        </form>
    </div>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.returns.index') }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ !request('status') ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Semua Aktif
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'ongoing']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('status') == 'ongoing' ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Ongoing
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'overdue']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('status') == 'overdue' ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Overdue
        </a>
    </div>

    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
            <h3 class="font-semibold text-white text-sm tracking-wide">Rental Aktif</h3>
            <span class="text-xs text-gray-500">{{ $totalAktif }} rental belum dikembalikan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Invoice</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Gadget</th>
                        <th class="px-6 py-3">Jatuh Tempo</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Estimasi Denda</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse ($rentals as $rental)
                        @php
                            $endDate = \Carbon\Carbon::parse($rental->end_date)->startOfDay();
                            $today = \Carbon\Carbon::today();
                            $lateDaysNow = $today->greaterThan($endDate) ? $endDate->diffInDays($today) : 0;
                            $estimasiDenda = $lateDaysNow * $rental->gadget->price_per_day;
                            $processData = [
                                'id' => $rental->id,
                                'invoice_code' => $rental->invoice_code,
                                'customer_name' => $rental->customer->name ?? $rental->user->name ?? '-',
                                'gadget_name' => $rental->gadget->name,
                                'start_date' => $rental->start_date,
                                'end_date' => $rental->end_date,
                                'price_per_day' => $rental->gadget->price_per_day,
                                'action' => route('admin.returns.process', $rental),
                            ];
                        @endphp
                        <tr class="hover:bg-[#1f232e]/30 transition">
                            <td class="px-6 py-4 font-mono text-xs text-gray-300 font-semibold">{{ $rental->invoice_code }}</td>
                            <td class="px-6 py-4 text-white font-medium">{{ $rental->customer->name ?? $rental->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $rental->gadget->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($rental->status == 'ongoing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-amber-400 rounded-full"></span> ongoing
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-red-400 rounded-full"></span> overdue
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($estimasiDenda > 0)
                                    <span class="text-red-400 font-semibold">Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</span>
                                    <span class="block text-[10px] text-gray-500">{{ $lateDaysNow }} hari telat</span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    onclick='openProcessModal(@json($processData))'
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] text-xs font-bold px-3 py-1.5 transition"
                                >
                                    Proses Pengembalian
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak ada rental aktif yang perlu dikembalikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($rentals->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $rentals->links() }}
            </div>
        @endif
    </div>

    <!-- Modal: Proses Pengembalian -->
    <div id="processReturnModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#1a1d26] border border-gray-800 w-full max-w-md rounded-xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-semibold text-white">Proses Pengembalian</h3>
                    <p id="pr_invoice" class="text-xs font-mono text-amber-500 mt-0.5"></p>
                </div>
                <button type="button" onclick="closeProcessModal()" class="text-gray-400 hover:text-white text-lg">&times;</button>
            </div>

            <form id="processReturnForm" method="POST" class="p-6 space-y-4 text-sm">
                @csrf
                @method('PUT')

                <div class="bg-[#12141c] p-4 rounded-lg border border-gray-800/50 space-y-2 text-gray-300">
                    <div class="flex justify-between"><span class="text-gray-500">Customer:</span><span id="pr_customer" class="text-white font-medium"></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Gadget:</span><span id="pr_gadget" class="text-white font-medium"></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Jatuh Tempo:</span><span id="pr_due_date"></span></div>
                </div>

                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Tanggal Kembali Aktual</label>
                    <input type="date" name="actual_return_date" id="pr_return_date" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>

                <div class="flex justify-between items-center bg-[#12141c] px-4 py-3 rounded-lg border border-gray-800/50">
                    <span class="text-gray-400 font-medium">Estimasi Denda</span>
                    <span id="pr_fine_preview" class="text-lg font-bold text-amber-500">Rp 0</span>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-gray-800">
                    <button type="button" onclick="closeProcessModal()" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Konfirmasi Pengembalian</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPricePerDay = 0;
        let currentEndDate = null;

        function openProcessModal(data) {
            document.getElementById('pr_invoice').innerText = data.invoice_code;
            document.getElementById('pr_customer').innerText = data.customer_name;
            document.getElementById('pr_gadget').innerText = data.gadget_name;
            document.getElementById('pr_due_date').innerText = new Date(data.end_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            currentPricePerDay = data.price_per_day;
            currentEndDate = data.end_date;

            const returnInput = document.getElementById('pr_return_date');
            returnInput.value = new Date().toISOString().slice(0, 10);
            returnInput.min = data.start_date;

            document.getElementById('processReturnForm').action = data.action;
            updateFinePreview();

            document.getElementById('processReturnModal').classList.remove('hidden');
        }

        function closeProcessModal() {
            document.getElementById('processReturnModal').classList.add('hidden');
        }

        function updateFinePreview() {
            const returnInput = document.getElementById('pr_return_date');
            const preview = document.getElementById('pr_fine_preview');
            if (!returnInput.value || !currentEndDate) {
                preview.innerText = 'Rp 0';
                return;
            }
            const end = new Date(currentEndDate + 'T00:00:00');
            const ret = new Date(returnInput.value + 'T00:00:00');
            const lateDays = Math.max(0, Math.round((ret - end) / (1000 * 60 * 60 * 24)));
            const fine = lateDays * currentPricePerDay;
            preview.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(fine);
            preview.className = fine > 0 ? 'text-lg font-bold text-red-400' : 'text-lg font-bold text-emerald-400';
        }

        document.getElementById('pr_return_date').addEventListener('change', updateFinePreview);
    </script>
@endsection
