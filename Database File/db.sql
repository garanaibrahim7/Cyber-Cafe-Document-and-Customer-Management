-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2025 at 01:54 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saher digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contact` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='This Table Contains Data of Admins for Acces the Portal';

-- --------------------------------------------------------

--
-- Table structure for table `customer_records`
--

DROP TABLE IF EXISTS `customer_records`;
CREATE TABLE IF NOT EXISTS `customer_records` (
  `cust_id` int NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(50) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `work` varchar(50) NOT NULL,
  `work_file_name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `complete` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `charge` int NOT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `printed_forms`
--

DROP TABLE IF EXISTS `printed_forms`;
CREATE TABLE IF NOT EXISTS `printed_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(50) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `work` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `charge` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
CREATE TABLE IF NOT EXISTS `works` (
  `work_id` int NOT NULL AUTO_INCREMENT,
  `work_name` varchar(50) NOT NULL,
  `fees` int NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`work_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `works`
--

INSERT INTO `works` (`work_id`, `work_name`, `fees`, `status`) VALUES
(1, 'Pan Card New', 200, 'Active'),
(11, 'E Shram KYC', 100, 'Active'),
(3, 'Voting Card New', 200, 'Active'),
(4, 'Voting Card Update', 200, 'Active'),
(5, 'Kotak Bank Account', 1000, 'Active'),
(6, 'PNB Bank Account', 300, 'Active'),
(8, 'E Shram Card New', 100, 'Active'),
(9, 'PM Vishwakarma', 200, 'No-Active'),
(10, 'Pan Card Update (Without Guarantee)', 200, 'Active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
