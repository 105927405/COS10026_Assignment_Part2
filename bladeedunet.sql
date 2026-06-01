-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 12:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bladeedunet`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `Name` text NOT NULL,
  `Contributions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOI_ID` int(11) NOT NULL,
  `F_Name` varchar(40) NOT NULL,
  `L_Name` varchar(40) NOT NULL,
  `DOB` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone_NUM` varchar(10) NOT NULL,
  `Gender` enum('Male','Female','Non-Binary','Other','Prefer Not to Say') NOT NULL,
  `Job` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `monday` int(11) DEFAULT NULL,
  `montimein` time DEFAULT NULL,
  `montimeout` time DEFAULT NULL,
  `tuesday` int(11) DEFAULT NULL,
  `tuetimein` time DEFAULT NULL,
  `tuetimeout` time DEFAULT NULL,
  `wednessday` int(11) DEFAULT NULL,
  `wedtimein` time DEFAULT NULL,
  `wedtimeout` time DEFAULT NULL,
  `thursday` int(11) DEFAULT NULL,
  `thurtimein` time DEFAULT NULL,
  `thurtimeout` time DEFAULT NULL,
  `friday` int(11) DEFAULT NULL,
  `fritimein` time DEFAULT NULL,
  `fritimeout` time DEFAULT NULL,
  `saturday` int(11) DEFAULT NULL,
  `sattimein` time DEFAULT NULL,
  `sattimeout` time DEFAULT NULL,
  `sunday` int(11) DEFAULT NULL,
  `suntimein` time DEFAULT NULL,
  `suntimeout` time DEFAULT NULL,
  `Address` varchar(40) NOT NULL,
  `Suburb` varchar(40) NOT NULL,
  `State` enum('VIC','NSW','WA','SA','TAS','QLD') NOT NULL,
  `Post_Code` int(4) NOT NULL,
  `communication` int(11) DEFAULT NULL,
  `teamwork` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `BPS` int(11) DEFAULT NULL,
  `APS` int(11) DEFAULT NULL,
  `BDS` int(11) DEFAULT NULL,
  `ADS` int(11) DEFAULT NULL,
  `BTS` int(11) DEFAULT NULL,
  `ATS` int(11) DEFAULT NULL,
  `JS` int(11) DEFAULT NULL,
  `Extra_Skills` text NOT NULL,
  `Cover_Letter` longblob DEFAULT NULL,
  `Write_Letter` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Resume` longblob NOT NULL,
  `Status` enum('Viewed','Rejected','Accepted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `REF_NUM` int(11) NOT NULL COMMENT 'Job Ref Number',
  `Job_Name` varchar(40) NOT NULL,
  `Pay` int(11) NOT NULL COMMENT 'Example Salary',
  `Hours` varchar(40) NOT NULL COMMENT 'Expected work hours',
  `E_Skills` text NOT NULL COMMENT 'Essential Skills',
  `P_Skills` text NOT NULL COMMENT 'Preferable Skills',
  `Description` text NOT NULL COMMENT 'Description of job',
  `Manager` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(100) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL COMMENT 'Encrypted by PHP',
  `F_Name` varchar(15) NOT NULL,
  `L_Name` varchar(15) NOT NULL,
  `Role` enum('IT','HR','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOI_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`REF_NUM`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOI_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `REF_NUM` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Job Ref Number';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
