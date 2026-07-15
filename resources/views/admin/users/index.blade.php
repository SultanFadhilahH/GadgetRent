@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div
    x-data="{
        addUserOpen: {{ old('_form') === 'add_user' && $errors->any() ? 'true' : 'false' }},
        assignModal: { open: false, userId: null, userName: '', role: '' },
        deleteModal: { open: false, userId: null, userName: '' },
        openAssignModal(user) {
            this.assignModal = { open: true, userId: user.id, userName: user.name, role: user.role };
        },
        openDeleteModal(user) {
            this.deleteModal = { open: true, userId: user.id, userName: user.name };
        },
    }"
>
    {{-- ============ HEADER ============ --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Manajemen User</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola akun dan hak akses pengguna</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:shrink-0 items-center">
            <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="bg-[#1a1d26] border border-gray-800 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-64 pl-10 py-2.5 px-3 text-white">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </form>
            <button
                type="button"
                @click="addUserOpen = true"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-amber-400"
            >
                <x-admin-icon name="plus" class="h-4 w-4" />
                Tambah Pengguna
            </button>
        </div>
    </div>

    @if ($errors->any() && old('_form') !== 'add_user')
        <div class="mt-6 mb-6 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            Terjadi kesalahan. Silakan periksa kembali data yang dikirim.
        </div>
    @endif

    {{-- ============ TIM INTERNAL (ADMIN & STAFF) ============ --}}
    <div class="mt-6 bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden mb-8">
        <div class="flex items-center justify-between border-b border-gray-800 px-6 py-4">
            <h2 class="text-sm font-semibold tracking-wide text-white">Tim Internal (Admin & Staff)</h2>
            <span class="text-xs text-slate-500">{{ $staffs->total() }} akun</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Peran</th>
                        <th class="px-6 py-3">Terdaftar</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse ($staffs as $user)
                        @php $userRole = $user->roles->first(); @endphp
                        <tr class="hover:bg-[#1f232e]/30 transition">
                            <td class="px-6 py-4 font-semibold text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if ($userRole && $userRole->name === 'Admin')
                                    <span class="inline-flex items-center gap-1.5 rounded bg-sky-500/10 px-2 py-1 text-xs font-medium text-sky-400 border border-sky-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                        {{ $userRole->name }}
                                    </span>
                                @elseif($userRole && $userRole->name === 'Staff')
                                    <span class="inline-flex items-center gap-1.5 rounded bg-emerald-500/10 px-2 py-1 text-xs font-medium text-emerald-400 border border-emerald-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        {{ $userRole->name }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $user->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="openAssignModal({ id: {{ $user->id }}, name: @js($user->name), role: @js($userRole?->name ?? '') })"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                        title="Edit Peran"
                                    >
                                        <x-admin-icon name="pencil" class="h-4 w-4" />
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button
                                            type="button"
                                            @click="openDeleteModal({ id: {{ $user->id }}, name: @js($user->name) })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-red-500/20 text-gray-400 hover:text-red-400 border border-gray-800/80 hover:border-red-500/30 transition"
                                            title="Hapus Pengguna"
                                        >
                                            <x-admin-icon name="trash" class="h-4 w-4" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staffs->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $staffs->links() }}
        </div>
        @endif
    </div>

    {{-- ============ CUSTOMER (USER) ============ --}}
    <div class="bg-[#1a1d26] rounded-xl border border-gray-800 overflow-hidden mb-8">
        <div class="flex items-center justify-between border-b border-gray-800 px-6 py-4">
            <h2 class="text-sm font-semibold tracking-wide text-white">Customer (User)</h2>
            <span class="text-xs text-slate-500">{{ $users->total() }} akun</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] font-bold tracking-wider text-gray-500 uppercase bg-[#151821] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Peran</th>
                        <th class="px-6 py-3">Terdaftar</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse ($users as $user)
                        @php $userRole = $user->roles->first(); @endphp
                        <tr class="hover:bg-[#1f232e]/30 transition">
                            <td class="px-6 py-4 font-semibold text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if ($userRole)
                                    <span class="inline-flex items-center gap-1.5 rounded bg-gray-700/50 px-2 py-1 text-xs font-medium text-gray-300 border border-gray-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        {{ $userRole->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded bg-gray-700/50 px-2 py-1 text-xs font-medium text-gray-300 border border-gray-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $user->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="openAssignModal({ id: {{ $user->id }}, name: @js($user->name), role: @js($userRole?->name ?? '') })"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-gray-700/60 text-gray-400 hover:text-white border border-gray-800/80 transition"
                                        title="Edit Peran"
                                    >
                                        <x-admin-icon name="pencil" class="h-4 w-4" />
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button
                                            type="button"
                                            @click="openDeleteModal({ id: {{ $user->id }}, name: @js($user->name) })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/40 hover:bg-red-500/20 text-gray-400 hover:text-red-400 border border-gray-800/80 hover:border-red-500/30 transition"
                                            title="Hapus Pengguna"
                                        >
                                            <x-admin-icon name="trash" class="h-4 w-4" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- ============ MODAL: TAMBAH PENGGUNA ============ --}}
    <div x-show="addUserOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="addUserOpen = false"></div>
        <div x-show="addUserOpen" x-transition class="relative w-full max-w-md rounded-xl border border-gray-800 bg-[#1a1d26] p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                <h3 class="text-base font-semibold text-white">Tambah Pengguna</h3>
                <button @click="addUserOpen = false" class="text-gray-500 hover:text-white"><x-admin-icon name="x" class="h-5 w-5" /></button>
            </div>
            <form method="POST" action="{{ route('admin.users.users.store') }}" class="space-y-4 text-sm">
                @csrf
                <input type="hidden" name="_form" value="add_user">
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('_form') === 'add_user' ? old('name') : '' }}" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Email</label>
                    <input type="email" name="email" value="{{ old('_form') === 'add_user' ? old('email') : '' }}" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Peran <span class="text-gray-600">(opsional)</span></label>
                    <select name="role" class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                        <option value="">User / Customer</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-800 mt-6">
                    <button type="button" @click="addUserOpen = false" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: TETAPKAN / UBAH PERAN ============ --}}
    <div x-show="assignModal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="assignModal.open = false"></div>
        <div x-show="assignModal.open" x-transition class="relative w-full max-w-md rounded-xl border border-gray-800 bg-[#1a1d26] p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                <h3 class="text-base font-semibold text-white">Tetapkan Peran</h3>
                <button @click="assignModal.open = false" class="text-gray-500 hover:text-white"><x-admin-icon name="x" class="h-5 w-5" /></button>
            </div>
            <p class="text-sm text-gray-400 mb-4">Pengguna: <span class="font-semibold text-white" x-text="assignModal.userName"></span></p>
            <form method="POST" :action="assignModal.userId ? '{{ url('admin/manajemen-user/users') }}/' + assignModal.userId + '/role' : '#'" class="space-y-4 text-sm">
                @csrf
                @method('PUT')
                <div>
                    <label class="mb-1.5 block font-medium text-gray-400">Pilih Peran</label>
                    <select name="role" x-model="assignModal.role" required class="w-full bg-[#12141c] border border-gray-800 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                        <option value="" disabled>Pilih peran...</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-800 mt-6">
                    <button type="button" @click="assignModal.open = false" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-[#12141c] font-semibold transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: HAPUS PENGGUNA ============ --}}
    <div x-show="deleteModal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="deleteModal.open = false"></div>
        <div x-show="deleteModal.open" x-transition class="relative w-full max-w-md rounded-xl border border-gray-800 bg-[#1a1d26] p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800 pb-4 mb-4">
                <h3 class="text-base font-semibold text-white">Hapus Pengguna</h3>
                <button @click="deleteModal.open = false" class="text-gray-500 hover:text-white"><x-admin-icon name="x" class="h-5 w-5" /></button>
            </div>
            <p class="text-sm text-gray-400 mb-6">
                Yakin ingin menghapus <span class="font-semibold text-white" x-text="deleteModal.userName"></span>?
                Data terkait (keranjang, riwayat sewa) akan ikut terhapus. Tindakan ini tidak bisa dibatalkan.
            </p>
            <form method="POST" :action="deleteModal.userId ? '{{ url('admin/manajemen-user/users') }}/' + deleteModal.userId : '#'" class="flex justify-end gap-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteModal.open = false" class="px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold transition">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection