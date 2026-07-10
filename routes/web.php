<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/export-bulanan', [LaporanController::class, 'exportBulanan'])->name('laporan.export-bulanan');
    Route::post('/laporan/export-semua', [LaporanController::class, 'exportSemua'])->name('laporan.export-semua');
});

require __DIR__.'/auth.php';
