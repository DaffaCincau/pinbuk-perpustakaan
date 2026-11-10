<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Laravel默认 plural "kategoris", tapi kita eksplisit saja

    protected $fillable = [
        'nama_kategori',
    ];

    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class);
    }

    /**
     * Total buku dalam kategori ini (untuk ditampilkan di list).
     */
    public function getTotalBukuAttribute(): int
    {
        return $this->bukus()->count();
    }
}