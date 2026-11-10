<?php

use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\KatalogController;
use App\Http\Controllers\Siswa\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:siswa'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('siswa.dashboard');

    // Katalog buku — browse + search + detail
    Route::prefix('katalog')->name('siswa.katalog.')->group(function () {
        Route::get('/', [KatalogController::class, 'index'])->name('index');
        Route::get('/{buku}', [KatalogController::class, 'show'])->name('show');
    });

    // Peminjaman — ajukan & riwayat
    Route::prefix('peminjamans')->name('siswa.peminjamans.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create/{buku}', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('store');
        Route::delete('/{peminjaman}/batal', [PeminjamanController::class, 'batal'])->name('batal');
    });
});