<?php

namespace App\Exports;

use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithTitle
{
    public function __construct(
        protected ?string $status = null,
        protected ?string $keyword = null,
    ) {}

    public function query()
    {
        return Peminjaman::query()
            ->with(['user', 'buku'])
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->keyword, function ($q) {
                $q->whereHas('user', function ($qq) {
                    $qq->where('name', 'like', "%{$this->keyword}%")
                       ->orWhere('nis', 'like', "%{$this->keyword}%");
                })->orWhereHas('buku', function ($qq) {
                    $qq->where('judul', 'like', "%{$this->keyword}%")
                       ->orWhere('kode_buku', 'like', "%{$this->keyword}%");
                });
            })
            ->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Peminjaman',
            'Nama Siswa',
            'NIS',
            'Judul Buku',
            'Kode Buku',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Tanggal Dikembalikan',
            'Status',
            'Denda (Rp)',
            'Catatan',
        ];
    }

    public function map($peminjaman): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            'PJM-' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT),
            $peminjaman->user->name,
            $peminjaman->user->nis ?? '-',
            $peminjaman->buku->judul,
            $peminjaman->buku->kode_buku,
            $peminjaman->tanggal_pinjam->format('d/m/Y'),
            $peminjaman->tanggal_kembali->format('d/m/Y'),
            $peminjaman->tanggal_dikembalikan
                ? $peminjaman->tanggal_dikembalikan->format('d/m/Y')
                : '-',
            $peminjaman->status->label(),
            $peminjaman->denda,
            $peminjaman->catatan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row (baris 1)
            1 => [
                'font' => [
                    'bold'  => true,
                    'size'  => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3B82F6'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Peminjaman';
    }
}