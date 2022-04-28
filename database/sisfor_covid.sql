-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 30, 2021 at 04:52 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

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
  `id_priode` int(9) NOT NULL,
  `kelurahan` varchar(30) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `jumlah_pasien_covid` int(11) NOT NULL,
  `jumlah_rumah` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_covid`
--

INSERT INTO `data_covid` (`id_data_covid`, `id_priode`, `kelurahan`, `rw`, `jumlah_pasien_covid`, `jumlah_rumah`, `status`) VALUES
(4, 3, 'Air Dingin', '004', 4, 2, 'Kuning'),
(5, 3, 'Pahlawan K', '123', 10, 5, 'Merah'),
(6, 3, 'Air Dingin', '005', 20, 10, 'Merah'),
(7, 4, 'Suka Nongkrong', '010', 40, 30, 'Merah');

-- --------------------------------------------------------

--
-- Table structure for table `priode`
--

CREATE TABLE `priode` (
  `id_priode` int(9) NOT NULL,
  `dari_tgl` date NOT NULL,
  `sampai_tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `priode`
--

INSERT INTO `priode` (`id_priode`, `dari_tgl`, `sampai_tgl`) VALUES
(3, '2021-12-01', '2021-12-30'),
(4, '2022-01-01', '2022-01-31');

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
  ADD KEY `id_priode` (`id_priode`);

--
-- Indexes for table `priode`
--
ALTER TABLE `priode`
  ADD PRIMARY KEY (`id_priode`);

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
-- AUTO_INCREMENT for table `priode`
--
ALTER TABLE `priode`
  MODIFY `id_priode` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `data_covid_ibfk_1` FOREIGN KEY (`id_priode`) REFERENCES `priode` (`id_priode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
