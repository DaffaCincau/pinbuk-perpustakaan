<?php

namespace App\Exports;

class PeminjamanExportInfo
{
    public static function get(?string $status, ?string $keyword): array
    {
        return [
            'status'  => $status ? \App\Enums\StatusPeminjaman::tryFrom($status)?->label() : 'Semua Status',
            'keyword' => $keyword ?? '-',
            'tanggal' => now()->translatedFormat('d F Y, H:i'),
        ];
    }
}