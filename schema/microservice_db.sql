-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2022 at 01:02 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microservice_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `id` mediumint(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`id`, `name`, `status`) VALUES
(1, 'Company 1', 1),
(2, 'Company 2', 1),
(3, 'Company 3', 1),
(4, 'Company 4', 1),
(5, 'Company 5', 1),
(6, 'Company 6', 1),
(7, 'Company 7', 1),
(8, 'Company 8', 1),
(9, 'Company 9', 1),
(10, 'Company 10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_frequencies`
--

CREATE TABLE `tbl_frequencies` (
  `id` int(10) NOT NULL,
  `value` tinyint(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_frequencies`
--

INSERT INTO `tbl_frequencies` (`id`, `value`, `status`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1),
(42, 42, 1),
(43, 43, 1),
(44, 44, 1),
(45, 45, 1),
(46, 46, 1),
(47, 47, 1),
(48, 48, 1),
(49, 49, 1),
(50, 50, 1),
(51, 51, 1),
(52, 52, 1),
(53, 53, 1),
(54, 54, 1),
(55, 55, 1),
(56, 56, 1),
(57, 57, 1),
(58, 58, 1),
(59, 59, 1),
(60, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` int(11) NOT NULL,
  `log` varchar(200) NOT NULL,
  `logged_date` datetime NOT NULL DEFAULT current_timestamp(),
  `service_id` int(10) NOT NULL COMMENT 'Referencing table tbl_services column id',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`id`, `log`, `logged_date`, `service_id`, `status`) VALUES
(1, 'Success', '2022-03-17 10:56:01', 4, 1),
(2, 'Success', '2022-03-17 10:57:03', 4, 1),
(3, 'Success', '2022-03-17 10:58:04', 4, 1),
(4, 'Failed with code 0', '2022-03-17 11:01:10', 4, 1),
(5, 'Success', '2022-03-17 11:03:02', 4, 1),
(6, 'Failed with code 0', '2022-03-17 11:04:13', 4, 1),
(7, 'Success', '2022-03-17 11:07:01', 3, 1),
(8, 'Success', '2022-03-17 11:09:03', 3, 1),
(9, 'Success', '2022-03-17 11:25:35', 2, 1),
(10, 'Success', '2022-03-17 11:30:23', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` int(10) NOT NULL,
  `company_name` mediumint(10) NOT NULL COMMENT 'from tbl_companies table',
  `service_title` varchar(100) NOT NULL,
  `service_address` varchar(250) NOT NULL,
  `last_run_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `next_run_datetime` datetime NOT NULL,
  `unit` tinyint(2) NOT NULL,
  `frequency` tinyint(2) NOT NULL,
  `is_executed` char(3) NOT NULL DEFAULT 'No',
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `company_name`, `service_title`, `service_address`, `last_run_datetime`, `next_run_datetime`, `unit`, `frequency`, `is_executed`, `added_at`, `updated_at`, `status`) VALUES
(1, 3, 'Everyday 6 Am Run', 'https://www.google.com', '0000-00-00 00:00:00', '2022-03-18 06:00:00', 3, 1, 'No', '2022-03-13 14:28:00', '2022-03-17 11:35:03', 1),
(2, 1, 'Every Minute Run', 'https://www.google.com', '2022-03-17 11:25:00', '2022-03-17 14:55:00', 1, 1, 'No', '2022-03-14 15:25:46', '2022-03-17 14:52:28', 1),
(3, 2, 'Every Two Hours Run', 'https://www.google.com', '2022-03-17 11:30:00', '2022-03-17 14:30:00', 2, 2, 'No', '2022-03-15 08:53:50', '2022-03-17 14:08:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

CREATE TABLE `tbl_units` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_units`
--

INSERT INTO `tbl_units` (`id`, `name`, `status`) VALUES
(1, 'Minutes', 1),
(2, 'Hours', 1),
(3, 'Days', 1),
(4, 'Weeks', 1),
(5, 'Months', 1),
(6, 'Years', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_frequencies`
--
ALTER TABLE `tbl_frequencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_units`
--
ALTER TABLE `tbl_units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `id` mediumint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_frequencies`
--
ALTER TABLE `tbl_frequencies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_units`
--
ALTER TABLE `tbl_units`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
