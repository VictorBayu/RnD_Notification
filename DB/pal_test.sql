-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 10:06 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pal_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ID_contact` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Number_tele` varchar(15) NOT NULL,
  `Number_wa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ID_contact`, `Email`, `Number_tele`, `Number_wa`) VALUES
(1, 'victorbayu85@gmail.com', '081230245097', '081230245097'),
(2, 'achmadhandika0@gmail.com', '082132579727', '087760687562'),
(3, 'rifaulhilal06@gmail.com', '089522887007', '089522887007');

-- --------------------------------------------------------

--
-- Table structure for table `personil_project`
--

CREATE TABLE `personil_project` (
  `ID_person_project` int(11) NOT NULL,
  `ID_contact` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID_project` int(11) NOT NULL,
  `Name_project` varchar(256) NOT NULL,
  `Status` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(12) NOT NULL,
  `Image` varchar(256) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_user`, `Name`, `Email`, `Password`, `Image`, `is_active`) VALUES
(1, 'victor', 'victorbayu@gmail.com', '11111111', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID_contact`);

--
-- Indexes for table `personil_project`
--
ALTER TABLE `personil_project`
  ADD PRIMARY KEY (`ID_person_project`),
  ADD KEY `ID_contact` (`ID_contact`),
  ADD KEY `ID_project` (`ID_project`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID_project`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personil_project`
--
ALTER TABLE `personil_project`
  MODIFY `ID_person_project` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ID_project` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `personil_project`
--
ALTER TABLE `personil_project`
  ADD CONSTRAINT `personil_project_ibfk_1` FOREIGN KEY (`ID_contact`) REFERENCES `contact` (`ID_contact`),
  ADD CONSTRAINT `personil_project_ibfk_2` FOREIGN KEY (`ID_project`) REFERENCES `project` (`ID_project`),
  ADD CONSTRAINT `personil_project_ibfk_3` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
