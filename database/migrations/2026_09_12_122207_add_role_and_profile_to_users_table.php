<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: 'siswa' atau 'admin' — default siswa
            $table->enum('role', ['siswa', 'admin'])
                  ->default('siswa')
                  ->after('email');

            // NIS (Nomor Induk Siswa) — nullable karena admin tidak punya NIS
            $table->string('nis', 20)
                  ->nullable()
                  ->unique()
                  ->after('role');

            // Nomor HP / WhatsApp
            $table->string('phone', 20)
                  ->nullable()
                  ->after('nis');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nis', 'phone']);
        });
    }
};