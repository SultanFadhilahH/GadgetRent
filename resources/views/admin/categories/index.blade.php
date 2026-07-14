@extends('layouts.admin')

@section('title', 'Kategori Produk')

@section('content')
<div
    x-data="{
        addOpen: {{ old('_form') === 'add_category' && $errors->any() ? 'true' : 'false' }},
        editModal: {
            open: {{ old('_form') === 'edit_category' && $errors->any() ? 'true' : 'false' }},
            id: {{ old('_form') === 'edit_category' ? (old('_id') ?? 'null') : 'null' }},
            name: @js(old('_form') === 'edit_category' ? old('name') : ''),
            description: @js(old('_form') === 'edit_category' ? old('description') : ''),
        },
        openEdit(cat) {
            this.editModal = { open: true, id: cat.id, name: cat.name, description: cat.description };
        },
    }"
>
    {{-- ============ HEADER ============ --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Kategori Produk</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola kategori gadget yang disewakan</p>
        </div>

        <button
            type="button"
            @click="addOpen = true"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-amber-400"
        >
            <x-admin-icon name="plus" class="h-4 w-4" />
            Tambah Kategori
        </button>
    </div>

    @if ($errors->any() && !in_array(old('_form'), ['add_category', 'edit_category']))
        <div class="mt-6 mb-6 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            Terjadi kesalahan. Silakan periksa kembali data yang dikirim.
        </div>
    @endif

    {{-- ============ TABEL KATEGORI ============ --}}
    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden">
        <div class="flex items-center justify-between border-b border-gray-800 px-6 py-4">
            <h2 class="text-sm font-semibold tracking-wide text-white">Semua Kategori</h2>
            <span class="text-xs text-slate-500">{{ $categories->count() }} kategori</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Jumlah Gadget</th>
                        <th class="px-6 py-3">Dibuat</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse ($categories as $cat)
                        <tr class="hover:bg-[#1f232e]/30 transition">
                            <td class="px-6 py-4 font-semibold text-white">{{ $cat->name }}</td>
                            <td class="px-6 py-4 text-slate-400 max-w-xs truncate">{{ $cat->description ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-400">{{ $cat->gadgets_count }} unit</td>
                            <td class="px-6 py-4 text-slate-400">{{ $cat->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="openEdit({ id: {{ $cat->id }}, name: @js($cat->name), description: @js($cat->description) })"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                        title="Edit Kategori"
                                    >
                                        <x-admin-icon name="pencil" class="h-4 w-4" />
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-red-500/10 text-gray-400 hover:text-red-400 border border-gray-800/80 hover:border-red-900/40 transition"
                                            title="Hapus Kategori"
                                        >
                                            <x-admin-icon name="x" class="h-4 w-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============ MODAL: TAMBAH KATEGORI ============ --}}
    <div x-show="addOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="addOpen = false"></div>
        <div x-show="addOpen" x-transition class="relative w-full max-w-md rounded-xl border border-gray-800 bg-[#1a1d26] p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                <h3 class="text-base font-semibold text-white">Tambah Kategori</h3>
                <button @click="addOpen = false" class="text-gray-500 hover:text-white"><x-admin-icon name="x" class="h-5 w-5" /></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4 text-sm">
                @csrf
                <input type="hidden" name="_form" value="add_category">
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('_form') === 'add_category' ? old('name') : '' }}" required placeholder="mis. Drone" class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                    @if ($errors->any() && old('_form') === 'add_category')
                        @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    @endif
                </div>
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Deskripsi <span class="text-gray-600">(opsional)</span></label>
                    <textarea name="description" rows="3" class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">{{ old('_form') === 'add_category' ? old('description') : '' }}</textarea>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-800 mt-6">
                    <button type="button" @click="addOpen = false" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: EDIT KATEGORI ============ --}}
    <div x-show="editModal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="editModal.open = false"></div>
        <div x-show="editModal.open" x-transition class="relative w-full max-w-md rounded-xl border border-gray-800 bg-[#1a1d26] p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                <h3 class="text-base font-semibold text-white">Edit Kategori</h3>
                <button @click="editModal.open = false" class="text-gray-500 hover:text-white"><x-admin-icon name="x" class="h-5 w-5" /></button>
            </div>
            <form method="POST" :action="editModal.id ? '{{ url('admin/categories') }}/' + editModal.id : '#'" class="space-y-4 text-sm">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form" value="edit_category">
                <input type="hidden" name="_id" :value="editModal.id">
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Nama Kategori</label>
                    <input type="text" name="name" x-model="editModal.name" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                    @if ($errors->any() && old('_form') === 'edit_category')
                        @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    @endif
                </div>
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Deskripsi <span class="text-gray-600">(opsional)</span></label>
                    <textarea name="description" rows="3" x-model="editModal.description" class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-800 mt-6">
                    <button type="button" @click="editModal.open = false" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
