<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\RentalController;

Route::get('/', function () {
    $gadgets = \App\Models\Gadget::with('category')->take(5)->get();
    return view('welcome', compact('gadgets'));
    return view('customer.home', compact('gadgets'));
});

Route::get('/tentang-kami', function () {
    return view('customer.about');
})->name('about');

Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SATUKAN SEMUA RUTE KE PROFILE EDIT DENGAN PARAMETER QUERY
    Route::get('/profile/identity-verification', [ProfileController::class, 'edit'])->name('profile.identity');
    Route::get('/addresses', [ProfileController::class, 'edit'])->name('addresses.index');

    // GANTI BAGIAN INI: Sekarang mengarah ke ProfileController agar tampilan layout-nya ikut ke-render
    Route::get('/password/edit', [ProfileController::class, 'edit'])->name('password.edit');
    Route::get('/orders', [ProfileController::class, 'edit'])->name('orders.index');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/pengembalian', [ReturnController::class, 'index'])->name('returns.index');
    Route::put('/pengembalian/{rental}', [ReturnController::class, 'process'])->name('returns.process');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
});

Route::get('/about', function () {
    return view('customer.about');
})->name('customer.about');

require __DIR__.'/auth.php';
