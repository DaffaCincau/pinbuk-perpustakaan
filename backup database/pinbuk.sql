-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2026 at 10:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinbuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `bukus`
--

CREATE TABLE `bukus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_buku` varchar(30) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `pengarang` varchar(150) NOT NULL,
  `penerbit` varchar(150) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `stok` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `cover` varchar(255) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bukus`
--

INSERT INTO `bukus` (`id`, `kode_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `cover`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, 'BK-001', 'Pemeliharaan dan Perbaikan Peralatan Elekronika industri', 'Prih Harjanto', 'Liniswara', '2019', 20, 'covers/LftaWzi2FZLmkS6iWA3S1l5V11kldO4hWBoiCVUd.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 08:06:18'),
(2, 'BK-002', 'Konsentrasi Keahlian Teknik Mesin', '-', 'Daihatsu', '2023', 20, 'covers/W4uD15277wvmTRNARUs8H3eX2jGhRSMUB76g3lUD.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 08:09:50'),
(3, 'BK-003', 'Menggambar 2D dengan Autocad', 'Anik Rahwani. W. S.T., M.T', 'Deepublish Store', '2018', 20, 'covers/A0qNSvuqNzmPYXKtiYXk5cayS79uRy3Ozf3zpPVl.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 08:13:49'),
(4, 'BK-004', 'PHP MySQL', 'Dr.Eng.Rismon H.Sianipar,S.T,M.T.,M.Eng.', 'Penerbit Andi', '2019', 20, 'covers/sRkRNllH2J4xjqR6LyCKJenwgRYcEfbkgb2YsZzq.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 08:17:19'),
(5, 'BK-005', 'Kreativitas,Inovasi,dan Kewirusahaan (XII)', 'Andi Novianto, Maryanti Wiji Khurniawati', 'Erlangga', '2026', 30, 'covers/1IKRPzr6NT5yo9oaLXIHicfIqP1eUvOgiU62CUbY.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 22:30:32'),
(6, 'BK-006', 'KIK (XI)', 'Sartono Kartodirdjo', 'Gramedia', '2019', 6, 'covers/BRgFk1wGsCxvowJY3MMyZhmzvDvtlLJXQx6oLmH7.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 08:25:51'),
(7, 'BK-007', 'Siaga TKA', 'Ahmad Fuadi', 'Gramedia', '2009', 4, 'covers/XQBQPSpw6vIk9kIueud4TJDPRUk4zvjLEzc76Xfi.jpg', 4, '2026-09-12 05:28:02', '2026-11-10 13:36:54'),
(8, 'BK-008', 'Pendidikan Pancasila (XII)', 'Rochimudin', 'Bumi Aksara', '2024', 30, 'covers/FwN9P1J1JSpBFz6Dd1GRgLzw38hOmA95ORBNV1Tg.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 22:40:27'),
(9, 'BK-009', 'Pendidikan Pancasila (XI)', 'Rochimudin', 'Bumi Aksara', '2024', 30, 'covers/64l2aMeWCaBc67GeKQqvgJycIjQLcU5gMTSgYpSI.jpg', 3, '2026-09-12 05:28:02', '2026-11-10 13:36:34'),
(10, 'BK-010', 'Pendidikan Pancasila (X)', 'Rochimudin', 'Bumi Aksara', '2022', 30, 'covers/sdHP2G7I3t3xO312Xh4jOqRFIajX1Z6XLiDe4cBt.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 22:44:28'),
(11, 'BK-011', 'SPLASH (Smart Path To Learning English) (XII)', 'Dra. Anik Muslikah Indriastu, M.Ed.', 'Erlangga', '2023', 30, 'covers/h1DINfJ5rQzkgVFafkyD4l3zAAwr95vdI0lbXpg0.jpg', 3, '2026-09-12 05:28:02', '2026-11-04 22:48:05'),
(12, 'BK-012', 'Bahasa Indonesia (XI)', 'Pipit Dwi Komariah', 'Erlangga', '2023', 30, 'covers/44N14D8iHWJOXd9pBTnv6HiY8yWQ2LRVCG9wxLRc.jpg', 3, '2026-09-12 05:28:02', '2026-11-09 05:00:23'),
(13, 'bk-2000', 'Penerapan Rangkaian Elekronika', 'Ice Faulia', 'Liniswara', '2026', 20, 'covers/AW8BJ9PFl5MxU9kB8fimy9RnmmX26wlwUdh8Gpny.jpg', 3, '2026-11-02 23:50:35', '2026-11-04 08:00:11'),
(15, 'BK-050', 'Bahasa Indonesia (X)', 'Pipit Dwi Komariah', 'Erlangga', '2022', 30, 'covers/KW8unJTRSCnSDA4jD1lfk28xoruT3Uungy8Mq7pT.jpg', 3, '2026-11-09 05:07:22', '2026-11-09 05:07:22'),
(16, 'BK-051', 'PAIBP (XI)', 'H. A. Sholeh Dimyathi, Munawir AM, Hj. Iim Halimah, H. Abd. Rahman, H. Ridhwan Ms.', 'Erlangga', '2023', 30, 'covers/xuMzcigvmlsJxKD2hx2ERFacfyl22dy425TFUR1F.jpg', 3, '2026-11-09 05:11:49', '2026-11-09 05:11:49'),
(17, 'BK-052', 'PAIBP (XII)', 'H. A. Sholeh Dimyathi, Munawir AM, Hj. Iim Halimah, H. Abd. Rahman, H. Ridhwan Ms.', 'Erlangga', '2024', 30, 'covers/ttO5g3BDWjI0AGeE0WJv5hhP4jnnjiU4J7bI2avb.jpg', 3, '2026-11-09 05:13:17', '2026-11-09 05:13:17'),
(18, 'BK-053', 'PAIBP (X)', 'H. A. Sholeh Dimyathi, Munawir AM, Hj. Iim Halimah, H. Abd. Rahman, H. Ridhwan Ms.', 'Erlangga', '2022', 30, 'covers/P0g2v78Z0J3J29U28QMUg9S0fzPCCqn8hEWDPKJ9.jpg', 3, '2026-11-09 05:14:29', '2026-11-09 05:14:29'),
(19, 'BK-054', 'X-PRESS TKA (Bahasa Inggris)', 'Tim Edusolve', 'Erlangga', '2025', 30, 'covers/zKdTc9bDTCV4MFbDExM6Nr1hYHchdxewF8MMresI.jpg', 4, '2026-11-09 05:17:49', '2026-11-09 05:17:49'),
(20, 'BK-055', 'X-PRESS TKA (Matematika)', 'Kasmina & Toali', 'Erlangga', '2025', 30, 'covers/cUZwRCBRq0CwGfLDSQ8Y5szzGXURI0HciydTTJsX.jpg', 4, '2026-11-09 05:19:46', '2026-11-09 05:19:46'),
(21, 'BK-056', 'X-PRESS TKA (Bahasa Indonesia)', 'Pipit Dwi Komariah', 'Erlangga', '2025', 30, 'covers/NT5O5Hev0jIZRdhMyKDdet1xLuBOYQK25Jc19hjM.jpg', 4, '2026-11-09 05:21:25', '2026-11-09 05:21:25'),
(22, 'BK-057', 'SPLASH (Smart Path to Learning English XI)', 'Anik M. Indriastuti', 'Erlangga', '2023', 30, 'covers/IVCRXhtQPKGl6oNHAaCpyzC0Cj8YR2VCnMoGFvSh.jpg', 3, '2026-11-09 05:25:46', '2026-11-09 05:25:46'),
(23, 'BK-0558', 'SPLASH (Smart Path to  Learning English XI)', 'Anik M. Indriastuti', 'Erlangga', '2023', 30, 'covers/QCQzhuTVHatuOxFqeWUYJbgIQH8F2bAJXB1tBL1M.jpg', 3, '2026-11-09 05:27:25', '2026-11-09 05:27:25'),
(24, 'BK-059', 'Bahasa Indonesia (XII)', 'Pipit Dwi Komariah', 'Erlangga', '2023', 30, 'covers/XKysJ8H7wlQEwe9FyHhUT5KnHhQqfmIIkosXLj0B.jpg', 3, '2026-11-09 05:30:48', '2026-11-09 05:30:48'),
(25, 'BK-060', 'Sejarah (XI)', 'Brilliantoro Yusuf Ervanda & Pandji Saputra', 'Bumi Aksara', '2023', 30, 'covers/2ivbas11JRUuvhQJhwBaTugfQ5a77YthrXO3qszn.jpg', 3, '2026-11-09 05:33:12', '2026-11-09 05:33:47'),
(26, 'BK-061', 'Sejarah (X)', 'Ratna Hapsari & M. Adil', 'Erlangga', '2022', 30, 'covers/o70hYMWOc0puou5636HOmnSZe91X4EQ3h37acVrc.jpg', 3, '2026-11-09 05:35:42', '2026-11-09 05:35:42'),
(27, 'BK-062', 'Matematika (XII)', 'Arif Ediyanto & Maya Harsani', 'Erlangga', '2024', 30, 'covers/Q260A0gUqpNCOHV8tHkFD3oS8R8NwkQGBZwcc89A.jpg', 3, '2026-11-09 05:37:51', '2026-11-09 05:37:51'),
(28, 'BK-063', 'Matematika (X)', 'Arif Ediyanto & Maya Harsani', 'Erlangga', '2022', 30, 'covers/EuvZRxML7WkHhnKwZb7Bm8XE90yUuBNSvzUSJfMS.jpg', 3, '2026-11-09 05:39:21', '2026-11-09 05:39:21'),
(29, 'BK-064', 'Matematika (XI)', 'Arif Ediyanto & Maya Harsani', 'Erlangga', '2022', 30, 'covers/FLflj6YASKPXir2SNy6M2xuYKA6a8dPEebe7bbkh.jpg', 3, '2026-11-09 05:40:26', '2026-11-09 05:40:26'),
(30, 'BK-065', 'Pemrograman Android Dengan Flutter', 'Budi Raharjo', 'Informatika Bandung', '2021', 25, 'covers/xkKvoCEjA4jHPKoWsvanbZblFfzc7eJq6jdKLQm7.jpg', 4, '2026-11-10 13:42:13', '2026-11-10 13:42:13'),
(31, 'BK-066', 'Ensiklopedia Fisika Zat dan Perubahannya', 'Sri Soeyati', 'Geneca Exact', '2007', 20, 'covers/M9GnnmGnM8MAZ2pkAGdVsoDXD7tfCZGQYI0MtT1t.jpg', 4, '2026-11-10 13:46:10', '2026-11-10 13:46:10'),
(32, 'BK-067', 'Ensiklopedia Fisika Gaya,Usaha,dan Energi', 'Sri Soeyati,Agus Salam', 'Geneca Exact', '2007', 20, 'covers/MBxTd2vkiJBW1mWzEqzw7ScthH2I5xx0fvswSpXb.jpg', 4, '2026-11-10 13:54:59', '2026-11-10 13:54:59'),
(33, 'BK-068', 'Ensiklopedia Fisika Listrik dan Magnet', 'Agus Salam', 'Geneca Exact', '2027', 20, 'covers/zzs3jxggusygAFOfu1sWzxIAUwTaPK50UdnawApc.jpg', 4, '2026-11-10 13:56:01', '2026-11-10 13:56:01'),
(34, 'BK-069', 'Ensiklopedia Fisika Cahaya dan Optik', 'Agus Salam,Sri Soeyati', 'Geneca Exact', '2007', 20, 'covers/oEAjSzcMacHnY2D0nw9fX0dj4ff2c3E44GA8lTxl.jpg', 4, '2026-11-10 13:57:55', '2026-11-10 13:58:05'),
(35, 'BK-070', 'Project X The New Beginning Of Net Detective Indonesia', 'Tim penulis NDI', 'Visimedia', '2014', 15, 'covers/PNfeRNwOm14H3KfNImFIplNp6bk6HYu2M9pdxIep.jpg', 5, '2026-11-10 14:02:43', '2026-11-10 14:02:43'),
(36, 'BK-071', 'Lebay 24 Karat', 'Kristiananda', 'ANDI', '2014', 15, 'covers/egU9UzHAI3obtf57v4Erwnpda63SKRhK9qMNc3NE.jpg', 5, '2026-11-10 14:06:36', '2026-11-10 14:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pinbuk-cache-admin@pinbuk.tes|127.0.0.1', 'i:2;', 1794228937),
('pinbuk-cache-admin@pinbuk.tes|127.0.0.1:timer', 'i:1794228937;', 1794228937),
('pinbuk-cache-budi@gmail.com|127.0.0.1', 'i:1;', 1793619298),
('pinbuk-cache-budi@gmail.com|127.0.0.1:timer', 'i:1793619298;', 1793619298);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(3, 'Pelajaran', '2026-09-12 05:28:02', '2026-09-12 05:28:02'),
(4, 'Referensi', '2026-09-12 05:28:02', '2026-09-12 05:28:02'),
(5, 'Novel', '2026-09-12 05:28:02', '2026-09-12 05:28:02'),
(6, 'Komik', '2026-09-12 05:28:02', '2026-09-12 05:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_12_122207_add_role_and_profile_to_users_table', 2),
(5, '2026_09_12_122324_create_kategoris_table', 2),
(6, '2026_09_12_122359_create_bukus_table', 2),
(7, '2026_09_12_122428_create_peminjamans_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `denda` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_dikembalikan`, `status`, `catatan`, `denda`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-09-20', '2026-09-27', '2026-09-20', 'dikembalikan', NULL, 0, '2026-09-20 02:30:03', '2026-09-20 02:34:11'),
(2, 2, 2, '2026-11-03', '2026-11-17', NULL, 'menunggu', NULL, 0, '2026-11-02 17:44:55', '2026-11-02 17:44:55'),
(3, 2, 4, '2026-11-03', '2026-11-02', NULL, 'dipinjam', NULL, 0, '2026-11-02 17:45:25', '2026-11-03 07:07:36'),
(4, 2, 5, '2026-11-03', '2026-11-17', NULL, 'dipinjam', NULL, 0, '2026-11-02 21:09:23', '2026-11-02 21:10:01'),
(5, 2, 3, '2026-11-03', '2026-11-17', NULL, 'dipinjam', NULL, 0, '2026-11-02 23:38:28', '2026-11-03 07:05:13'),
(6, 2, 1, '2026-11-03', '2026-12-03', '2026-11-03', 'dikembalikan', NULL, 0, '2026-11-02 23:47:43', '2026-11-03 07:26:12'),
(7, 2, 12, '2026-11-04', '2026-11-07', NULL, 'menunggu', NULL, 0, '2026-11-03 22:41:28', '2026-11-03 22:41:28'),
(8, 2, 13, '2026-11-08', '2026-11-19', NULL, 'ditolak', 'Batal otomatis: Melewati batas waktu pengambilan buku (2 hari).', 0, '2026-11-05 00:00:48', '2026-11-07 03:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5RjqfvzRYRiJT6Jw9dXP8CJ5LxAaM4AJlTWd4TKt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36 Edg/157.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYUVSS2pzaDVoc1FLYU45OHdBM0oyelVETDJHNmJCdTNpQk1TVFVOTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9idWt1cyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4uYnVrdXMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1794344983),
('nEM66BNWS92DkI9TdDOTVTvHxrzyIyycdao3oltU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36 Edg/157.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHlxbUpVZnM1anIxZDdyMmVGUFZ6Q2tZQk9Fa21UQW9GWVh5dW5rMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1794229092),
('xfqQysMekzQu12JospzhKlHyqWvzSyxfTzPSCDIE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36 Edg/157.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQWp2TG1BeGdIVExVRml0eDlzcXlvS3cyNGtmNml1YW1jV0J1NzBnYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1794225450);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('siswa','admin') NOT NULL DEFAULT 'siswa',
  `nis` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `nis`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Petugas Perpustakaan', 'admin@pinbuk.test', 'admin', NULL, '081234567890', NULL, '$2y$12$DU79ymw6c6lKSQtGF6YAgODJqKRRfTXmpZ8djpDxFHx5Jm2eMGCbu', NULL, '2026-09-12 05:28:01', '2026-09-12 05:28:01'),
(2, 'Budi Santoso', 'siswa@pinbuk.test', 'siswa', '2024001', '081298765432', NULL, '$2y$12$qliAtkK5exly6U..Gm4Vdui3MTycmrtrLWbkf0sFLdTppOZcDdIo2', NULL, '2026-09-12 05:28:02', '2026-09-12 05:28:02'),
(3, 'Daffa Abdul Haris', 'farih34@gmail.com', 'siswa', NULL, NULL, NULL, '$2y$12$F08NUP6G5TlFLWIO1r16fuaWf4GwrWAo.JYZl8Tz2sMYieP4vyky6', NULL, '2026-10-19 18:09:07', '2026-10-19 18:09:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bukus_kode_buku_unique` (`kode_buku`),
  ADD KEY `bukus_kategori_id_foreign` (`kategori_id`),
  ADD KEY `bukus_judul_index` (`judul`),
  ADD KEY `bukus_pengarang_index` (`pengarang`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_nama_kategori_unique` (`nama_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamans_user_id_foreign` (`user_id`),
  ADD KEY `peminjamans_buku_id_foreign` (`buku_id`),
  ADD KEY `peminjamans_status_index` (`status`),
  ADD KEY `peminjamans_tanggal_kembali_index` (`tanggal_kembali`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nis_unique` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukus`
--
ALTER TABLE `bukus`
  ADD CONSTRAINT `bukus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`),
  ADD CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
