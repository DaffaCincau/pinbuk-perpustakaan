<?php

use App\Http\Controllers\ProfileController;
use App\Models\Buku;
use Illuminate\Support\Facades\Route;

// Halaman Depan (Hanya 6 Buku Rekomendasi)
Route::get('/', function () {
    $rekomendasiBuku = Buku::with('kategori')->latest()->take(6)->get();
    return view('welcome', compact('rekomendasiBuku'));
})->name('home');

// Halaman Katalog Publik (Lihat Semua Buku Tanpa Login)
Route::get('/katalog', function () {
    $semuaBuku = Buku::with('kategori')->latest()->paginate(12);
    return view('guest.katalog', compact('semuaBuku'));
})->name('guest.katalog');

// Halaman Detail Buku untuk Publik
Route::get('/buku/{buku}', function (Buku $buku) {
    $buku->load('kategori');
    return view('siswa.katalog.show', [
        'buku' => $buku, 
        'sedangDipinjam' => false,
        'isGuest' => true 
    ]);
})->name('guest.buku.show');

// Route '/dashboard' — redirect sesuai role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }
    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

// Route profile (dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // <-- SUDAH DIPERBAIKI
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';