<?php

namespace App\Models;

use App\Enums\StatusPeminjaman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok', 'cover', 'kategori_id',
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'stok'         => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function peminjamanAktif(): HasMany
    {
        return $this->peminjamans()->whereIn('status', [
            StatusPeminjaman::DIPINJAM->value,
            StatusPeminjaman::TERLAMBAT->value,
        ]);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return Storage::disk('public')->url($this->cover);
        }

        // SVG Diperbaiki untuk Light Mode (Background Putih/Abu terang)
        return 'data:image/svg+xml;utf8,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 300">
                <rect width="200" height="300" fill="#F8FAFC"/>
                <rect x="20" y="20" width="160" height="260" fill="#FFFFFF" stroke="#E2E8F0" stroke-width="2" rx="6"/>
                <text x="100" y="150" font-family="sans-serif" font-size="14" fill="#94A3B8" text-anchor="middle">No Cover</text>
                <path d="M70 180h60M70 195h40" stroke="#3B82F6" stroke-width="3" stroke-linecap="round"/>
            </svg>'
        );
    }

    public function isTersedia(): bool
    {
        return $this->stok > 0;
    }

    public function getSedangDipinjamAttribute(): int
    {
        return $this->peminjamanAktif()->count();
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (blank($keyword)) return $query;
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('pengarang', 'like', "%{$keyword}%")
              ->orWhere('penerbit', 'like', "%{$keyword}%")
              ->orWhere('kode_buku', 'like', "%{$keyword}%");
        });
    }
}