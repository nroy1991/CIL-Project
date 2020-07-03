-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2019 at 04:28 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cil`
--

-- --------------------------------------------------------

--
-- Table structure for table `cadre`
--

CREATE TABLE `cadre` (
  `sno` int(11) NOT NULL,
  `cil_cadre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `sno` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `sno` int(11) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `design` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `discipline` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `minesubtype`
--

CREATE TABLE `minesubtype` (
  `sno` int(11) NOT NULL,
  `minecategory` varchar(255) NOT NULL,
  `plower_lim` double NOT NULL,
  `pupper_lim` double NOT NULL,
  `mcode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `minetype`
--

CREATE TABLE `minetype` (
  `sno` int(11) NOT NULL,
  `minecategory` varchar(255) NOT NULL,
  `munit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `std_mine_data`
--

CREATE TABLE `std_mine_data` (
  `sno` int(11) NOT NULL,
  `mcode` varchar(20) NOT NULL,
  `department` varchar(255) NOT NULL,
  `scopeofwork` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `cadre` varchar(255) NOT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `no_of_emp` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `norm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cadre`
--
ALTER TABLE `cadre`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `minesubtype`
--
ALTER TABLE `minesubtype`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `minetype`
--
ALTER TABLE `minetype`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `std_mine_data`
--
ALTER TABLE `std_mine_data`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cadre`
--
ALTER TABLE `cadre`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `minesubtype`
--
ALTER TABLE `minesubtype`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `minetype`
--
ALTER TABLE `minetype`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `std_mine_data`
--
ALTER TABLE `std_mine_data`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
