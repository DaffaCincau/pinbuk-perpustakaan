# 📚 PINBUK — Sistem Informasi Peminjaman Buku

Sistem Informasi Peminjaman Buku untuk **Perpustakaan SMK Negeri 5 Surakarta**.

## 🎯 Fitur

### Untuk Siswa
- 📖 Cari & jelajahi katalog buku
- 📝 Ajukan peminjaman buku secara mandiri
- 📊 Pantau status peminjaman (menunggu/dipinjam/dikembalikan/terlambat)
- 📜 Lihat riwayat peminjaman

### Untuk Admin/Petugas
- 📊 Dashboard statistik perpustakaan
- 📚 CRUD Buku (dengan upload cover)
- 🏷️ CRUD Kategori
- ✅ Verifikasi pengajuan (approve/reject)
- 🔄 Catat pengembalian + hitung denda otomatis
- 📤 Export laporan (Excel & PDF)

## 🛠️ Tech Stack

- **Laravel 12** + **PHP 8.2+**
- **MySQL** (database)
- **Laravel Breeze** (authentication)
- **Blade** + **Tailwind CSS** (frontend)
- **Alpine.js** (interactivity)
- **Maatwebsite/Excel** (export Excel)
- **barryvdh/laravel-dompdf** (export PDF)

## 📋 Persyaratan Sistem

Sebelum install, pastikan sudah terpasang:

| Software | Versi Minimum |
|---|---|
| PHP | 8.2 |
| Composer | 2.x |
| MySQL / MariaDB | 5.7+ |
| Node.js | 20.19+ atau 22.12+ |
| npm | 10+ |

**Cek versi terpasang:**
```bash
php -v
composer --version
mysql --version
node -v
npm -v