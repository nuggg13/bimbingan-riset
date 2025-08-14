-- Database Update Script for Enhanced Schedule System
-- Add 'hari' column to jadwal table for weekly recurring schedules

-- Add hari column to jadwal table
ALTER TABLE `jadwal` ADD COLUMN `hari` VARCHAR(255) NULL AFTER `jam_akhir` COMMENT 'Hari dalam seminggu (senin,rabu,jumat)';

-- Sample data for testing (optional)
-- Insert sample mentor data
INSERT INTO `mentor` (`nama`, `email`, `password`, `nomor_wa`, `keahlian`, `created_at`, `updated_at`) VALUES
('Dr. Ahmad Fauzi', 'ahmad.fauzi@mentor.com', '$2y$12$AnnipqTnkuVdZJwBs2ROgeny.Ffxdp.z/wH6d9YWnkmF8ZjxZqCBm', '+6281234567890', 'Machine Learning & AI', NOW(), NOW()),
('Prof. Siti Nurhaliza', 'siti.nurhaliza@mentor.com', '$2y$12$AnnipqTnkuVdZJwBs2ROgeny.Ffxdp.z/wH6d9YWnkmF8ZjxZqCBm', '+6281234567891', 'Web Development & Database', NOW(), NOW()),
('Dr. Budi Santoso', 'budi.santoso@mentor.com', '$2y$12$AnnipqTnkuVdZJwBs2ROgeny.Ffxdp.z/wH6d9YWnkmF8ZjxZqCBm', '+6281234567892', 'Mobile Development & UI/UX', NOW(), NOW());

-- Sample schedule with days (optional)
-- This will create a recurring schedule for Mondays and Wednesdays
INSERT INTO `jadwal` (`id_pendaftaran`, `id_mentor`, `tanggal_mulai`, `tanggal_akhir`, `jam_mulai`, `jam_akhir`, `hari`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-01-13', '2025-03-31', '09:00:00', '11:00:00', 'senin,rabu', 'scheduled', NOW(), NOW());

-- Update existing peserta password to be properly hashed (if needed)
-- UPDATE `peserta` SET `password` = '$2y$12$AnnipqTnkuVdZJwBs2ROgeny.Ffxdp.z/wH6d9YWnkmF8ZjxZqCBm' WHERE `id_peserta` = 1;

-- Update existing pendaftaran status to 'diterima' for testing dashboard
UPDATE `pendaftaran` SET `status` = 'diterima' WHERE `id_pendaftaran` = 1;