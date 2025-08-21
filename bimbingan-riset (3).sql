-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2025 at 06:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bimbingan-riset`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_wa` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `password`, `nomor_wa`, `created_at`, `updated_at`) VALUES
(2, 'Administrator', 'admin@bimbinganriset.com', '$2y$12$AnnipqTnkuVdZJwBs2ROgeny.Ffxdp.z/wH6d9YWnkmF8ZjxZqCBm', '081234567890', '2025-08-12 06:17:40', '2025-08-12 06:17:40'),
(3, 'Super Admin', 'superadmin@bimbinganriset.com', '$2y$12$i8/Y0NfNqO3N5QUfXDkTM.v1VaEIpYkv2bG5yqoWEknw8lGVfgPyK', '081234567891', '2025-08-12 06:17:41', '2025-08-12 06:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `catatan_bimbingan`
--

CREATE TABLE `catatan_bimbingan` (
  `id_catatan` int NOT NULL,
  `id_peserta` int NOT NULL,
  `tanggal_bimbingan` date NOT NULL,
  `hasil_bimbingan` text NOT NULL,
  `tugas_perbaikan` text NOT NULL,
  `catatan_tambahan` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `catatan_bimbingan`
--

INSERT INTO `catatan_bimbingan` (`id_catatan`, `id_peserta`, `tanggal_bimbingan`, `hasil_bimbingan`, `tugas_perbaikan`, `catatan_tambahan`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, '2025-08-19', 'Selesai CRUD', 'Beri key pada ID table', 'Perbaiki UI nya', 'published', '2025-08-18 20:20:16', '2025-08-18 20:20:16'),
(2, 7, '2025-08-19', '<p>dwada<em>dawdw</em><strong><em>dawdw</em></strong></p>', '<p>csdcscsdcsd</p>', '<ol><li><strong>cdcdzcdczcczdc<em>czdcd</em></strong></li></ol><ul><li><strong><em>cd</em></strong><strong class=\"ql-font-monospace\"><em>csdcsdccsdc</em></strong><strong class=\"ql-font-monospace\" style=\"background-color: rgb(255, 153, 0);\"><em>csdcdcsdcdscdscdcsdcsdcsdcsdcsdcsdcsdcdcsdcsdcsdcdcsdcdcsdcsdcsddcsdccsdcsd</em></strong></li></ul>', 'published', '2025-08-19 00:57:32', '2025-08-19 00:57:32'),
(3, 8, '2025-08-21', '<p>dadasdasdad</p>', '<p>ddasdasdasdswadasd</p>', '<p>asdasdasdasdasdasdas</p>', 'published', '2025-08-20 21:58:14', '2025-08-20 21:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL,
  `id_pendaftaran` int NOT NULL,
  `id_mentor` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_akhir` time NOT NULL,
  `hari` varchar(255) DEFAULT NULL COMMENT 'Hari dalam seminggu (senin,rabu,jumat)',
  `status` enum('completed','cancelled','ongoing','scheduled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_pendaftaran`, `id_mentor`, `tanggal_mulai`, `tanggal_akhir`, `jam_mulai`, `jam_akhir`, `hari`, `status`, `created_at`, `updated_at`) VALUES
(6, 7, 1, '2025-08-15', '2025-10-18', '09:00:00', '15:00:00', 'senin,rabu,sabtu', 'scheduled', '2025-08-15 01:29:15', '2025-08-15 01:30:12'),
(7, 8, 1, '2025-08-24', '2025-09-30', '09:00:00', '17:00:00', 'senin,kamis,jumat', 'scheduled', '2025-08-21 03:17:23', '2025-08-21 03:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE `mentor` (
  `id_mentor` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_wa` varchar(255) NOT NULL,
  `keahlian` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mentor`
--

INSERT INTO `mentor` (`id_mentor`, `nama`, `email`, `password`, `nomor_wa`, `keahlian`, `created_at`, `updated_at`) VALUES
(1, 'Ozi', 'ozi@gmail.com', '$2y$12$dZ1A0yryFr4EPtnr3axVROUpT3LguBknjHx3Rl3ylYZmKC1bcbVxu', '+6283177012830', 'Fullstack web developer', '2025-08-14 04:25:58', '2025-08-14 05:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_01_08_000001_add_hari_to_jadwal_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `id_peserta` int NOT NULL,
  `judul_riset` varchar(255) NOT NULL,
  `penjelasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `minat_keilmuan` varchar(255) NOT NULL,
  `basis_sistem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('diterima','ditolak','pending','review','konsultasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_peserta`, `judul_riset`, `penjelasan`, `minat_keilmuan`, `basis_sistem`, `status`, `created_at`, `updated_at`) VALUES
(7, 7, 'Sistem Transparansi dan Monitoring Anggaran Daerah Berbasis Web', 'Penelitian ini bertujuan mengembangkan sistem berbasis web untuk mempublikasikan data anggaran pemerintah daerah secara real-time dan mudah diakses masyarakat. Sistem ini akan menampilkan informasi alokasi, penggunaan, dan progres realisasi anggaran dalam bentuk tabel interaktif dan visualisasi grafik. Manfaatnya adalah meningkatkan transparansi, mencegah potensi penyalahgunaan dana, serta memperkuat kepercayaan publik terhadap pengelolaan keuangan daerah.', 'Web Development', 'Web Application', 'diterima', '2025-08-15 01:25:02', '2025-08-15 01:29:15'),
(8, 8, 'bikin orong ketawa dalam 1 detik', 'tertawalah menangislah', 'Psikologi', 'website', 'diterima', '2025-08-21 03:15:31', '2025-08-21 03:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_wa` varchar(20) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `nama`, `email`, `password`, `nomor_wa`, `instansi`, `fakultas`, `created_at`, `updated_at`) VALUES
(7, 'Nugraha abi Santana', 'nugrahaabisantana@gmail.com', '$2y$12$lDva4hsAL0Ayk9ByBkfzYOQml168SAYh0sthVrmRF5pqYh8tJp2Fm', '+62895320904658', 'Universitas Indonesia', 'Fakultas ilmu komputer', '2025-08-15 01:25:02', '2025-08-15 01:38:05'),
(8, 'Tohir', 'tohir@gmail.com', '$2y$12$YzlwI/kmIlM21nUFMPcH3ui0jW.GD4cdNXQiolOGV5Y.2XnVEJK2K', '+62895618270001', 'Universitas Batam', 'Pengecatan', '2025-08-21 03:15:31', '2025-08-21 03:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `update_progress`
--

CREATE TABLE `update_progress` (
  `id_progress` int NOT NULL,
  `id_catatan` int NOT NULL,
  `tanggal_update` date NOT NULL,
  `deskripsi_progress` text NOT NULL,
  `persentase` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `update_progress`
--

INSERT INTO `update_progress` (`id_progress`, `id_catatan`, `tanggal_update`, `deskripsi_progress`, `persentase`, `created_at`) VALUES
(4, 1, '2025-08-19', 'anujh', '50.00', '2025-08-18 21:35:19'),
(5, 1, '2025-08-19', 'edadaw', '58.00', '2025-08-18 21:35:29'),
(6, 1, '2025-08-19', 'xSXSX', '72.00', '2025-08-18 21:49:58'),
(7, 1, '2025-08-19', 'dasdcaad', '12.00', '2025-08-18 21:54:46'),
(8, 2, '2025-08-19', 'vbgvvgvgvgv', '32.00', '2025-08-19 01:14:56'),
(9, 3, '2025-08-21', 'dwdawda', '21.00', '2025-08-20 21:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `catatan_bimbingan`
--
ALTER TABLE `catatan_bimbingan`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD PRIMARY KEY (`id_mentor`);

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
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_peserta_2` (`id_peserta`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`);

--
-- Indexes for table `update_progress`
--
ALTER TABLE `update_progress`
  ADD PRIMARY KEY (`id_progress`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `catatan_bimbingan`
--
ALTER TABLE `catatan_bimbingan`
  MODIFY `id_catatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mentor`
--
ALTER TABLE `mentor`
  MODIFY `id_mentor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `update_progress`
--
ALTER TABLE `update_progress`
  MODIFY `id_progress` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
