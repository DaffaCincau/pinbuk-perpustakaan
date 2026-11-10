<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->query('q');
        $kategoriId = $request->query('kategori');

        $bukus = Buku::query()
            ->with('kategori')
            ->search($keyword)
            ->when($kategoriId, fn ($q) => $q->where('kategori_id', $kategoriId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.bukus.index', compact('bukus', 'kategoris', 'keyword', 'kategoriId'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.bukus.create', compact('kategoris'));
    }

    public function store(BukuRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Upload cover kalau ada
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()
            ->route('admin.bukus.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku): View
    {
        $buku->load(['kategori', 'peminjamans.user']);

        return view('admin.bukus.show', compact('buku'));
    }

    public function edit(Buku $buku): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.bukus.edit', compact('buku', 'kategoris'));
    }

    public function update(BukuRequest $request, Buku $buku): RedirectResponse
    {
        $data = $request->validated();

        // Ganti cover kalau ada upload baru
        if ($request->hasFile('cover')) {
            // Hapus cover lama
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()
            ->route('admin.bukus.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        // Cek apakah buku masih terkait peminjaman aktif
        if ($buku->peminjamanAktif()->exists()) {
            return back()->with(
                'error',
                'Buku tidak bisa dihapus karena masih ada peminjaman aktif.'
            );
        }

        // Hapus cover
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('admin.bukus.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}