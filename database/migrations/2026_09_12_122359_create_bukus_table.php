<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();

            // Kode unik buku (misal: BK-001, BK-002)
            $table->string('kode_buku', 30)->unique();

            // Data buku
            $table->string('judul', 200);
            $table->string('pengarang', 150);
            $table->string('penerbit', 150);
            $table->year('tahun_terbit');

            // Stok — jumlah buku tersedia
            $table->unsignedSmallInteger('stok')->default(0);

            // Cover path (nullable, disimpan sebagai path di storage)
            $table->string('cover')->nullable();

            // Relasi ke kategori
            $table->foreignId('kategori_id')
                  ->constrained('kategoris')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->timestamps();

            // Index untuk search
            $table->index('judul');
            $table->index('pengarang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};