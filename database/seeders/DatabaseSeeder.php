<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────
        // 1. Admin Default
        // ─────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@pinbuk.test'],
            [
                'name'     => 'Petugas Perpustakaan',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '081234567890',
            ]
        );

        // ─────────────────────────────────────
        // 2. Siswa Default
        // ─────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'siswa@pinbuk.test'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'siswa',
                'nis'      => '2024001',
                'phone'    => '081298765432',
            ]
        );

        // ─────────────────────────────────────
        // 3. Kategori Buku
        // ─────────────────────────────────────
        $kategoris = [
            'Fiksi',
            'Non-Fiksi',
            'Pelajaran',
            'Referensi',
            'Novel',
            'Komik',
        ];

        foreach ($kategoris as $nama) {
            Kategori::updateOrCreate(['nama_kategori' => $nama]);
        }

        // ─────────────────────────────────────
        // 4. Buku Contoh
        // ─────────────────────────────────────
        $kategoriMap = Kategori::pluck('id', 'nama_kategori');

        $bukus = [
            ['BK-001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 5, 'Novel'],
            ['BK-002', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 3, 'Novel'],
            ['BK-003', 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 4, 'Non-Fiksi'],
            ['BK-004', 'Matematika Kelas X', 'Kemendikbud', 'Kemendikbud', 2022, 10, 'Pelajaran'],
            ['BK-005', 'Bahasa Indonesia Kelas X', 'Kemendikbud', 'Kemendikbud', 2022, 8, 'Pelajaran'],
            ['BK-006', 'Sejarah Indonesia', 'Sartono Kartodirdjo', 'Gramedia', 2019, 6, 'Pelajaran'],
            ['BK-007', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 4, 'Novel'],
            ['BK-008', 'Kimia Dasar', 'Ralph H. Petrucci', 'Erlangga', 2011, 5, 'Pelajaran'],
            ['BK-009', 'Ensiklopedia IPA', 'Tim Redaksi', 'Erlangga', 2020, 2, 'Referensi'],
            ['BK-010', 'One Piece Vol. 1', 'Eiichiro Oda', 'Elex Media', 2000, 3, 'Komik'],
            ['BK-011', 'Atomic Habits', 'James Clear', 'Gramedia', 2019, 4, 'Non-Fiksi'],
            ['BK-012', 'Habibie & Ainun', 'B.J. Habibie', 'THC Mandiri', 2010, 3, 'Non-Fiksi'],
        ];

        foreach ($bukus as $b) {
            Buku::updateOrCreate(
                ['kode_buku' => $b[0]],
                [
                    'judul'        => $b[1],
                    'pengarang'    => $b[2],
                    'penerbit'     => $b[3],
                    'tahun_terbit' => $b[4],
                    'stok'         => $b[5],
                    'kategori_id'  => $kategoriMap[$b[6]],
                ]
            );
        }

        $this->command->info('✅ Seeder selesai:');
        $this->command->info('   Admin  : admin@pinbuk.test / password');
        $this->command->info('   Siswa  : siswa@pinbuk.test / password');
        $this->command->info('   Kategori: ' . Kategori::count() . ' baris');
        $this->command->info('   Buku    : ' . Buku::count() . ' baris');
    }
}