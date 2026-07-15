@extends('layouts.admin')

@section('title', 'Voucher')

@section('content')
<div class="space-y-6" x-data="{
        addModalOpen: false,
        editModal: { open: false, id: null, code: '', discount_type: 'percent', discount_value: '', start_date: '', end_date: '', is_active: true },
        openEdit(voucher) {
            this.editModal = { open: true, ...voucher };
        }
    }">

    {{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white" style="font-family:'Space Grotesk',sans-serif;">
                Voucher
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola kode voucher diskon untuk pelanggan
            </p>
        </div>
        <button @click="addModalOpen = true"
           class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold text-sm px-4 py-2.5 transition">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4">
                <path d="M7 1v12M1 7h12"/>
            </svg>
            Tambah Voucher
        </button>
    </div>

    {{-- ── STAT CARDS ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        
        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500" style="font-family:'JetBrains Mono',monospace;">Voucher Aktif</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">{{ $activeCount }}</p>
            <p class="mt-1 text-xs text-slate-400">Masih bisa dipakai customer</p>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500" style="font-family:'JetBrains Mono',monospace;">Voucher Kadaluarsa</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">{{ $expiredCount }}</p>
            <p class="mt-1 text-xs text-slate-400">Sudah lewat tanggal berakhir</p>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-white/5 bg-[#1a1d26] p-5">
            <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500 rounded-l-xl"></div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500" style="font-family:'JetBrains Mono',monospace;">Total Terpakai</p>
            <p class="mt-2 text-3xl font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">{{ $totalUsage }}x</p>
            <p class="mt-1 text-xs text-slate-400">Sepanjang periode berjalan</p>
        </div>

    </div>

    {{-- ── FILTER CHIPS ──────────────────────────────────────────────── --}}
    <div class="flex flex-wrap gap-2" id="admin-voucher-filter">
        <button class="px-4 py-1.5 rounded-full text-xs font-medium transition filter-btn border border-white/10 bg-white/10 text-white" data-status="all">Semua</button>
        <button class="px-4 py-1.5 rounded-full text-xs font-medium transition filter-btn border border-white/5 bg-transparent text-slate-400 hover:text-white hover:bg-white/5" data-status="aktif">Aktif</button>
        <button class="px-4 py-1.5 rounded-full text-xs font-medium transition filter-btn border border-white/5 bg-transparent text-slate-400 hover:text-white hover:bg-white/5" data-status="kadaluarsa">Kadaluarsa</button>
    </div>

    {{-- ── TABLE PANEL ───────────────────────────────────────────────── --}}
    <div class="rounded-xl border border-white/5 bg-[#1a1d26] overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/5">
            <h2 class="font-semibold text-white text-sm" style="font-family:'Space Grotesk',sans-serif;">
                Daftar Voucher
            </h2>
            <span class="text-[11px] text-slate-500" style="font-family:'JetBrains Mono',monospace;">
                {{ $vouchers->count() }} voucher
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-white/5 text-xs uppercase text-slate-400">
                    <tr>
                        <th class="px-5 py-3 font-medium">Kode Voucher</th>
                        <th class="px-5 py-3 font-medium">Tipe Diskon</th>
                        <th class="px-5 py-3 font-medium">Nilai</th>
                        <th class="px-5 py-3 font-medium">Tanggal Mulai</th>
                        <th class="px-5 py-3 font-medium">Kadaluarsa</th>
                        <th class="px-5 py-3 font-medium">Terpakai</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="admin-voucher-rows" class="divide-y divide-white/5">
                    @forelse($vouchers as $voucher)
                        @php
                            $isExpired = $voucher->end_date && $voucher->end_date->isPast();
                            $status = ($voucher->is_active && !$isExpired) ? 'aktif' : 'kadaluarsa';
                            
                            if ($status === 'aktif') {
                                $tagClass = 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/20';
                            } else {
                                $tagClass = 'bg-red-500/10 text-red-400 ring-red-500/20';
                            }
                            
                            $valFormat = $voucher->discount_type === 'nominal' 
                                ? 'Rp ' . number_format($voucher->discount_value, 0, ',', '.') 
                                : number_format($voucher->discount_value, 0) . '%';
                        @endphp
                        <tr class="hover:bg-white/5 transition group" data-status="{{ $status }}">
                            <td class="px-5 py-4 font-bold text-amber-500" style="font-family:'JetBrains Mono',monospace;">{{ $voucher->code }}</td>
                            <td class="px-5 py-4">{{ ucfirst($voucher->discount_type) }}</td>
                            <td class="px-5 py-4 font-medium text-white" style="font-family:'JetBrains Mono',monospace;">{{ $valFormat }}</td>
                            <td class="px-5 py-4" style="font-family:'JetBrains Mono',monospace;">{{ $voucher->start_date ? $voucher->start_date->format('d M Y') : '-' }}</td>
                            <td class="px-5 py-4" style="font-family:'JetBrains Mono',monospace;">{{ $voucher->end_date ? $voucher->end_date->format('d M Y') : '-' }}</td>
                            <td class="px-5 py-4">{{ $voucher->usage_count }}x</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-[11px] font-bold uppercase tracking-wider ring-1 ring-inset {{ $tagClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button"
                                        @click="openEdit({
                                            id: {{ $voucher->id }},
                                            code: @js($voucher->code),
                                            discount_type: @js($voucher->discount_type),
                                            discount_value: {{ $voucher->discount_value }},
                                            start_date: @js($voucher->start_date?->format('Y-m-d')),
                                            end_date: @js($voucher->end_date?->format('Y-m-d')),
                                            is_active: {{ $voucher->is_active ? 'true' : 'false' }}
                                        })"
                                        class="rounded p-1.5 text-slate-400 hover:bg-white/10 hover:text-white transition" title="Edit">
                                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded p-1.5 text-slate-400 hover:bg-red-500/20 hover:text-red-400 transition" title="Hapus">
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-500">
                                Belum ada voucher yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── MODAL TAMBAH VOUCHER ────────────────────────────────────────── --}}
    <div x-show="addModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak style="display: none;">
        <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="addModalOpen = false"></div>
        <div x-show="addModalOpen" x-transition.scale.origin.bottom class="relative w-full max-w-lg rounded-xl bg-[#1a1d26] border border-white/10 shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between border-b border-white/5 px-6 py-4">
                <h3 class="text-lg font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">Tambah Voucher</h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.vouchers.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kode Voucher</label>
                    <input type="text" name="code" required class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none uppercase" placeholder="mis. GADGET50">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tipe Diskon</label>
                        <select name="discount_type" required class="w-full rounded-lg border border-white/10 bg-[#222632] px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                            <option value="percent">Persen (%)</option>
                            <option value="nominal">Nominal (Rp)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nilai Diskon</label>
                        <input type="number" name="discount_value" required class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none" placeholder="mis. 10 atau 50000">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Kadaluarsa</label>
                        <input type="date" name="end_date" class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                    <button type="button" @click="addModalOpen = false" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white transition">Batal</button>
                    <button type="submit" class="rounded-lg bg-amber-500 hover:bg-amber-400 px-4 py-2 text-sm font-bold text-black transition">Simpan Voucher</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL EDIT VOUCHER ────────────────────────────────────────── --}}
    <div x-show="editModal.open" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak style="display: none;">
        <div x-show="editModal.open" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="editModal.open = false"></div>
        <div x-show="editModal.open" x-transition.scale.origin.bottom class="relative w-full max-w-lg rounded-xl bg-[#1a1d26] border border-white/10 shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between border-b border-white/5 px-6 py-4">
                <h3 class="text-lg font-bold text-white" style="font-family:'Space Grotesk',sans-serif;">Edit Voucher</h3>
                <button @click="editModal.open = false" class="text-slate-400 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form :action="editModal.id ? '{{ url('admin/vouchers') }}/' + editModal.id : '#'" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kode Voucher</label>
                    <input type="text" name="code" x-model="editModal.code" required class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none uppercase">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tipe Diskon</label>
                        <select name="discount_type" x-model="editModal.discount_type" required class="w-full rounded-lg border border-white/10 bg-[#222632] px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                            <option value="percent">Persen (%)</option>
                            <option value="nominal">Nominal (Rp)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nilai Diskon</label>
                        <input type="number" name="discount_value" x-model="editModal.discount_value" required class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" x-model="editModal.start_date" class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanggal Kadaluarsa</label>
                        <input type="date" name="end_date" x-model="editModal.end_date" class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="is_active" value="1" x-model="editModal.is_active" class="rounded border-white/10 bg-white/5 text-amber-500 focus:ring-amber-500">
                    Voucher aktif
                </label>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                    <button type="button" @click="editModal.open = false" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white transition">Batal</button>
                    <button type="submit" class="rounded-lg bg-amber-500 hover:bg-amber-400 px-4 py-2 text-sm font-bold text-black transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const rows = document.querySelectorAll('#admin-voucher-rows tr[data-status]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state class on buttons
                filterBtns.forEach(b => {
                    b.classList.remove('border-white/10', 'bg-white/10', 'text-white');
                    b.classList.add('border-white/5', 'bg-transparent', 'text-slate-400');
                });
                btn.classList.add('border-white/10', 'bg-white/10', 'text-white');
                btn.classList.remove('border-white/5', 'bg-transparent', 'text-slate-400');

                // Filter rows
                const status = btn.getAttribute('data-status');
                rows.forEach(row => {
                    if (status === 'all' || row.getAttribute('data-status') === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
