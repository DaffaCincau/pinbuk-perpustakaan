<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPeminjaman;
use App\Exports\PeminjamanExport;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        // CEK OTOMATIS: Jalankan pengecekan sebelum menampilkan data
        $this->cekSemuaKedaluwarsa();

        $status = $request->query('status');
        $keyword = $request->query('q');

        $peminjamans = Peminjaman::query()
            ->with(['user', 'buku'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('user', function ($qq) use ($keyword) {
                    $qq->where('name', 'like', "%{$keyword}%")
                       ->orWhere('nis', 'like', "%{$keyword}%");
                })->orWhereHas('buku', function ($qq) use ($keyword) {
                    $qq->where('judul', 'like', "%{$keyword}%")
                       ->orWhere('kode_buku', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'semua'         => Peminjaman::count(),
            'menunggu'      => Peminjaman::where('status', StatusPeminjaman::MENUNGGU->value)->count(),
            'disetujui'     => Peminjaman::where('status', StatusPeminjaman::DISETUJUI->value)->count(),
            'dipinjam'      => Peminjaman::where('status', StatusPeminjaman::DIPINJAM->value)->count(),
            'dikembalikan'  => Peminjaman::where('status', StatusPeminjaman::DIKEMBALIKAN->value)->count(),
            'terlambat'     => Peminjaman::where('status', StatusPeminjaman::TERLAMBAT->value)->count(),
            'ditolak'       => Peminjaman::where('status', StatusPeminjaman::DITOLAK->value)->count(),
        ];

        return view('admin.peminjamans.index', compact('peminjamans', 'status', 'keyword', 'counts'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        // CEK OTOMATIS: Jika data ini sudah kedaluwarsa, batalkan saat itu juga
        if ($peminjaman->cekKedaluwarsa()) {
            return redirect()->route('admin.peminjamans.show', $peminjaman)
                ->with('error', 'Peminjaman ini otomatis dibatalkan karena siswa melewati batas waktu pengambilan.');
        }

        $peminjaman->load(['user', 'buku.kategori']);
        return view('admin.peminjamans.show', compact('peminjaman'));
    }

    public function terima(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if (! $peminjaman->isPending()) {
            return back()->with('error', 'Peminjaman ini tidak dalam status menunggu.');
        }

        $peminjaman->update([
            'status'  => StatusPeminjaman::DISETUJUI,
            'catatan' => $request->input('catatan'),
            'updated_at' => Carbon::now(), // Pastikan waktu update ter-reset
        ]);

        return redirect()
            ->route('admin.peminjamans.show', $peminjaman)
            ->with('success', 'Pengajuan disetujui. Harap ambil buku dalam ' . Peminjaman::BATAS_AMBIL_HARI . ' hari.');
    }

    public function approve(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== StatusPeminjaman::DISETUJUI) {
            return back()->with('error', 'Peminjaman ini belum diverifikasi/disetujui.');
        }

        if ($peminjaman->buku->stok < 1) {
            return back()->with('error', 'Stok buku habis. Tidak bisa dipinjamkan.');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status' => StatusPeminjaman::DIPINJAM,
            ]);
            $peminjaman->buku->decrement('stok');
        });

        return redirect()
            ->route('admin.peminjamans.show', $peminjaman)
            ->with('success', 'Buku berhasil dipinjamkan.');
    }

    public function reject(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:500'],
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if (! $peminjaman->isPending() && $peminjaman->status !== StatusPeminjaman::DISETUJUI) {
            return back()->with('error', 'Peminjaman ini tidak bisa ditolak.');
        }

        $peminjaman->update([
            'status'  => StatusPeminjaman::DITOLAK,
            'catatan' => $request->input('catatan'),
        ]);

        return redirect()
            ->route('admin.peminjamans.show', $peminjaman)
            ->with('success', 'Peminjaman ditolak.');
    }

    public function kembalikan(Peminjaman $peminjaman): RedirectResponse
    {
        if (! $peminjaman->isAktif()) {
            return back()->with('error', 'Peminjaman ini tidak dalam status aktif.');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->tanggal_dikembalikan = Carbon::today();
            $denda = $peminjaman->hitungDenda();

            $peminjaman->update([
                'status'                => StatusPeminjaman::DIKEMBALIKAN,
                'tanggal_dikembalikan'  => Carbon::today(),
                'denda'                 => $denda,
            ]);

            $peminjaman->buku->increment('stok');
        });

        $message = 'Buku berhasil dikembalikan.';
        if ($peminjaman->denda > 0) {
            $message .= ' Denda: Rp ' . number_format($peminjaman->denda, 0, ',', '.');
        }

        return redirect()
            ->route('admin.peminjamans.show', $peminjaman)
            ->with('success', $message);
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        $status = $request->query('status');
        $keyword = $request->query('q');
        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new PeminjamanExport($status, $keyword), $filename);
    }

    public function exportPdf(Request $request): Response
    {
        $status = $request->query('status');
        $keyword = $request->query('q');

        $peminjamans = Peminjaman::query()
            ->with(['user', 'buku'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('user', function ($qq) use ($keyword) {
                    $qq->where('name', 'like', "%{$keyword}%")->orWhere('nis', 'like', "%{$keyword}%");
                })->orWhereHas('buku', function ($qq) use ($keyword) {
                    $qq->where('judul', 'like', "%{$keyword}%")->orWhere('kode_buku', 'like', "%{$keyword}%");
                });
            })
            ->latest()->get();

        $filterStatus = $status ? (StatusPeminjaman::tryFrom($status)?->label() ?? $status) : 'Semua Status';
        $filterKeyword = $keyword ?? '-';
        $tanggalCetak = now()->translatedFormat('d F Y, H:i');
        $periode = $peminjamans->isNotEmpty()
            ? $peminjamans->min('tanggal_pinjam')->format('d/m/Y') . ' — ' . $peminjamans->max('tanggal_pinjam')->format('d/m/Y')
            : '-';

        $pdf = Pdf::loadView('admin.peminjamans.pdf', compact('peminjamans', 'filterStatus', 'filterKeyword', 'tanggalCetak', 'periode'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->download('laporan-peminjaman-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Fungsi internal untuk mengecek semua data yang statusnya DISETUJUI
     * tapi sudah melewati batas waktu.
     */
    private function cekSemuaKedaluwarsa()
    {
        $peminjamans = Peminjaman::where('status', StatusPeminjaman::DISETUJUI->value)->get();
        foreach ($peminjamans as $p) {
            $p->cekKedaluwarsa();
        }
    }
} 