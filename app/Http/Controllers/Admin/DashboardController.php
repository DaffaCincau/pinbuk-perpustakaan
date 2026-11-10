<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPeminjaman;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik global
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $pending = Peminjaman::where('status', StatusPeminjaman::MENUNGGU->value)->count();

        $sedangDipinjam = Peminjaman::whereIn('status', [
            StatusPeminjaman::DIPINJAM->value,
            StatusPeminjaman::TERLAMBAT->value,
        ])->count();
 
        $terlambat = Peminjaman::terlambat()->count();

        $totalSiswa = User::where('role', 'siswa')->count();

        // Peminjaman terbaru
        $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalStok',
            'pending',
            'sedangDipinjam',
            'terlambat',
            'totalSiswa',
            'peminjamanTerbaru',
        ));
    }
}