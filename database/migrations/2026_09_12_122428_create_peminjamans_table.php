<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            // Relasi user & buku
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('buku_id')
                  ->constrained('bukus')
                  ->restrictOnDelete();

            // Tanggal-tanggal penting
            $table->date('tanggal_pinjam');                  // kapan mau pinjam
            $table->date('tanggal_kembali');                 // deadline kembali
            $table->date('tanggal_dikembalikan')->nullable(); // kapan benar-benar kembali

            // Status peminjaman (pakai string, validasi di level aplikasi via Enum)
            $table->string('status', 20)->default('menunggu');

            // Catatan dari admin (alasan reject / pesan tambahan)
            $table->text('catatan')->nullable();

            // Denda (default 0, isi otomatis saat pengembalian jika telat)
            $table->unsignedInteger('denda')->default(0);

            $table->timestamps();

            // Index untuk filter & statistik
            $table->index('status');
            $table->index('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};