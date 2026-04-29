-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 04:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `satria`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int(11) UNSIGNED NOT NULL,
  `usulan_id` int(11) UNSIGNED NOT NULL,
  `tipe_dokumen` enum('ktp','sertifikat','gambar','lainnya') NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id`, `usulan_id`, `tipe_dokumen`, `filename`, `original_name`, `mime_type`, `file_size`, `created_at`, `updated_at`) VALUES
(1, 1, 'sertifikat', '1764282657_d4368ce17bbc622443fe.pdf', '4b4d097e08a20955854fdce4ee04d37f.pdf', '', 70933, '2025-11-27 22:30:57', '2025-11-27 22:30:57'),
(2, 5, 'sertifikat', '1764282883_eeb8afdf362746e94dff.pdf', '4b4d097e08a20955854fdce4ee04d37f.pdf', '', 70933, '2025-11-27 22:34:43', '2025-11-27 22:34:43'),
(3, 6, 'sertifikat', '1764282988_2d8244afacd3e017061a.pdf', '4b4d097e08a20955854fdce4ee04d37f (1).pdf', '', 70933, '2025-11-27 22:36:28', '2025-11-27 22:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-11-18-042515', 'App\\Database\\Migrations\\CreateSatriaTables', 'default', 'App', 1763440151, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pemohon`
--

CREATE TABLE `pemohon` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` text NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` text NOT NULL,
  `email` text NOT NULL,
  `jenis_pemohon` enum('perorangan','perusahaan','instansi','yayasan','lainnya') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pemohon`
--

INSERT INTO `pemohon` (`id`, `nama`, `nik`, `alamat`, `no_hp`, `email`, `jenis_pemohon`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', '7171010101900002', 'Jl. Raya Tomohon No. 123', '+6281234567890', 'budi.santoso@example.com', 'perorangan', '2025-11-27 22:30:57', '2025-11-27 22:30:57'),
(2, 'Budi Santoso', '7171010101900002', 'Jl. Raya Tomohon No. 123', '+6281234567890', 'budi.santoso@example.com', 'perorangan', '2025-11-27 22:33:02', '2025-11-27 22:33:02'),
(3, 'Budi Santoso', '7171010101900002', 'Jl. Raya Tomohon No. 123', '+6281234567890', 'budi.santoso@example.com', 'perorangan', '2025-11-27 22:33:29', '2025-11-27 22:33:29'),
(4, 'Budi Santoso', '7171010101900002', 'Jl. Raya Tomohon No. 123', '+6281234567890', 'budi.santoso@example.com', 'perorangan', '2025-11-27 22:34:23', '2025-11-27 22:34:23'),
(5, 'Budi Santoso', '7171010101900002', 'Jl. Raya Tomohon No. 123', '+6281234567890', 'budi.santoso@example.com', 'perorangan', '2025-11-27 22:34:43', '2025-11-27 22:34:43'),
(6, 'Coba Nama', '7171010101900002', 'Tomohon', '+6281234567890', 'rsudanugerah@tomohon.go.id', 'perorangan', '2025-11-27 22:36:28', '2025-11-27 22:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','petugas','user') NOT NULL DEFAULT 'petugas',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$9H4UbaqkneEA5zVyCx92heDpuHP5q29cYtC7Ezdn5fLzvt5IVUmfy', 'admin', NULL, NULL),
(2, 'petugas', '$2y$10$jflHQGAtgjP6FM55Rmy6Q.5AsWvsYpaEiwwp27wN4TzUV/IezuHbu', 'petugas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usulan`
--

CREATE TABLE `usulan` (
  `id` int(11) UNSIGNED NOT NULL,
  `pemohon_id` int(11) UNSIGNED NOT NULL,
  `alamat_lokasi` varchar(255) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL DEFAULT 'Tomohon Tengah',
  `koordinat_lat` decimal(10,7) DEFAULT NULL,
  `koordinat_lng` decimal(10,7) DEFAULT NULL,
  `luas_tanah` decimal(12,2) DEFAULT NULL,
  `zona_rtrw` varchar(100) DEFAULT NULL,
  `kdb` decimal(5,2) DEFAULT NULL,
  `klb` decimal(5,2) DEFAULT NULL,
  `jenis_bangunan` varchar(100) NOT NULL,
  `tinggi_bangunan` decimal(5,2) DEFAULT NULL,
  `luas_bangunan` decimal(12,2) DEFAULT NULL,
  `jumlah_lantai` tinyint(4) DEFAULT NULL,
  `status` enum('draft','submitted','approved','rejected','lainnya') NOT NULL DEFAULT 'draft',
  `catatan_verifikasi` text DEFAULT NULL,
  `nomor_tiket` varchar(30) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usulan`
--

INSERT INTO `usulan` (`id`, `pemohon_id`, `alamat_lokasi`, `kelurahan`, `kecamatan`, `koordinat_lat`, `koordinat_lng`, `luas_tanah`, `zona_rtrw`, `kdb`, `klb`, `jenis_bangunan`, `tinggi_bangunan`, `luas_bangunan`, `jumlah_lantai`, `status`, `catatan_verifikasi`, `nomor_tiket`, `submitted_at`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jl. Lingkar Timur, Tomohon', 'Tondangow', 'Tomohon Selatan', '1.2654320', '124.8321090', '500.00', 'Permukiman', '0.60', '1.20', 'Rumah Tinggal', '8.00', '200.00', 2, 'submitted', NULL, 'KRK-2025-0001', '2025-11-27 22:30:57', NULL, '2025-11-27 22:30:57', '2025-11-27 22:30:57'),
(2, 2, 'Jl. Lingkar Timur, Tomohon', 'Tondangow', 'Tomohon Selatan', '1.2654320', '124.8321090', '500.00', 'Permukiman', '0.60', '1.20', 'Rumah Tinggal', '8.00', '200.00', 2, 'submitted', NULL, 'KRK-2025-0002', '2025-11-27 22:33:02', NULL, '2025-11-27 22:33:02', '2025-11-27 22:33:02'),
(3, 3, 'Jl. Lingkar Timur, Tomohon', 'Tondangow', 'Tomohon Selatan', '1.2654320', '124.8321090', '500.00', 'Permukiman', '0.60', '1.20', 'Rumah Tinggal', '8.00', '200.00', 2, 'submitted', NULL, 'KRK-2025-0003', '2025-11-27 22:33:29', NULL, '2025-11-27 22:33:29', '2025-11-27 22:33:29'),
(4, 4, 'Jl. Lingkar Timur, Tomohon', 'Tondangow', 'Tomohon Selatan', '1.2654320', '124.8321090', '500.00', 'Permukiman', '0.60', '1.20', 'Rumah Tinggal', '8.00', '200.00', 2, 'approved', NULL, 'KRK-2025-0004', '2025-11-27 22:34:23', '2025-11-27 22:36:22', '2025-11-27 22:34:23', '2025-11-27 22:36:22'),
(5, 5, 'Jl. Lingkar Timur, Tomohon', 'Tondangow', 'Tomohon Selatan', '1.2654320', '124.8321090', '500.00', 'Permukiman', '0.60', '1.20', 'Rumah Tinggal', '8.00', '200.00', 2, 'approved', NULL, 'KRK-2025-0005', '2025-11-27 22:34:43', '2025-11-27 22:36:17', '2025-11-27 22:34:43', '2025-11-27 22:36:17'),
(6, 6, 'matani 2', 'Matani Dua', 'Tomohon Tengah', '1.3186630', '124.8421170', '98.00', 'Pasal 70', NULL, NULL, 'rumah', '5.00', '80.00', 2, 'submitted', NULL, 'KRK-2025-0006', '2025-11-27 22:36:28', NULL, '2025-11-27 22:36:28', '2025-11-27 22:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `zonasi_geojson`
--

CREATE TABLE `zonasi_geojson` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_layer` varchar(100) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_usulan_id_foreign` (`usulan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemohon`
--
ALTER TABLE `pemohon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usulan`
--
ALTER TABLE `usulan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_tiket` (`nomor_tiket`),
  ADD KEY `usulan_pemohon_id_foreign` (`pemohon_id`);

--
-- Indexes for table `zonasi_geojson`
--
ALTER TABLE `zonasi_geojson`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemohon`
--
ALTER TABLE `pemohon`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usulan`
--
ALTER TABLE `usulan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zonasi_geojson`
--
ALTER TABLE `zonasi_geojson`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_usulan_id_foreign` FOREIGN KEY (`usulan_id`) REFERENCES `usulan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usulan`
--
ALTER TABLE `usulan`
  ADD CONSTRAINT `usulan_pemohon_id_foreign` FOREIGN KEY (`pemohon_id`) REFERENCES `pemohon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
