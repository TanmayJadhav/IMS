-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2021 at 08:13 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `client_id` int(100) NOT NULL,
  `gst` int(11) NOT NULL,
  `labour_charge` mediumint(9) NOT NULL DEFAULT 0,
  `transportation_charge` mediumint(9) NOT NULL DEFAULT 0,
  `total_price` bigint(20) NOT NULL,
  `remaining_amount` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `client_id`, `gst`, `labour_charge`, `transportation_charge`, `total_price`, `remaining_amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 3, 0, 0, 0, 10, 5, '2021-07-09 08:55:51', '2021-08-09 09:48:18', NULL),
(3, 2, 1, 0, 0, 17000, 7000, '2021-08-10 00:06:48', '2021-08-10 01:30:28', NULL),
(4, 2, 1, 0, 0, 22000, 2000, '2021-08-10 01:16:02', '2021-08-10 01:16:02', NULL),
(5, 1, 1, 0, 0, 1224, 24, '2021-08-10 01:51:43', '2021-08-10 01:51:43', NULL),
(6, 1, 1, 0, 0, 1575, 75, '2021-08-10 01:59:06', '2021-08-10 01:59:06', NULL),
(7, 3, 1, 0, 0, 1224, 0, '2021-08-11 01:46:18', '2021-08-11 01:46:18', NULL),
(8, 1, 1, 0, 0, 1785, 85, '2021-08-11 03:52:25', '2021-08-11 03:52:25', NULL),
(9, 1, 1, 0, 0, 1224, 0, '2021-08-13 06:51:39', '2021-08-13 06:51:39', NULL),
(10, 1, 1, 0, 0, 61724, 1724, '2021-08-13 17:49:14', '2021-08-13 17:49:14', NULL),
(11, 1, 1, 0, 0, 10500, 500, '2021-08-13 18:36:14', '2021-08-13 18:36:14', NULL),
(12, 4, 1, 0, 0, 66000, 6000, '2021-08-22 05:32:39', '2021-08-22 05:32:39', NULL),
(13, 4, 1, 0, 0, 66000, 6000, '2021-08-22 05:36:19', '2021-08-22 05:36:19', NULL),
(16, 3, 1, 0, 0, 1575, 0, '2021-08-22 05:40:23', '2021-08-22 05:40:23', NULL),
(17, 1, 0, 10, 10, 1020, 20, '2021-08-24 14:34:09', '2021-08-24 14:34:09', NULL),
(18, 1, 1, 10, 10, 1700, 0, '2021-08-24 15:06:08', '2021-08-24 15:06:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
