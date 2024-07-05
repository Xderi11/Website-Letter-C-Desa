-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2019 at 10:09 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_e-suratdesa`
--

-- --------------------------------------------------------

--
-- Table structure for table `dusun`
--

CREATE TABLE `dusun` (
  `id_dusun` int(11) NOT NULL,
  `nama_dusun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dusun`
--

INSERT INTO `dusun` (`id_dusun`, `nama_dusun`) VALUES
(1, 'Dusun_1'),
(2, 'Dusun_2'),
(3, 'Dusun_3'),
(4, 'Dusun_4'),
(5, 'Dusun_5');
-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `nama`, `username`, `email`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', 'admin@e-suratdesa.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'Kepala Desa', 'kades', 'kepaladesa@desa.id', '0cfa66469d25bd0d9e55d7ba583f9f2f', 'kades');

-- --------------------------------------------------------

--
-- Table structure for table `pejabat_desa`
--

CREATE TABLE `pejabat_desa` (
  `id_pejabat_desa` int(11) NOT NULL,
  `nama_pejabat_desa` varchar(50) NOT NULL,
  `jabatan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pejabat_desa`
--

INSERT INTO `pejabat_desa` (`id_pejabat_desa`, `nama_pejabat_desa`, `jabatan`) VALUES
(1, 'Tribowo', 'Kepala Desa'),
(2, 'Yoyok Andrianto', 'Kepala Seksi Pemerintahan');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id_penduduk` int(11) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `alamat_pemilik` varchar(50) NOT NULL,
  `no_persil` varchar(50) NOT NULL,
  `kelas_desa` varchar(10) NOT NULL,
  `luas_milik` varchar(15) NOT NULL,
  `jenis_tanah` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `sebab_perubahan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` (`id_penduduk`, `nama_pemilik`, `alamat_pemilik`, `no_persil`, `kelas_desa`, `luas_milik`, `jenis_tanah`, `tanggal`, `sebab_perubahan`) VALUES
(1, 'deri', 'Kundur Utara', '123', 'D-1', '10 HA', 'Gambut', '2024-11-12', '-');

-- --------------------------------------------------------

--
-- Table structure for table `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id_profil_desa` int(11) NOT NULL,
  `nama_desa` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `provinsi` varchar(20) NOT NULL,
  `kode_pos` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil_desa`
--

INSERT INTO `profil_desa` (`id_profil_desa`, `nama_desa`, `alamat`, `no_telpon`, `kecamatan`, `kabupaten`, `provinsi`, `kode_pos`) VALUES
(1, 'Tanjung Berlian Barat', 'jl. Hangtuah', '-', 'Kundur Utara', 'kabupaten Karimun', 'Kepulauan Riau', '29662');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan`
--

CREATE TABLE `surat_keterangan` (
  `id_sk` int(11) NOT NULL,
  `jenis_surat` varchar(50) NOT NULL,
  `no_surat` varchar(20) DEFAULT NULL,
  `no_persil` varchar(20) DEFAULT NULL,
  `keperluan` varchar(50) NOT NULL,
  `tanggal_surat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pejabat_desa` int(11) DEFAULT NULL,
  `status_surat` varchar(15) NOT NULL,
  `id_profil_desa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_keterangan`
--

INSERT INTO `surat_keterangan` (`id_sk`, `jenis_surat`, `no_surat`, `no_persil`, `keperluan`, `tanggal_surat`, `id_pejabat_desa`, `status_surat`, `id_profil_desa`) VALUES
(1, 'Surat Keterangan', '1', '123', 'surat keterangan', '2024-06-07 04:00:59', 1, 'SELESAI', 1),
(2, 'Surat Keterangan', NULL, NULL, 'surat keterangan', '2024-07-06 04:01:06', NULL, 'PENDING', 1);


-- --------------------------------------------------------


--
-- Indexes for dumped tables
--

--
-- Indexes for table `dusun`
--
ALTER TABLE `dusun`
  ADD PRIMARY KEY (`id_dusun`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pejabat_desa`
--
ALTER TABLE `pejabat_desa`
  ADD PRIMARY KEY (`id_pejabat_desa`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`no_persil`),
  ADD KEY `idx_id_penduduk` (`id_penduduk`);

--
-- Indexes for table `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id_profil_desa`);

--
-- Indexes for table `surat_keterangan`
--
ALTER TABLE `surat_keterangan`
  ADD PRIMARY KEY (`id_sk`),
  ADD KEY `idx_no_persil` (`no_persil`),
  ADD KEY `idx_id_pejabat_desa` (`id_pejabat_desa`),
  ADD KEY `idx_id_profil_desa` (`id_profil_desa`);



--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dusun`
--
ALTER TABLE `dusun`
  MODIFY `id_dusun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pejabat_desa`
--
ALTER TABLE `pejabat_desa`
  MODIFY `id_pejabat_desa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id_penduduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `profil_desa`
--
ALTER TABLE `profil_desa`
  MODIFY `id_profil_desa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `surat_keterangan`
--
ALTER TABLE `surat_keterangan`
  MODIFY `id_sk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat_keterangan`
--
ALTER TABLE `surat_keterangan`
  ADD CONSTRAINT `fk_id_pejabat_desa_sk` FOREIGN KEY (`id_pejabat_desa`) REFERENCES `pejabat_desa` (`id_pejabat_desa`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_profil_desa_sk` FOREIGN KEY (`id_profil_desa`) REFERENCES `profil_desa` (`id_profil_desa`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_persil_sk` FOREIGN KEY (`no_persil`) REFERENCES `penduduk` (`no_persil`) ON DELETE NO ACTION ON UPDATE CASCADE;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
