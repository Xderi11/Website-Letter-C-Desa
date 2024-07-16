-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letterc_database`
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
(2, 'Yoyok Andrianto', 'Kasi Pemerintahan');

-- --------------------------------------------------------

--
-- Table structure for table `tanah`
--
CREATE TABLE tanah (
    `id_tanah` int(11) NOT NULL,
    `no_persil` varchar(11) NOT NULL,
    `kelas_desa` varchar(100) NOT NULL,
    `luas_milik` varchar(150) NOT NULL,
    `jenis_tanah` varchar(150) NOT NULL,
    `pajak_bumi` varchar(100) NOT NULL,
    `keterangan_tanah` varchar(255) NOT NULL,
    PRIMARY KEY (`id_tanah`),
    UNIQUE KEY `uk_no_persil` (`no_persil`) -- Pastikan ada indeks unik di kolom no_persil
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





-- --------------------------------------------------------


--
-- Table structure for table `kepemilikan_letter_c`
--

CREATE TABLE kepemilikan_letter_c (
    `id_kepemilikan` int(11) NOT NULL,
    `nama_pemilik` varchar(100) NOT NULL,
    `alamat_pemilik` varchar(50) NOT NULL,
    `no_persil` varchar(11) NOT NULL,
    `kelas_desa` varchar(100) NOT NULL,
    `luas_milik` varchar(150) NOT NULL,
    `jenis_tanah` varchar(150) NOT NULL,
    `tanggal` date NOT NULL,
    `pajak_bumi` varchar(100) NOT NULL,
    `keterangan_tanah` varchar(255) NOT NULL,
    PRIMARY KEY (`id_kepemilikan`),
    CONSTRAINT `fk_no_persil_tanah` FOREIGN KEY (`no_persil`) REFERENCES `tanah`(`no_persil`) 
    ON DELETE NO ACTION
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE pemilik (
    `id_pemilik` int(11) NOT NULL,
    `id_kepemilikan` int(11) NOT NULL,
    `nama_pemilik` varchar(100) NOT NULL,
    `alamat_pemilik` varchar(50) NOT NULL,
    `no_persil` varchar(11) NOT NULL,
    `tanggal` date NOT NULL,
    `keterangan_tanah` varchar(255) NOT NULL,
    `tanggal_perubahan` date NOT NULL,
    `sebab_perubahan` varchar(255) NOT NULL,
    `status_kepemilikan` varchar(255) NOT NULL,
    PRIMARY KEY (`id_pemilik`),
    CONSTRAINT `fk_id_kepemilikan` FOREIGN KEY (`id_kepemilikan`) REFERENCES `kepemilikan_letter_c`(`id_kepemilikan`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `perubahan`
--

CREATE TABLE `perubahan` (
  `id_perubahan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kepemilikan` int(11) NOT NULL,
  `no_persil` varchar(11) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `alamat_pemilik` varchar(50) NOT NULL,
  `kelas_desa` varchar(10) NOT NULL,
  `luas_milik` varchar(15) NOT NULL,
  `jenis_tanah` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `pajak_bumi` varchar(100) NOT NULL,
  `sebab_perubahan` varchar(50) NOT NULL,
  `keterangan_tanah` varchar(255) NOT NULL,
  PRIMARY KEY (`id_perubahan`),
  CONSTRAINT `fk_id_kepemilikan_perubahan` FOREIGN KEY (`id_kepemilikan`) REFERENCES `kepemilikan_letter_c`(`id_kepemilikan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




--
-- Table structure for table `riawayat_perubahan`
--

CREATE TABLE `riwayat_perubahan` (
  `id_riwayat` int(11) NOT NULL,
  `id_kepemilikan` int(11) NOT NULL,
  `no_persil` varchar(11) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `alamat_pemilik` varchar(50) NOT NULL,
  `tanggal_perubahan` date NOT NULL,
  `kelas_desa` varchar(10) NOT NULL,
  `luas_milik` varchar(15) NOT NULL,
  `jenis_tanah` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `pajak_bumi` varchar(100) NOT NULL,
  `sebab_perubahan` varchar(50) NOT NULL,
  `keterangan_tanah` varchar(255) NOT NULL,
  PRIMARY KEY (`id_riwayat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





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
-- AUTO_INCREMENT for table `kepemilikan_letter_c`
--
ALTER TABLE `kepemilikan_letter_c`
  MODIFY `id_kepemilikan` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=3,
  ADD INDEX `idx_id_kepemilikan` (`id_kepemilikan`);


ALTER TABLE `pemilik`
  MODIFY `id_pemilik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `tanah`
  MODIFY `id_tanah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



ALTER TABLE `perubahan`
  MODIFY `id_perubahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
  


ALTER TABLE `riwayat_perubahan`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


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
  ADD CONSTRAINT `fk_no_persil_sk` FOREIGN KEY (`no_persil`) REFERENCES `kepemilikan_letter_c` (`no_persil`) ON DELETE NO ACTION ON UPDATE CASCADE;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;