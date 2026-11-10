<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('kategoris', KategoriController::class)->names('admin.kategoris')->except(['show']);
    Route::resource('bukus', BukuController::class)->names('admin.bukus');

    Route::prefix('peminjamans')->name('admin.peminjamans.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/export/excel', [PeminjamanController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export/pdf', [PeminjamanController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
        
        // Route Aksi
        Route::post('/{peminjaman}/terima', [PeminjamanController::class, 'terima'])->name('terima');
        Route::post('/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('approve');
        Route::post('/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('reject');
        Route::post('/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('kembalikan');
    });
});