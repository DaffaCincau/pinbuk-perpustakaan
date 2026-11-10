<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\StatusPeminjaman;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    /**
     * Riwayat peminjaman siswa yang login.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $peminjamans = Peminjaman::query()
            ->where('user_id', auth()->id())
            ->with('buku')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('siswa.peminjamans.index', compact('peminjamans', 'status'));
    }

    /**
     * Form pengajuan peminjaman buku.
     */
    public function create(Buku $buku): View|RedirectResponse
    {
        // Cek stok
        if (! $buku->isTersedia()) {
            return redirect()
                ->route('siswa.katalog.show', $buku)
                ->with('error', 'Stok buku sedang kosong.');
        }

        // Cek apakah siswa sedang meminjam / mengajukan buku ini
        $sudahAda = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', [
                StatusPeminjaman::MENUNGGU->value,
                StatusPeminjaman::DISETUJUI->value,
                StatusPeminjaman::DIPINJAM->value,
                StatusPeminjaman::TERLAMBAT->value,
            ])
            ->exists();

        if ($sudahAda) {
            return redirect()
                ->route('siswa.katalog.show', $buku)
                ->with('error', 'Anda sudah mengajukan / meminjam buku ini.');
        }

        return view('siswa.peminjamans.create', compact('buku'));
    }

    /**
     * Simpan pengajuan peminjaman.
     * Durasi default 7 hari.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'buku_id'        => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'durasi'         => ['required', 'integer', 'min:1', 'max:30'],
        ], [
            'buku_id.required'              => 'Buku wajib dipilih.',
            'buku_id.exists'                => 'Buku tidak ditemukan.',
            'tanggal_pinjam.required'       => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu.',
            'durasi.required'               => 'Durasi wajib diisi.',
            'durasi.min'                    => 'Durasi minimal 1 hari.',
            'durasi.max'                    => 'Durasi maksimal 30 hari.',
        ]);

        $buku = Buku::findOrFail($validated['buku_id']);

        // Cek stok
        if (! $buku->isTersedia()) {
            return back()->with('error', 'Stok buku sedang kosong.');
        }

        // Cek duplikat
        $sudahAda = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', [
                StatusPeminjaman::MENUNGGU->value,
                StatusPeminjaman::DISETUJUI->value,
                StatusPeminjaman::DIPINJAM->value,
                StatusPeminjaman::TERLAMBAT->value,
            ])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anda sudah mengajukan / meminjam buku ini.');
        }

        $tanggalPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $tanggalKembali = $tanggalPinjam->copy()->addDays((int) $validated['durasi']);

        Peminjaman::create([
            'user_id'        => auth()->id(),
            'buku_id'        => $buku->id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali'=> $tanggalKembali,
            'status'         => StatusPeminjaman::MENUNGGU,
        ]);

        return redirect()
            ->route('siswa.peminjamans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu verifikasi petugas.');
    }

    /**
     * Batalkan pengajuan yang masih menunggu.
     */
    public function batal(Peminjaman $peminjaman): RedirectResponse
    {
        // Pastikan peminjaman milik user yang login
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        // Cuma bisa batal kalau status masih menunggu
        if ($peminjaman->status !== StatusPeminjaman::MENUNGGU) {
            return back()->with('error', 'Peminjaman ini tidak bisa dibatalkan.');
        }

        $peminjaman->delete();

        return redirect()
            ->route('siswa.peminjamans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }
}