@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white tracking-wide">Rental</h1>
        <p class="text-sm text-gray-400 mt-1">Semua transaksi penyewaan gadget — dibuat oleh customer lewat dashboard user</p>
    </div>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.rentals.index') }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ !request('status') ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Semua
        </a>
        <a href="{{ route('admin.rentals.index', ['status' => 'ongoing']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('status') == 'ongoing' ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Ongoing
        </a>
        <a href="{{ route('admin.rentals.index', ['status' => 'completed']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('status') == 'completed' ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Completed
        </a>
        <a href="{{ route('admin.rentals.index', ['status' => 'overdue']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('status') == 'overdue' ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Overdue
        </a>
    </div>

    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
            <h3 class="font-semibold text-white text-sm tracking-wide">Riwayat Transaksi</h3>
            <span class="text-xs text-gray-500">{{ $totalTransaksi }} transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Invoice</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Gadget</th>
                        <th class="px-6 py-3">Mulai</th>
                        <th class="px-6 py-3">Selesai</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">

                    @forelse($rentals as $rental)
                    <tr class="hover:bg-[#1f232e]/30 transition">
                        <td class="px-6 py-4 font-mono text-xs text-gray-300 font-semibold">
                            {{ $rental->invoice_code }}
                        </td>
                        <td class="px-6 py-4 text-white font-medium">
                            {{ $rental->customer->name }}
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            {{ $rental->gadget->name }}
                        </td>
                        <td class="px-6 py-4 text-gray-400">
                            {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M') }}
                        </td>
                        <td class="px-6 py-4 text-gray-400">
                            {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M') }}
                        </td>
                        <td class="px-6 py-4 text-gray-300 font-medium">
                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($rental->status == 'ongoing')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-amber-400 rounded-full"></span> ongoing
                                </span>
                            @elseif($rental->status == 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-400 rounded-full"></span> completed
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-red-400 rounded-full"></span> overdue
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openDetailModal({{ json_encode($rental) }})"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                    title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada riwayat transaksi rental ditemukan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <div id="detailRentalModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#1a1d26] border border-gray-800 w-full max-w-md rounded-xl overflow-hidden shadow-xl max-h-[90vh] flex flex-col">

            <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-[#1a1d26] shrink-0">
                <div>
                    <h3 class="text-base font-semibold text-white">Detail Transaksi</h3>
                    <p id="det_invoice" class="text-xs font-mono text-amber-500 mt-0.5"></p>
                </div>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-white text-lg">✕</button>
            </div>

            <div class="p-6 space-y-4 text-sm overflow-y-auto custom-scrollbar flex-1">
                <div class="flex justify-between items-center bg-[#12141c] px-4 py-3 rounded-lg border border-gray-800/50">
                    <span class="text-gray-400 font-medium">Status Transaksi</span>
                    <span id="det_status"></span>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Customer</p>
                    <div class="bg-[#12141c] p-4 rounded-lg border border-gray-800/50 space-y-2 text-gray-300">
                        <div class="flex justify-between"><span class="text-gray-500">Nama:</span> <span id="det_cust_name" class="text-white font-medium"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">NIK:</span> <span id="det_cust_nik" class="font-mono text-xs"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">No. HP:</span> <span id="det_cust_phone"></span></div>
                        <div class="flex flex-col pt-1"><span class="text-gray-500 mb-0.5">Alamat:</span> <span id="det_cust_address" class="text-xs leading-relaxed bg-[#1a1d26] p-2 rounded border border-gray-800/30 text-gray-400"></span></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Rincian Rental</p>
                    <div class="bg-[#12141c] p-4 rounded-lg border border-gray-800/50 space-y-2 text-gray-300">
                        <div class="flex justify-between"><span class="text-gray-500">Unit Gadget:</span> <span id="det_gadget_name" class="text-white font-medium"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">No. Seri:</span> <span id="det_gadget_serial" class="font-mono text-xs text-gray-400"></span></div>
                        <hr class="border-gray-800 my-2">
                        <div class="flex justify-between"><span class="text-gray-500">Tgl Mulai:</span> <span id="det_start_date"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tgl Selesai:</span> <span id="det_end_date"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tgl Dikembalikan:</span> <span id="det_return_date"></span></div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2 border-t border-gray-800">
                    <span class="font-semibold text-white">Total Biaya Sewa</span>
                    <span id="det_total_price" class="text-lg font-bold text-amber-500"></span>
                </div>
            </div>

            <div class="px-6 py-4 bg-[#151821] border-t border-gray-800 flex justify-end shrink-0">
                <button type="button" onclick="closeDetailModal()" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #12141c;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2d3142;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #f59e0b;
        }
    </style>

    <script>
        function openDetailModal(data) {
            const modal = document.getElementById('detailRentalModal');
            modal.classList.remove('hidden');

            // Set Invoice & Biaya
            document.getElementById('det_invoice').innerText = data.invoice_code;
            document.getElementById('det_total_price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_price);

            // Set Data Customer
            document.getElementById('det_cust_name').innerText = data.customer.name;
            document.getElementById('det_cust_nik').innerText = data.customer.nik;
            document.getElementById('det_cust_phone').innerText = data.customer.phone_number;
            document.getElementById('det_cust_address').innerText = data.customer.address;

            // Set Data Gadget
            document.getElementById('det_gadget_name').innerText = data.gadget.name;
            document.getElementById('det_gadget_serial').innerText = data.gadget.serial_number;

            // Format dan Set Tanggal
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('det_start_date').innerText = new Date(data.start_date).toLocaleDateString('id-ID', options);
            document.getElementById('det_end_date').innerText = new Date(data.end_date).toLocaleDateString('id-ID', options);

            if(data.actual_return_date) {
                document.getElementById('det_return_date').innerText = new Date(data.actual_return_date).toLocaleDateString('id-ID', options);
                document.getElementById('det_return_date').className = "text-emerald-400 font-medium";
            } else {
                document.getElementById('det_return_date').innerText = 'Belum dikembalikan';
                document.getElementById('det_return_date').className = "text-gray-500 italic";
            }

            // Set Status Badge Dinamis
            const statusBox = document.getElementById('det_status');
            if (data.status === 'ongoing') {
                statusBox.className = "inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20";
                statusBox.innerHTML = '<span class="w-1.5 h-1.5 mr-1.5 bg-amber-400 rounded-full"></span> ongoing';
            } else if (data.status === 'completed') {
                statusBox.className = "inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20";
                statusBox.innerHTML = '<span class="w-1.5 h-1.5 mr-1.5 bg-emerald-400 rounded-full"></span> completed';
            } else {
                statusBox.className = "inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20";
                statusBox.innerHTML = '<span class="w-1.5 h-1.5 mr-1.5 bg-red-400 rounded-full"></span> overdue';
            }
        }

        function closeDetailModal() {
            document.getElementById('detailRentalModal').classList.add('hidden');
        }
    </script>
@endsection
