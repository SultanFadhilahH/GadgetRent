<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Tampilkan halaman Manajemen User.
     */
    public function index(): View
    {
        $roles = Role::with('permissions')->withCount('users')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();
        $users = User::with('roles')->orderByDesc('created_at')->get();

        return view('admin.users.index', compact('roles', 'permissions', 'users'));
    }

    /**
     * Simpan peran baru beserta hak akses (permissions) yang dipilih.
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ], [
            'name.required' => 'Nama peran wajib diisi.',
            'name.unique' => 'Peran dengan nama tersebut sudah ada.',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return back()->with('success', "Peran \"{$role->name}\" berhasil ditambahkan.");
    }

    /**
     * Perbarui hak akses (permissions) milik sebuah peran.
     */
    public function updateRolePermissions(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return back()->with('success', "Hak akses peran \"{$role->name}\" berhasil diperbarui.");
    }

    /**
     * Simpan pengguna baru beserta peran (opsional) yang dipilih.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['nullable', 'exists:roles,name'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return back()->with('success', "Pengguna \"{$user->name}\" berhasil ditambahkan.");
    }

    /**
     * Tetapkan / ubah peran milik seorang pengguna.
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ], [
            'role.required' => 'Silakan pilih peran terlebih dahulu.',
        ]);

        $user->syncRoles([$validated['role']]);

        return back()->with('success', "Peran untuk \"{$user->name}\" berhasil diperbarui.");
    }
}