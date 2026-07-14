@extends('layouts.admin')

@section('title', 'History Customer')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">History Customer</h1>
            <p class="text-sm text-gray-400 mt-1">Data pelanggan dan riwayat sewa gadget mereka</p>
        </div>
        <form action="{{ route('admin.customers.index') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau no. HP..." class="bg-[#1a1d26] border border-gray-800 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-72 pl-10 py-2 px-3 text-white">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
        </form>
    </div>

    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
            <h3 class="font-semibold text-white text-sm tracking-wide">Semua Customer</h3>
            <span class="text-xs text-gray-500">{{ $totalCustomer }} customer</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3">No. HP</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">Total Rental</th>
                        <th class="px-6 py-3">Terdaftar</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-[#1f232e]/30 transition">
                            <td class="px-6 py-4 text-white font-medium">{{ $customer->name }}</td>
                            <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $customer->nik }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $customer->phone_number }}</td>
                            <td class="px-6 py-4 text-gray-400 max-w-xs truncate">{{ $customer->address }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $customer->rentals_count }}x</td>
                            <td class="px-6 py-4 text-gray-400">{{ $customer->created_at->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <button onclick='openHistoryModal(@json($customer))'
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                        title="Lihat Riwayat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada data customer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($customers->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <div id="historyModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#1a1d26] border border-gray-800 w-full max-w-lg rounded-xl overflow-hidden shadow-xl max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-[#1a1d26] shrink-0">
                <div>
                    <h3 class="text-base font-semibold text-white">Riwayat Sewa</h3>
                    <p id="hist_customer_name" class="text-xs text-amber-500 mt-0.5"></p>
                </div>
                <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-white text-lg">&times;</button>
            </div>

            <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                <div id="hist_empty" class="hidden text-center text-gray-500 text-sm py-8">Customer ini belum pernah melakukan rental.</div>
                <div id="hist_list" class="space-y-3"></div>
            </div>

            <div class="px-6 py-4 bg-[#151821] border-t border-gray-800 flex justify-end shrink-0">
                <button type="button" onclick="closeHistoryModal()" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #12141c; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d3142; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #f59e0b; }
    </style>

    <script>
        function statusBadge(status) {
            const map = {
                ongoing: ['bg-amber-500/10 text-amber-400 border-amber-500/20', 'bg-amber-400'],
                completed: ['bg-emerald-500/10 text-emerald-400 border-emerald-500/20', 'bg-emerald-400'],
                overdue: ['bg-red-500/10 text-red-400 border-red-500/20', 'bg-red-400'],
            };
            const [cls, dot] = map[status] ?? map.overdue;
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium border ${cls}"><span class="w-1.5 h-1.5 mr-1.5 rounded-full ${dot}"></span>${status}</span>`;
        }

        function openHistoryModal(customer) {
            document.getElementById('hist_customer_name').innerText = customer.name;
            const list = document.getElementById('hist_list');
            const empty = document.getElementById('hist_empty');
            list.innerHTML = '';

            if (!customer.rentals || customer.rentals.length === 0) {
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                customer.rentals.forEach((r) => {
                    const start = new Date(r.start_date).toLocaleDateString('id-ID', options);
                    const end = new Date(r.end_date).toLocaleDateString('id-ID', options);
                    const total = 'Rp ' + new Intl.NumberFormat('id-ID').format(r.total_price);
                    const gadgetName = r.gadget ? r.gadget.name : '-';
                    list.insertAdjacentHTML('beforeend', `
                        <div class="bg-[#12141c] p-4 rounded-lg border border-gray-800/50 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-mono text-xs text-gray-300 font-semibold">${r.invoice_code}</span>
                                ${statusBadge(r.status)}
                            </div>
                            <div class="flex justify-between text-sm"><span class="text-gray-500">Gadget:</span><span class="text-white font-medium">${gadgetName}</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-500">Periode:</span><span class="text-gray-300">${start} &ndash; ${end}</span></div>
                            <div class="flex justify-between text-sm pt-1 border-t border-gray-800"><span class="text-gray-400 font-medium">Total</span><span class="text-amber-500 font-bold">${total}</span></div>
                        </div>
                    `);
                });
            }

            document.getElementById('historyModal').classList.remove('hidden');
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }
    </script>
@endsection
