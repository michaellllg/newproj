-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 09:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cjcrsg`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountinfo`
--

CREATE TABLE `accountinfo` (
  `accountID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` int(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp(),
  `life_stage` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountinfo`
--

INSERT INTO `accountinfo` (`accountID`, `memberID`, `email`, `password`, `phone`, `address`, `dateCreated`, `lastUpdated`, `life_stage`, `image`) VALUES
(1, 1, 'hazel@gmail.com', '12345', 214712, 'San Basdgsdgrtolome', '2024-11-30 08:13:05', '2024-11-22 12:30:51', 'College Student', 'img4.jpg'),
(2, 2, 'diana@gmail.com', '12345', 2147483647, 'San Roquess', '2024-11-28 10:58:04', '2024-11-22 13:51:58', 'Professional', 'img2.jpg'),
(3, 3, 'ashley@gmail.com', '12345', 2147483647, 'Alaminos', '2024-11-28 09:54:28', '2024-11-22 13:59:39', 'College Student', 'img14.jpg'),
(4, 4, 'mnm@gmail.com', '12345', 2147483647, 'San Roque', '2024-11-28 09:53:09', '2024-11-23 08:29:34', 'College Student', 'logo.png'),
(5, 5, 'onini@gmail.com', '12345', 2147483647, 'santiago', '2024-11-28 10:03:45', '2024-11-28 08:09:25', 'College Student', 'img6.jpg'),
(6, 6, 'kb@gmail.com', '12345', 2147483647, 'Lipa', '2024-11-30 02:38:29', '2024-11-28 10:00:36', 'Professional', 'img8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `accountrole`
--

CREATE TABLE `accountrole` (
  `accRoleID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountrole`
--

INSERT INTO `accountrole` (`accRoleID`, `memberID`, `roleID`, `dateCreated`) VALUES
(1, 1, 1, '2024-11-22 12:30:51'),
(2, 2, 1, '2024-11-22 13:51:58'),
(3, 3, 1, '2024-11-22 13:59:39'),
(4, 4, 1, '2024-11-23 08:29:34'),
(5, 5, 3, '2024-11-28 08:09:25'),
(6, 6, 1, '2024-11-28 10:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `atten_id` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`atten_id`, `memberID`, `date`) VALUES
(24, 1, '2024-11-17 05:49:17'),
(25, 2, '2024-11-02 05:49:28'),
(26, 3, '2024-11-17 05:49:39'),
(28, 6, '2024-11-02 06:08:01'),
(29, 5, '2024-12-01 06:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberID`, `name`, `status`, `dateCreated`, `lastUpdated`) VALUES
(1, 'Hazel Anne Malitig', 'Active', '2024-11-22 12:30:51', '2024-11-30 02:57:12'),
(2, 'Diana Hernandez', 'Inactive', '2024-11-22 13:51:58', '2024-11-30 02:52:19'),
(3, 'Ashley Garcia', 'Inactive', '2024-11-22 13:59:39', '2024-11-30 02:25:32'),
(4, 'Michael Nacions', 'Inactive', '2024-11-23 08:29:34', '2024-11-30 02:51:52'),
(5, 'Kenneth Onan', 'Active', '2024-11-28 08:09:25', '2024-11-28 12:05:43'),
(6, 'Kb Ventolina', 'Inactive', '2024-11-28 10:00:36', '2024-11-28 10:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleID` int(11) NOT NULL,
  `roletype` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `roletype`) VALUES
(1, 'Admin'),
(2, 'Member'),
(3, 'Visitor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountinfo`
--
ALTER TABLE `accountinfo`
  ADD PRIMARY KEY (`accountID`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `accountrole`
--
ALTER TABLE `accountrole`
  ADD PRIMARY KEY (`accRoleID`),
  ADD KEY `roleID` (`roleID`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`atten_id`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountinfo`
--
ALTER TABLE `accountinfo`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `accountrole`
--
ALTER TABLE `accountrole`
  MODIFY `accRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `atten_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accountinfo`
--
ALTER TABLE `accountinfo`
  ADD CONSTRAINT `accountinfo_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`);

--
-- Constraints for table `accountrole`
--
ALTER TABLE `accountrole`
  ADD CONSTRAINT `accountrole_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`),
  ADD CONSTRAINT `accountrole_ibfk_2` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
