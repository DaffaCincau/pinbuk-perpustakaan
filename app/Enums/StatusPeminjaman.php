<?php

namespace App\Enums;

enum StatusPeminjaman: string
{
    case MENUNGGU     = 'menunggu';      // Siswa ajukan, nunggu verifikasi admin
    case DISETUJUI    = 'disetujui';     // Admin approve, siswa belum ambil buku
    case DITOLAK      = 'ditolak';       // Admin reject + alasan
    case DIPINJAM     = 'dipinjam';      // Buku sudah di tangan siswa
    case DIKEMBALIKAN = 'dikembalikan';  // Buku sudah kembali
    case TERLAMBAT    = 'terlambat';     // Lewat tanggal kembali, belum balik

    /**
     * Label untuk ditampilkan di UI (Bahasa Indonesia).
     */
    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU     => 'Menunggu Verifikasi',
            self::DISETUJUI    => 'Disetujui',
            self::DITOLAK      => 'Ditolak',
            self::DIPINJAM     => 'Sedang Dipinjam',
            self::DIKEMBALIKAN => 'Dikembalikan',
            self::TERLAMBAT    => 'Terlambat',
        };
    }

    /**
     * Kelas Tailwind untuk badge (background + text + border).
     */
    public function badgeColor(): string
    {
        return match ($this) {
            self::MENUNGGU     => 'bg-warning/10 text-warning border-warning/30',
            self::DISETUJUI    => 'bg-primary/10 text-primary border-primary/30',
            self::DITOLAK      => 'bg-danger/10 text-danger border-danger/30',
            self::DIPINJAM     => 'bg-accent/10 text-accent border-accent/30',
            self::DIKEMBALIKAN => 'bg-success/10 text-success border-success/30',
            self::TERLAMBAT    => 'bg-danger/10 text-danger border-danger/30',
        };
    }

    /**
     * Daftar semua nilai (untuk dropdown / filter).
     */
    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}