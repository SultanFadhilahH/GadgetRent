@extends('layouts.admin')
    @section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">✕</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Gadget</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola seluruh unit gadget rental</p>
        </div>
        <button onclick="openModal('add')" class="bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold px-4 py-2.5 rounded-lg transition text-sm flex items-center gap-2">
            <span>+</span> Tambah Gadget
        </button>
    </div>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.gadgets.index') }}"
           class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ !request('category_id') ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('admin.gadgets.index', ['category_id' => $cat->id]) }}"
               class="px-4 py-1.5 rounded-full text-xs font-medium transition border {{ request('category_id') == $cat->id ? 'bg-amber-500 text-[#12141c] border-amber-500' : 'bg-[#1a1d26] text-gray-400 hover:text-white border-gray-800' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
            <h3 class="font-semibold text-white text-sm tracking-wide">Daftar Unit</h3>
            <span class="text-xs text-gray-500">{{ $totalUnit }} unit</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Gadget</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">No. Seri</th>
                        <th class="px-6 py-3">Harga / Hari</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">

                    @forelse($gadgets as $gadget)
                    <tr class="hover:bg-[#1f232e]/30 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-white">{{ $gadget->name }}</div>
                            <div class="text-xs text-gray-500">{{ $gadget->brand }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-300">{{ $gadget->category->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $gadget->serial_number }}</td>
                        <td class="px-6 py-4 text-gray-300">Rp {{ number_format($gadget->price_per_day, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($gadget->status == 'available')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-400 rounded-full"></span> available
                                </span>
                            @elseif($gadget->status == 'rented')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-amber-400 rounded-full"></span> rented
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-red-400 rounded-full"></span> maintenance
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Tombol Edit dengan Ikon Pensil Modern -->
                                <button onclick="openModal('edit', {{ json_encode($gadget) }})"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                        title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                <!-- Tombol Hapus dengan Ikon Tempat Sampah Modern -->
                                <form action="{{ route('admin.gadgets.destroy', $gadget->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-red-950/40 text-gray-400 hover:text-red-400 border border-gray-800/80 transition"
                                            title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada data gadget ditemukan di database.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <div id="gadgetModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#1a1d26] border border-gray-800 w-full max-w-md rounded-xl overflow-hidden shadow-xl max-h-[90vh] flex flex-col">

            <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-[#1a1d26] shrink-0">
                <h3 id="modalTitle" class="text-base font-semibold text-white">Tambah Gadget</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white text-lg">✕</button>
            </div>

            <form id="gadgetForm" method="POST" class="flex-1 flex flex-col overflow-hidden text-sm">
                @csrf
                <div id="methodField"></div>

                <div class="p-6 space-y-4 overflow-y-auto custom-scrollbar flex-1">
                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Nama Gadget</label>
                        <input type="text" name="name" id="in_name" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Brand / Merk</label>
                        <input type="text" name="brand" id="in_brand" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Kategori</label>
                        <select name="category_id" id="in_category" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Nomor Seri</label>
                        <input type="text" name="serial_number" id="in_serial" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white font-mono focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Harga Sewa / Hari (Rp)</label>
                        <input type="number" name="price_per_day" id="in_price" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-gray-400 mb-1.5 font-medium">Status</label>
                        <select name="status" id="in_status" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="px-6 py-4 bg-[#151821] border-t border-gray-800 flex justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Simpan</button>
                </div>
            </form>
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
        function openModal(mode, data = null) {
            const modal = document.getElementById('gadgetModal');
            const form = document.getElementById('gadgetForm');
            const title = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');

            modal.classList.remove('hidden');

            if (mode === 'add') {
                title.innerText = 'Tambah Gadget';
                form.action = "{{ route('admin.gadgets.store') }}";
                methodField.innerHTML = '';
                form.reset();
            } else if (mode === 'edit') {
                title.innerText = 'Edit Data Gadget';
                form.action = `/gadgets/${data.id}`;
                methodField.innerHTML = '@method("PUT")';

                document.getElementById('in_name').value = data.name;
                document.getElementById('in_brand').value = data.brand;
                document.getElementById('in_category').value = data.category_id;
                document.getElementById('in_serial').value = data.serial_number;
                document.getElementById('in_price').value = data.price_per_day;
                document.getElementById('in_status').value = data.status;
            }
        }

        function closeModal() {
            document.getElementById('gadgetModal').classList.add('hidden');
        }
    </script>
@endsection