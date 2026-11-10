<?php

use App\Http\Controllers\ProfileController;
use App\Models\Buku;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Ambil 6 buku secara acak untuk rekomendasi di halaman depan
    $rekomendasiBuku = Buku::inRandomOrder()->take(6)->get();
    
    return view('welcome', compact('rekomendasiBuku'));
})->name('home');

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';