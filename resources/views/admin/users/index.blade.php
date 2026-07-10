@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div
    x-data="{
        addRoleOpen: {{ old('_form') === 'add_role' && $errors->any() ? 'true' : 'false' }},
        addUserOpen: {{ old('_form') === 'add_user' && $errors->any() ? 'true' : 'false' }},
        permModal: { open: false, roleId: null, roleName: '', permissions: [] },
        assignModal: { open: false, userId: null, userName: '', role: '' },
        openPermModal(role) {
            this.permModal = { open: true, roleId: role.id, roleName: role.name, permissions: [...role.permissions] };
        },
        openAssignModal(user) {
            this.assignModal = { open: true, userId: user.id, userName: user.name, role: user.role };
        },
    }"
>
    {{-- ============ HEADER ============ --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen User</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola akun, peran, dan batasan akses tiap peran</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:shrink-0">
            <button
                type="button"
                @click="addRoleOpen = true"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
            >
                <x-admin-icon name="plus" class="h-4 w-4" />
                Tambah Peran
            </button>
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

    @if ($errors->any() && ! in_array(old('_form'), ['add_role', 'add_user']))
        <div class="mt-6 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            Terjadi kesalahan. Silakan periksa kembali data yang dikirim.
        </div>
    @endif

    {{-- ============ ROLE CARDS ============ --}}
    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
        @forelse ($roles as $role)
            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-5">
                <div class="flex items-start justify-between">
                    <h2 class="text-base font-bold text-white">{{ $role->name }}</h2>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-700 bg-slate-800 px-2.5 py-1 text-xs font-medium text-slate-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                            {{ $role->users_count }} pengguna
                        </span>
                        <button
                            type="button"
                            title="Kelola hak akses"
                            @click="openPermModal({ id: {{ $role->id }}, name: @js($role->name), permissions: {{ $role->permissions->pluck('id')->values()->toJson() }} })"
                            class="flex h-7 w-7 items-center justify-center rounded-md border border-slate-700 text-slate-400 transition hover:border-slate-600 hover:text-white"
                        >
                            <x-admin-icon name="gear" class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <ul class="mt-4 space-y-2.5">
                    @forelse ($role->permissions as $permission)
                        <li class="flex items-start gap-2 text-sm text-slate-300">
                            <x-admin-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-400" />
                            <span>{{ \App\Support\PermissionLabel::label($permission->name) }}</span>
                        </li>
                    @empty
                        <li class="text-sm italic text-slate-500">Belum ada hak akses untuk peran ini.</li>
                    @endforelse
                </ul>
            </div>
        @empty
            <div class="md:col-span-2 rounded-xl border border-dashed border-slate-800 p-8 text-center text-sm text-slate-500">
                Belum ada peran. Klik &ldquo;Tambah Peran&rdquo; untuk membuat peran baru.
            </div>
        @endforelse
    </div>

    {{-- ============ SEMUA PENGGUNA ============ --}}
    <div class="mt-6 rounded-xl border border-slate-800 bg-slate-900/60">
        <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">
            <h2 class="text-base font-bold text-white">Semua Pengguna</h2>
            <span class="text-xs text-slate-500">{{ $users->count() }} akun</span>
        </div>

        {{-- Table (tablet & desktop) --}}
        <div class="hidden overflow-x-auto sm:block">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Peran</th>
                        <th class="px-5 py-3 font-medium">Terdaftar</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @foreach ($users as $user)
                        @php $userRole = $user->roles->first(); @endphp
                        <tr>
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-white">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($userRole)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-sky-500/30 bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                        {{ $userRole->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-red-500/30 bg-red-500/10 px-2.5 py-1 text-xs font-medium text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                        Belum ada peran
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $user->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <button
                                    type="button"
                                    @click="openAssignModal({ id: {{ $user->id }}, name: @js($user->name), role: @js($userRole?->name ?? '') })"
                                    class="{{ $userRole
                                        ? 'flex h-8 w-8 items-center justify-center rounded-md border border-slate-700 text-slate-400 hover:border-slate-600 hover:text-white'
                                        : 'inline-flex items-center rounded-lg border border-slate-700 bg-slate-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-700' }}"
                                >
                                    @if ($userRole)
                                        <x-admin-icon name="pencil" class="h-4 w-4" />
                                    @else
                                        Tetapkan Peran
                                    @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card list (mobile) --}}
        <div class="divide-y divide-slate-800/80 sm:hidden">
            @foreach ($users as $user)
                @php $userRole = $user->roles->first(); @endphp
                <div class="flex items-center justify-between gap-3 px-5 py-4">
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-white">{{ $user->name }}</p>
                        <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            @if ($userRole)
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-sky-500/30 bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                    {{ $userRole->name }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-red-500/30 bg-red-500/10 px-2.5 py-1 text-xs font-medium text-red-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                    Belum ada peran
                                </span>
                            @endif
                            <span class="text-xs text-slate-500">{{ $user->created_at->locale('id')->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="openAssignModal({ id: {{ $user->id }}, name: @js($user->name), role: @js($userRole?->name ?? '') })"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-slate-700 text-slate-400 hover:border-slate-600 hover:text-white"
                    >
                        <x-admin-icon name="pencil" class="h-4 w-4" />
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============ MODAL: TAMBAH PERAN ============ --}}
    <div
        x-show="addRoleOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        <div class="absolute inset-0 bg-black/70" @click="addRoleOpen = false"></div>

        <div x-show="addRoleOpen" x-transition class="relative w-full max-w-md rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Tambah Peran</h3>
                <button @click="addRoleOpen = false" class="text-slate-500 hover:text-white">
                    <x-admin-icon name="x" class="h-5 w-5" />
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.roles.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="_form" value="add_role">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Nama Peran</label>
                    <input
                        type="text" name="name" value="{{ old('_form') === 'add_role' ? old('name') : '' }}"
                        placeholder="cth. Supervisor"
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:ring-amber-500"
                    >
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Hak Akses</label>
                    <div class="max-h-52 space-y-2 overflow-y-auto rounded-lg border border-slate-700 bg-slate-800/60 p-3">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center gap-2 text-sm text-slate-300">
                                <input
                                    type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="rounded border-slate-600 bg-slate-800 text-amber-500 focus:ring-amber-500"
                                >
                                {{ \App\Support\PermissionLabel::label($permission->name) }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="addRoleOpen = false" class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                        Simpan Peran
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: TAMBAH PENGGUNA ============ --}}
    <div
        x-show="addUserOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        <div class="absolute inset-0 bg-black/70" @click="addUserOpen = false"></div>

        <div x-show="addUserOpen" x-transition class="relative w-full max-w-md rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Tambah Pengguna</h3>
                <button @click="addUserOpen = false" class="text-slate-500 hover:text-white">
                    <x-admin-icon name="x" class="h-5 w-5" />
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.users.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="_form" value="add_user">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Nama</label>
                    <input
                        type="text" name="name" value="{{ old('_form') === 'add_user' ? old('name') : '' }}"
                        placeholder="Nama lengkap"
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:ring-amber-500"
                    >
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Email</label>
                    <input
                        type="email" name="email" value="{{ old('_form') === 'add_user' ? old('email') : '' }}"
                        placeholder="nama@email.com"
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:ring-amber-500"
                    >
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Kata Sandi</label>
                    <input
                        type="password" name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:ring-amber-500"
                    >
                    @error('password') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Peran <span class="text-slate-500">(opsional)</span></label>
                    <select name="role" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-amber-500 focus:ring-amber-500">
                        <option value="">Belum ada peran</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="addUserOpen = false" class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: KELOLA HAK AKSES PERAN (gear) ============ --}}
    <div x-show="permModal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="permModal.open = false"></div>

        <div x-show="permModal.open" x-transition class="relative w-full max-w-md rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Hak Akses &mdash; <span x-text="permModal.roleName"></span></h3>
                <button @click="permModal.open = false" class="text-slate-500 hover:text-white">
                    <x-admin-icon name="x" class="h-5 w-5" />
                </button>
            </div>

            <form method="POST" :action="permModal.roleId ? '{{ url('admin/manajemen-user/roles') }}/' + permModal.roleId : '#'" class="mt-5 space-y-4">
                @csrf
                @method('PUT')

                <div class="max-h-64 space-y-2 overflow-y-auto rounded-lg border border-slate-700 bg-slate-800/60 p-3">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center gap-2 text-sm text-slate-300">
                            <input
                                type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                x-model.number="permModal.permissions"
                                class="rounded border-slate-600 bg-slate-800 text-amber-500 focus:ring-amber-500"
                            >
                            {{ \App\Support\PermissionLabel::label($permission->name) }}
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="permModal.open = false" class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL: TETAPKAN / UBAH PERAN PENGGUNA ============ --}}
    <div x-show="assignModal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="assignModal.open = false"></div>

        <div x-show="assignModal.open" x-transition class="relative w-full max-w-sm rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Tetapkan Peran</h3>
                <button @click="assignModal.open = false" class="text-slate-500 hover:text-white">
                    <x-admin-icon name="x" class="h-5 w-5" />
                </button>
            </div>
            <p class="mt-1 text-sm text-slate-400">Pengguna: <span class="font-semibold text-slate-200" x-text="assignModal.userName"></span></p>

            <form method="POST" :action="assignModal.userId ? '{{ url('admin/manajemen-user/users') }}/' + assignModal.userId + '/role' : '#'" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-300">Peran</label>
                    <select name="role" x-model="assignModal.role" required class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-amber-500 focus:ring-amber-500">
                        <option value="" disabled>Pilih peran</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="assignModal.open = false" class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-400">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection