-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2022 at 09:26 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfor_covid`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_covid`
--

CREATE TABLE `data_covid` (
  `id_data_covid` int(9) NOT NULL,
  `id_periode` int(9) NOT NULL,
  `id_kelurahan` int(10) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `jumlah_pasien_covid` int(11) NOT NULL,
  `jumlah_rumah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_covid`
--

INSERT INTO `data_covid` (`id_data_covid`, `id_periode`, `id_kelurahan`, `rw`, `jumlah_pasien_covid`, `jumlah_rumah`) VALUES
(1, 1, 1, '005', 6, 1),
(2, 2, 1, '004', 5, 4),
(3, 2, 1, '003', 4, 2),
(4, 2, 1, '002', 3, 1),
(5, 2, 1, '001', 1, 1),
(6, 2, 1, '008', 2, 1),
(7, 2, 1, '010', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id_kelurahan` int(11) NOT NULL,
  `kelurahan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id_kelurahan`, `kelurahan`) VALUES
(1, 'Air Dingin'),
(2, 'Simpang Tiga'),
(3, 'Labuai'),
(4, 'Utara'),
(5, 'Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(9) NOT NULL,
  `dari_tgl` date NOT NULL,
  `sampai_tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id_periode`, `dari_tgl`, `sampai_tgl`) VALUES
(1, '2022-06-19', '2022-06-25'),
(2, '2022-06-26', '2022-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(9) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `pasword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `user_name`, `pasword`) VALUES
(1, 'Admin', 'admin', '$2a$12$VgyWPrcQKZ9UxoMkAASVgu0wNye3andtoIBNGu/3A2I6jGH1UC3n2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_covid`
--
ALTER TABLE `data_covid`
  ADD PRIMARY KEY (`id_data_covid`),
  ADD KEY `data_covid_ibfk_2` (`id_kelurahan`),
  ADD KEY `id_periode` (`id_periode`) USING BTREE;

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id_kelurahan`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_covid`
--
ALTER TABLE `data_covid`
  MODIFY `id_data_covid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id_kelurahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_covid`
--
ALTER TABLE `data_covid`
  ADD CONSTRAINT `data_covid_ibfk_1` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`),
  ADD CONSTRAINT `data_covid_ibfk_2` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
