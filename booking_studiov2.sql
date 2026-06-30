-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Generation Time: Jan 08, 2026 at 10:25 AM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40771898_studio_musik`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin jjenaissante', 'admin@gmail.com', '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC', '2026-01-06 08:58:07', '2026-01-08 14:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` varchar(10) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_ruangan` varchar(10) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `durasi` int(11) DEFAULT NULL,
  `status_booking` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_booking`
--

CREATE TABLE `detail_booking` (
  `id_booking` varchar(10) NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `total_bayar` decimal(10,3) NOT NULL,
  `metode_pembayaran` enum('cash','transfer','online') DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT 'pending',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ketersediaan`
--

CREATE TABLE `jadwal_ketersediaan` (
  `id_jadwal` int(11) NOT NULL,
  `id_ruangan` varchar(10) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('available','booked','maintenance') DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` varchar(10) NOT NULL,
  `id_studio` varchar(10) DEFAULT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `tarif_per_jam` decimal(10,2) DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('available','maintenance','unavailable') DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `id_studio`, `nama_ruangan`, `kapasitas`, `tarif_per_jam`, `fasilitas`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
('R001', 'S001', 'Recording Studio A', 5, '150000.00', 'Mixer 16 Channel, Microphone, Monitor Speaker, Headphone, AC', 'Studio rekaman profesional dengan peralatan lengkap', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R002', 'S001', 'Practice Room B', 8, '100000.00', 'Guitar Amplifier, Bass Amplifier, Drum Set, Keyboard, AC', 'Ruang latihan untuk band dengan peralatan lengkap', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R003', 'S001', 'Vocal Booth C', 3, '80000.00', 'Microphone Condenser, Headphone, Monitor, AC', 'Booth rekaman vokal dengan isolasi suara', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R004', 'S002', 'Recording Studio Premium', 6, '200000.00', 'Mixer 24 Channel, Professional Microphone, Studio Monitor, AC', 'Studio premium dengan peralatan profesional', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R005', 'S002', 'Practice Room Standard', 6, '120000.00', 'Guitar Amp, Bass Amp, Drum Set, AC', 'Ruang latihan standar untuk band', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R006', 'S003', 'Recording Studio Elite', 8, '250000.00', 'Digital Mixer, Professional Equipment, Soundproof, AC', 'Studio elite dengan fasilitas terbaik', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51'),
('R007', 'S003', 'Practice Room Mini', 4, '75000.00', 'Mini Amplifier, Electric Drum, Keyboard, AC', 'Ruang latihan mini untuk grup kecil', 'available', '2026-01-06 08:40:51', '2026-01-06 08:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `studio`
--

CREATE TABLE `studio` (
  `id_studio` varchar(10) NOT NULL,
  `nama_studio` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studio`
--

INSERT INTO `studio` (`id_studio`, `nama_studio`, `alamat`, `no_telp`, `email`, `jam_buka`, `jam_tutup`, `created_at`, `updated_at`) VALUES
('S001', 'STUDIO SOUNDWAVE', 'Jl. Aji Stone 45', '+62 831-8258-6472', 'info@studiomusik.com', '08:00:00', '22:00:00', '2026-01-06 08:40:51', '2026-01-08 13:57:00'),
('S002', 'STUDIO HARMONI', 'Jl. Aji Stone 45', '+62 812-3456-7890', 'info@studiomusik.com', '09:00:00', '21:00:00', '2026-01-06 08:40:51', '2026-01-08 13:58:47'),
('S003', 'STUDIO MELODI', 'Jl. Aji Stone 45', '+62 813-4567-8901', 'info@studiomusik.com', '08:00:00', '23:00:00', '2026-01-06 08:40:51', '2026-01-08 13:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_studio` varchar(10) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_user`, `id_studio`, `rating`) VALUES
(3, 3, 'S001', 5),
(3, 3, 'S001', 5),
(3, 3, 'S001', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `no_hp`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin jjenaissante', NULL, 'admin@gmail.com', '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC', 'admin', '2026-01-06 12:33:09', '2026-01-08 13:49:11'),
(2, 'Admin Jena', NULL, 'admin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-06 08:58:07', '2026-01-08 13:49:31'),
(3, 'Mba jena', NULL, 'user@email.com', '$2y$10$8L/f98TB0SHkrM7dh1vcluNH/08hjUm6jjFuy5xo7DVtCPR70nhpC', 'user', '2026-01-06 08:58:07', '2026-01-08 13:50:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `tanggal_booking` (`tanggal_booking`);

--
-- Indexes for table `detail_booking`
--
ALTER TABLE `detail_booking`
  ADD PRIMARY KEY (`id_booking`);

--
-- Indexes for table `jadwal_ketersediaan`
--
ALTER TABLE `jadwal_ketersediaan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `id_studio` (`id_studio`);

--
-- Indexes for table `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`id_studio`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jadwal_ketersediaan`
--
ALTER TABLE `jadwal_ketersediaan`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
