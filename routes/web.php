<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', function () {
    $gadgets = \App\Models\Gadget::with('category')->take(5)->get(); // Fetch 5 gadgets
    return view('welcome', compact('gadgets'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('/manajemen-user', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/manajemen-user/roles', [UserManagementController::class, 'storeRole'])->name('users.roles.store');
    Route::put('/manajemen-user/roles/{role}', [UserManagementController::class, 'updateRolePermissions'])->name('users.roles.update');
    Route::post('/manajemen-user/users', [UserManagementController::class, 'storeUser'])->name('users.users.store');
    Route::put('/manajemen-user/users/{user}/role', [UserManagementController::class, 'updateUserRole'])->name('users.users.updateRole');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/export-bulanan', [LaporanController::class, 'exportBulanan'])->name('laporan.export-bulanan');
    Route::post('/laporan/export-semua', [LaporanController::class, 'exportSemua'])->name('laporan.export-semua');
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::resource('gadgets', GadgetController::class)->except(['create', 'edit', 'show']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
});

Route::get('/about', function () {
    return view('customer.about'); // Sesuaikan dengan folder tempat kamu menyimpan file about tadi
})->name('customer.about');

require __DIR__.'/auth.php';
