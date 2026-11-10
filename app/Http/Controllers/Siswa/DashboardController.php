<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\StatusPeminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Statistik pribadi
        $sedangDipinjam = $user->peminjamans()
            ->whereIn('status', [
                StatusPeminjaman::DIPINJAM->value,
                StatusPeminjaman::TERLAMBAT->value,
            ])
            ->count();

        $pending = $user->peminjamans()
            ->where('status', StatusPeminjaman::MENUNGGU->value)
            ->count();

        $totalRiwayat = $user->peminjamans()->count();

        // Peminjaman terbaru (5 terakhir)
        $peminjamanTerbaru = $user->peminjamans()
            ->with('buku')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'sedangDipinjam',
            'pending',
            'totalRiwayat',
            'peminjamanTerbaru',
        ));
    }
}