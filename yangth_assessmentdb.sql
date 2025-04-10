-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 02:16 PM
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
-- Database: `yangth_assessmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `difficulties`
--

CREATE TABLE `difficulties` (
  `DifficultyId` int(11) NOT NULL,
  `Difficulty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `difficulties`
--

INSERT INTO `difficulties` (`DifficultyId`, `Difficulty`) VALUES
(1, 'Easy'),
(2, 'Medium'),
(3, 'Hard');

-- --------------------------------------------------------

--
-- Table structure for table `membertrips`
--

CREATE TABLE `membertrips` (
  `MemberTripId` int(11) NOT NULL,
  `MemberFirstName` varchar(255) NOT NULL,
  `MemberLastName` varchar(255) NOT NULL,
  `MemberEmail` varchar(255) NOT NULL,
  `TripId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membertrips`
--

INSERT INTO `membertrips` (`MemberTripId`, `MemberFirstName`, `MemberLastName`, `MemberEmail`, `TripId`) VALUES
(1, 'Jane', 'Smith', 'jane.smith@example.com', 1),
(2, 'Michael', 'Johnson', 'michael.johnson@example.com', 2),
(3, 'Joe', 'Bloggs', 'admin@example.com', 1),
(4, 'William', 'Doe', 'willy.doe@example.com', 2),
(9, 'Sarah', 'Joe', 's.joe@example.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `PermissionId` int(11) NOT NULL,
  `PermissionType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`PermissionId`, `PermissionType`) VALUES
(1, 'Admin'),
(2, 'Member'),
(3, 'Trip Leader');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `TripId` int(11) NOT NULL,
  `TripTypeId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`TripId`, `TripTypeId`, `UserId`, `Date`) VALUES
(1, 1, 5, '2026-02-15'),
(2, 2, 4, '2025-07-21'),
(3, 5, 1, '2026-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `triptypes`
--

CREATE TABLE `triptypes` (
  `TripTypeId` int(11) NOT NULL,
  `TripName` varchar(255) NOT NULL,
  `Days` int(11) NOT NULL,
  `MaxPeople` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `DifficultyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `triptypes`
--

INSERT INTO `triptypes` (`TripTypeId`, `TripName`, `Days`, `MaxPeople`, `Price`, `DifficultyId`) VALUES
(1, 'Adventure Tour', 5, 20, 250.00, 2),
(2, 'Mountain Hike', 7, 15, 400.00, 3),
(3, 'Raging Rapids', 4, 6, 450.00, 3),
(4, 'Ninja Night Camp', 7, 30, 75.00, 1),
(5, 'Fly Fishing Friends', 3, 5, 250.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `UserFirstName` varchar(255) NOT NULL,
  `UserLastName` varchar(255) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `PermissionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `PasswordHash`, `UserFirstName`, `UserLastName`, `UserEmail`, `PermissionId`) VALUES
(1, 'admin', '$2y$10$LLU2/RrG/iDa5Fg/W5Tqx.1A4bXpNGpZmJmrdKggV92xDXhxnmLby', 'Joe', 'Bloggs', 'admin@example.com', 1),
(2, 'member_1', '$2y$10$BsB.QgQ5f.TtzGC8ObWuGOna/8CWFB/IpvCP.bG2XqFLKxK5bBmvq', 'William', 'Doe', 'willy.doe@example.com', 2),
(3, 'member_2', '$2y$10$3to5RpMAsSnK9PLkLaUatOGnQKafxBf4eUGnoZggMP5ffpuiTNBbm', 'Sarah', 'Joe', 's.joe@example.com', 2),
(4, 'trip_leader_1', '$2y$10$COFcgzg9pimp3GrhfcDkou3/Is9ym.nniSUQknMDu0GXkfqzHf24q', 'Luke', 'Walker-Sky', 'forcebwithyou@example.com', 3),
(5, 'trip_leader_2', '$2y$10$quZk48UOeCu5H.zsvxaXaeOBbFzmD38nMvOu7g/jw4xxvr/iKL1RG', 'Timmy', 'John', 'timmy.w.j@example.com', 3),
(6, 'trip_leader_3', '$2y$10$UteN2NsT3JhX2IGW/UpTCO7lrv.cq1mM2qBMKToFBsjamO2Hsr2Q2', 'Alexander', 'Williams', 'atothex@example.com', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `difficulties`
--
ALTER TABLE `difficulties`
  ADD PRIMARY KEY (`DifficultyId`);

--
-- Indexes for table `membertrips`
--
ALTER TABLE `membertrips`
  ADD PRIMARY KEY (`MemberTripId`),
  ADD KEY `TripId` (`TripId`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`PermissionId`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`TripId`),
  ADD KEY `TripTypeId` (`TripTypeId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `triptypes`
--
ALTER TABLE `triptypes`
  ADD PRIMARY KEY (`TripTypeId`),
  ADD KEY `DifficultyId` (`DifficultyId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD KEY `PermissionId` (`PermissionId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `difficulties`
--
ALTER TABLE `difficulties`
  MODIFY `DifficultyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `membertrips`
--
ALTER TABLE `membertrips`
  MODIFY `MemberTripId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `PermissionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `TripId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `triptypes`
--
ALTER TABLE `triptypes`
  MODIFY `TripTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membertrips`
--
ALTER TABLE `membertrips`
  ADD CONSTRAINT `membertrips_ibfk_1` FOREIGN KEY (`TripId`) REFERENCES `trips` (`TripId`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`TripTypeId`) REFERENCES `triptypes` (`TripTypeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `triptypes`
--
ALTER TABLE `triptypes`
  ADD CONSTRAINT `triptypes_ibfk_1` FOREIGN KEY (`DifficultyId`) REFERENCES `difficulties` (`DifficultyId`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`PermissionId`) REFERENCES `permissions` (`PermissionId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
