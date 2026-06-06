-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 11:04 AM
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
-- Database: `inventaris_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL DEFAULT 'pcs',
  `kondisi` enum('Baik','Rusak') NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `stok`, `satuan`, `kondisi`, `lokasi`, `keterangan`, `tanggal_masuk`, `id_kategori`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'BRG-001', 'Laptop ASUS VivoBook', 10, 'pcs', 'Baik', 'Ruang IT', NULL, '2026-06-03', 1, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(2, 'BRG-002', 'Printer Epson L3210', 5, 'pcs', 'Baik', 'Gudang Inventaris', NULL, '2026-06-03', 1, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(3, 'BRG-003', 'Proyektor Epson EB-X06', 3, 'pcs', 'Baik', 'Ruang Multimedia', NULL, '2026-06-03', 1, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(4, 'BRG-004', 'Kursi Kantor Staff', 20, 'pcs', 'Baik', 'Ruang Administrasi', NULL, '2026-06-03', 2, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(5, 'BRG-005', 'Meja Kerja Kayu', 15, 'pcs', 'Baik', 'Ruang Administrasi', NULL, '2026-06-03', 2, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(6, 'BRG-006', 'Lemari Arsip Besi', 8, 'pcs', 'Baik', 'Ruang Arsip', NULL, '2026-06-03', 2, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(7, 'BRG-007', 'Kertas HVS A4', 100, 'pcs', 'Baik', 'Gudang ATK', NULL, '2026-06-03', 3, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(8, 'BRG-008', 'Pulpen Standard', 50, 'pcs', 'Baik', 'Gudang ATK', NULL, '2026-06-03', 3, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(9, 'BRG-009', 'Stapler Besar', 12, 'pcs', 'Rusak', 'Gudang ATK', NULL, '2026-06-03', 3, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(10, 'BRG-010', 'Monitor LG 24 Inch', 6, 'pcs', 'Rusak', 'Ruang IT', NULL, '2026-06-03', 1, 1, '2026-06-03 15:53:44', '2026-06-03 15:53:44'),
(13, 'tes', 'tes', 0, 'pcs', '', '123', '', '2026-06-05', 3, 1, '2026-06-05 02:16:02', '2026-06-05 02:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Elektronik', NULL),
(2, 'Furnitur', NULL),
(3, 'ATK', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jenis` enum('masuk','keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `id_barang`, `id_user`, `jenis`, `jumlah`, `keterangan`, `tanggal`) VALUES
(1, 13, 1, 'keluar', 123, '123', '2026-06-05 02:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `create_at`) VALUES
(1, 'Admin', 'admin', 'admin123', 'admin', '2026-06-03 15:29:32'),
(2, 'Akira', 'akira', 'akira123', 'user', '2026-06-03 15:29:32'),
(6, 'testbaru', 'tes', 'tes123', 'user', '2026-06-04 21:17:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `riwayat_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `riwayat_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
