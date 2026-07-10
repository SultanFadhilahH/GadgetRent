<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\RentalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Menggunakan resource route untuk menangani seluruh fungsi CRUD
    Route::resource('gadgets', GadgetController::class)->except(['create', 'edit', 'show']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
});
require __DIR__.'/auth.php';
