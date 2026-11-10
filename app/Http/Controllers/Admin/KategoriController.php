<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->query('q');

        $kategoris = Kategori::query()
            ->when($keyword, fn ($q) => $q->where('nama_kategori', 'like', "%{$keyword}%"))
            ->withCount('bukus')
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategoris.index', compact('kategoris', 'keyword'));
    }

    public function create(): View
    {
        return view('admin.kategoris.create');
    }

    public function store(KategoriRequest $request): RedirectResponse
    {
        Kategori::create($request->validated());

        return redirect()
            ->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori): View
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function update(KategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()
            ->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Cek apakah masih ada buku yang memakai kategori ini
        if ($kategori->bukus()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak bisa dihapus karena masih dipakai oleh buku.'
            );
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}