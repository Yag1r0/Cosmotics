-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 12:59 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cosmotics`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'Kush Mascara', 'Lashes shine', 'img/products/mascara/mas1.png', 1500.00),
(2, 'Maybeline Mascara', 'Lashes Power', 'img/products/mascara/mas2.png', 800.00),
(3, 'Luxury Mascara', 'Ultra Lashes', 'img/products/mascara/mas3.png', 300.00),
(14, 'Mars Lipstick', 'mars123', 'img/products/mascara/1592789859_lipstik.jpg', 678.00),
(15, 'Cosmic Shadow', 'coshad123', 'img/products/mascara/1592789945_shadowwww.jpg', 834.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `password`) VALUES
(1, 'hgj', 'user', '7815696ecbf1c96e6894b779456d330e'),
(3, 'asd', 'user', '7815696ecbf1c96e6894b779456d330e'),
(10, 'pendragon', 'user', '$2y$10$4zMrnhXZI9eF1xbo9d8V/elSGk55a8KS0v4jz3tHof8uUzTbLADu.'),
(11, 'Aleksa', 'user', '$2y$10$0byYbLsUTzdlG126OmYiqeyRpkppuzin4LbUGU2S35oFyJNMaq7uO'),
(12, 'svinja123', 'user', '$2y$10$RseMbgRMUm3YgRl0O0ROBuV3eu3GzTghrzN.ULI0xgjjtiG19hHd.'),
(15, 'YagiroMight', 'user', '$2y$10$cWtpexYEkg8dAlySpYtNzOUAfXD0wF11AwwtGnmJo.2Njhp/.g3Hi'),
(16, 'btest1', 'user', '$2y$10$ANa91dGn0PQNBXod0yZCku/1.EUA8Ck5sG11U2VjL9FDwFKjWX/Uy'),
(17, 'btest2', 'admin', '$2y$10$D8/DVtA5Ovg.x89uSr6fy..sIHV/WFZULJ5.4sgRa2SMpfLnRDZG2'),
(18, 'Unauna', 'user', '$2y$10$..pOgXwuZ5KJkAYKEpu8J.XHaJfKqhvXdHS7dCOJ14momZqZ0ap3i'),
(19, 'unapet', 'user', '$2y$10$cB2KoXmysoUv/FibzwsKPegH3erbFKU5f4aU6A0BV/NJT9RSYVq3y'),
(20, 'ljubicica', 'admin', '$2y$10$m5/wrjr7qn0Noors5NN8OuiK7RWo7iar0ZZBmlOmJNyb3bqg4xRzG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
