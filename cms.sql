-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 09:06 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `last_login` varchar(50) NOT NULL,
  `active` int(11) NOT NULL,
  `create_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `last_login`, `active`, `create_date`) VALUES
(1, 'admin', 'y2UowLN6P3rfDPBAOHw3E24yeRE9yyQl+I4QHtyTpuVQ6PXyqjGIXBoXez8u5DHbT8W9OT6qZVxzmiZyIMIs4w==', '2022/07/26&10:05:40_PM', 1, '2022/07/22&09:28:42_PM');

-- --------------------------------------------------------

--
-- Table structure for table `backup_table`
--

CREATE TABLE `backup_table` (
  `id` int(11) NOT NULL,
  `table_used` varchar(50) NOT NULL,
  `where_statement` varchar(50) NOT NULL,
  `data` longtext NOT NULL,
  `admin_type` varchar(50) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `operation` varchar(50) NOT NULL,
  `action_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(11) NOT NULL,
  `A_site_title` varchar(500) NOT NULL,
  `site_link` varchar(500) NOT NULL,
  `id_dept` varchar(100) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `active` int(11) NOT NULL COMMENT 'deleted(0)',
  `create_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backup_table`
--
ALTER TABLE `backup_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `backup_table`
--
ALTER TABLE `backup_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
