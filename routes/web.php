<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
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
    return view('customer.home', compact('gadgets'));
});

Route::get('/tentang-kami', function () {
    return view('customer.about');
})->name('about');



Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{gadget}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:Admin|Staff'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SATUKAN SEMUA RUTE KE PROFILE EDIT DENGAN PARAMETER QUERY
    Route::get('/profile/identity-verification', [ProfileController::class, 'edit'])->name('profile.identity');
    Route::post('/profile/verify-ktp', [ProfileController::class, 'verifyKtp'])->name('profile.verifyKtp');
    Route::get('/addresses', [ProfileController::class, 'edit'])->name('addresses.index');
    Route::post('/addresses', [ProfileController::class, 'saveAddress'])->name('addresses.save');

    // GANTI BAGIAN INI: Sekarang mengarah ke ProfileController agar tampilan layout-nya ikut ke-render
    Route::get('/password/edit', [ProfileController::class, 'edit'])->name('password.edit');
    Route::get('/orders', [ProfileController::class, 'edit'])->name('orders.index');
    
    // Cart Routes
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout Routes
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/direct/{gadget}', [\App\Http\Controllers\CheckoutController::class, 'direct'])->name('checkout.direct');
    Route::post('/checkout/confirm-payment', [\App\Http\Controllers\CheckoutController::class, 'confirmPayment'])->name('checkout.confirmPayment');
    
    // API for navbar cart
    Route::get('/api/cart', [\App\Http\Controllers\CartController::class, 'getCartData'])->name('api.cart');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/manajemen-user', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/manajemen-user/roles', [UserManagementController::class, 'storeRole'])->name('users.roles.store');
    Route::put('/manajemen-user/roles/{role}', [UserManagementController::class, 'updateRolePermissions'])->name('users.roles.update');
    Route::post('/manajemen-user/users', [UserManagementController::class, 'storeUser'])->name('users.users.store');
    Route::put('/manajemen-user/users/{user}/role', [UserManagementController::class, 'updateUserRole'])->name('users.users.updateRole');
    Route::delete('/manajemen-user/users/{user}', [UserManagementController::class, 'destroyUser'])->name('users.users.destroy');
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::resource('gadgets', GadgetController::class)->except(['create', 'edit', 'show']);
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/pengembalian', [ReturnController::class, 'index'])->name('returns.index');
    Route::put('/pengembalian/{rental}', [ReturnController::class, 'process'])->name('returns.process');
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class)->except(['show']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
});

require __DIR__.'/auth.php';
