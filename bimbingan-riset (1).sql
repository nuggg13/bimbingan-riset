-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 14, 2025 at 06:33 AM
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
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 2, 1, '2025-08-17', '2025-09-27', '12:09:00', '15:12:00', NULL, 'scheduled', '2025-08-14 04:27:23', '2025-08-14 05:09:59'),
(2, 1, 1, '2025-08-14', '2025-09-30', '09:00:00', '17:00:00', NULL, 'ongoing', '2025-08-14 05:52:35', '2025-08-14 05:52:35'),
(3, 6, 1, '2025-08-17', '2025-09-30', '10:01:00', '18:01:00', NULL, 'scheduled', '2025-08-14 06:00:36', '2025-08-14 06:00:36'),
(4, 5, 1, '2025-08-17', '2025-09-27', '09:00:00', '17:00:00', NULL, 'scheduled', '2025-08-14 06:02:52', '2025-08-14 06:02:52'),
(5, 4, 1, '2025-08-17', '2025-10-01', '09:00:00', '17:00:00', NULL, 'scheduled', '2025-08-14 06:03:13', '2025-08-14 06:03:13');

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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `penjelasan` varchar(255) NOT NULL,
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
(1, 1, 'cara memahami suara melalui web', 'tanpa mic', 'sistematik', 'aplikasi', 'diterima', '2025-08-12 06:41:30', '2025-08-14 05:52:35'),
(2, 2, 'Femboy disekitar kita', 'kadang kita tidak sadar keluarga teman atau bos dikantor kita adalah femboy', 'Artificial Intelligence', 'Web Application', 'diterima', '2025-08-13 03:50:13', '2025-08-14 04:51:03'),
(3, 3, 'cara menghitung peluang mendapatkan teteh sunda gothic', 'Mannnnnnntaaaaaaaappppppppp', 'Data Science', 'IoT System', 'pending', '2025-08-13 04:30:19', '2025-08-13 04:30:19'),
(4, 4, 'adawdsa', 'dawdas', 'Natural Language Processing', 'Mobile Application', 'diterima', '2025-08-13 05:01:18', '2025-08-14 06:03:13'),
(5, 5, 'dasdasdasd', 'adasdasd', 'balsdad', 'dadsada', 'diterima', '2025-08-14 04:34:04', '2025-08-14 06:02:52'),
(6, 6, 'sesuatu yang berlebihan bikin kita merasa puas', 'aku suka berlebihan', 'Psikologi', 'Utilty', 'diterima', '2025-08-14 05:59:39', '2025-08-14 06:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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
(1, 'nugraha', 'nugrahaabisantana@gmail.com', '$2y$10$MRRUfg2ajP.hDyA2sxYOheBx/iyN.DUcx.2SSigt1aadDcrY55ZZm', '0895320904623', 'universitas indonesia', 'Fakultas Ilmu Komputer', '2025-08-12 06:39:40', '2025-08-12 06:39:40'),
(2, 'M.Apriansyah', 'lnata2341@gmail.com', '$2y$12$Zdxd6FSdrxboJYe/nPwcl.3BOfWjKfk7uxI1wljPAU3m.k2VC2jKm', '+62897654321', 'Universitas Indonesia', 'Ilmu sosial', '2025-08-13 03:50:13', '2025-08-13 03:50:13'),
(3, 'nugraha', 'nugra@gmail.com', '$2y$12$uhBVxVx6cPAd1kKr.10tIeM7uVD3OY8FW7J1V.Gd1wA5xn0rBy9iy', '+62891234567', 'Institut Teknologi Bandung', 'FSRD', '2025-08-13 04:30:19', '2025-08-13 04:30:19'),
(4, 'nugraha', 'nuggra@gmail.com', '$2y$12$GA/YoZ1wWDLcGcg88mbmsuhSQnPJ1CQvS.a.CbU8d2beItJ5cCbaa', '+62891234567', 'Institut Teknologi Bandung', 'FSRD', '2025-08-13 05:01:18', '2025-08-13 05:01:18'),
(5, 'nugraha', 'lnata23411@gmail.com', '$2y$12$fq2ufyMVtna2AS.d5IAMcu.DJ1M3PKRvN8JgTwzYX5d19viBffrPy', '+62891234567', 'Institut Teknologi Bandung', 'FSRD', '2025-08-14 04:34:04', '2025-08-14 04:34:04'),
(6, 'Ichigo', 'ichi@gmail.com', '$2y$12$L.14DuWhHnYtitlb5XO/S.jkC103r2f7McxoQvp4lE.qwm76MGrGa', '+62895618270001', 'Institut Teknologi Bandung', 'FSRD', '2025-08-14 05:59:39', '2025-08-14 05:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
