<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->query('q');
        $kategoriId = $request->query('kategori');

        $bukus = Buku::query()
            ->with('kategori')
            ->search($keyword)
            ->when($kategoriId, fn ($q) => $q->where('kategori_id', $kategoriId))
            ->orderBy('judul')
            ->paginate(12)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('siswa.katalog.index', compact('bukus', 'kategoris', 'keyword', 'kategoriId'));
    }

    public function show(Buku $buku): View
    {
        $buku->load('kategori');

        // Cek apakah user sedang meminjam buku ini
        $sedangDipinjam = $buku->peminjamans()
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                \App\Enums\StatusPeminjaman::MENUNGGU->value,
                \App\Enums\StatusPeminjaman::DIPINJAM->value,
                \App\Enums\StatusPeminjaman::TERLAMBAT->value,
            ])
            ->exists();

        return view('siswa.katalog.show', compact('buku', 'sedangDipinjam'));
    }
}