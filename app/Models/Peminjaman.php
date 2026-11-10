<?php

namespace App\Models;

use App\Enums\StatusPeminjaman;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    public const DENDA_PER_HARI = 1000;
    public const BATAS_AMBIL_HARI = 2; // Batas waktu pengambilan (dalam hari)

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'catatan',
        'denda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'        => 'date',
            'tanggal_kembali'       => 'date',
            'tanggal_dikembalikan'  => 'date',
            'status'                => StatusPeminjaman::class,
            'denda'                 => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function hariTerlambat(): int
    {
        if ($this->tanggal_dikembalikan) {
            $batas = $this->tanggal_kembali;
            $aktual = $this->tanggal_dikembalikan;
        } else {
            $batas = $this->tanggal_kembali;
            $aktual = Carbon::today();
        }

        if ($aktual->lessThanOrEqualTo($batas)) {
            return 0;
        }

        return $batas->diffInDays($aktual);
    }

    public function hitungDenda(): int
    {
        return $this->hariTerlambat() * self::DENDA_PER_HARI;
    }

    public function isAktif(): bool
    {
        return in_array($this->status, [
            StatusPeminjaman::DIPINJAM,
            StatusPeminjaman::TERLAMBAT,
        ], true);
    }

    public function isPending(): bool
    {
        return $this->status === StatusPeminjaman::MENUNGGU;
    }

    // ==========================================
    // FITUR BARU: Cek Kedaluwarsa Pengambilan
    // ==========================================
    public function cekKedaluwarsa(): bool
    {
        // Hanya cek jika status masih DISETUJUI
        if ($this->status !== StatusPeminjaman::DISETUJUI) {
            return false;
        }

        // Hitung batas waktu (misal: tanggal disetujui + 2 hari)
        // Kita gunakan updated_at sebagai acuan kapan status diubah ke DISETUJUI
        $batasWaktu = $this->updated_at->copy()->addDays(self::BATAS_AMBIL_HARI);
        
        if (Carbon::now()->greaterThan($batasWaktu)) {
            // Jika sudah lewat, ubah status jadi DITOLAK
            $this->update([
                'status'  => StatusPeminjaman::DITOLAK,
                'catatan' => 'Batal otomatis: Melewati batas waktu pengambilan buku (' . self::BATAS_AMBIL_HARI . ' hari).'
            ]);
            return true;
        }

        return false;
    }

    public function scopeStatus($query, ?string $status)
    {
        if (blank($status)) return $query;
        return $query->where('status', $status);
    }

    public function scopeTerlambat($query)
    {
        return $query->whereIn('status', [
                StatusPeminjaman::DIPINJAM->value,
                StatusPeminjaman::TERLAMBAT->value,
            ])
            ->where('tanggal_kembali', '<', Carbon::today());
    }
}