-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 02, 2026 at 04:25 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u321173822_pasabuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuditLogs`
--

CREATE TABLE IF NOT EXISTS `AuditLogs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AdminId` int(11) NOT NULL,
  `Action` varchar(100) NOT NULL,
  `TargetType` varchar(100) NOT NULL,
  `TargetId` varchar(100) NOT NULL,
  `Details` text DEFAULT NULL,
  `Timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `IpAddress` varchar(50) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `IconClass` varchar(100) NOT NULL DEFAULT 'tag',
  `SortOrder` int(11) NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`Id`, `Name`, `Description`, `IconClass`, `SortOrder`, `IsActive`, `CreatedAt`) VALUES
(1, 'School Supplies', 'Calculators, Pens, Notebooks, Drafting Tools', 'pen-ruler', 1, 1, '2026-09-01 12:39:33'),
(2, 'Electronics', 'Mice, Keyboards, Powerbanks, Cables', 'laptop', 2, 1, '2026-09-01 12:39:33'),
(3, 'Books', 'Textbooks, Reviewers, Lab Manuals', 'book', 3, 1, '2026-09-01 12:39:33'),
(4, 'Gadgets', 'Tablets, Headphones, Smartwatches', 'mobile-screen-button', 4, 1, '2026-09-01 12:39:33'),
(5, 'Food / Pasabuy', 'Campus Snack Delivery & Meal Pasabuy', 'utensils', 5, 1, '2026-09-01 12:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `ChatMessages`
--

CREATE TABLE IF NOT EXISTS `ChatMessages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `SenderName` varchar(255) NOT NULL,
  `MessageText` text NOT NULL,
  `ItemTitle` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ListingImages`
--

CREATE TABLE IF NOT EXISTS `ListingImages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ListingId` int(11) NOT NULL,
  `ImageUrl` longtext NOT NULL,
  `SortOrder` int(11) NOT NULL DEFAULT 0,
  `IsPrimary` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `FK_ListingImages_Listings` (`ListingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Listings`
--

CREATE TABLE IF NOT EXISTS `Listings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SellerId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(18,2) NOT NULL,
  `Condition` varchar(50) NOT NULL DEFAULT 'Good',
  `Status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  `MeetupLocationId` int(11) NOT NULL,
  `Views` int(11) NOT NULL DEFAULT 0,
  `FavoritesCount` int(11) NOT NULL DEFAULT 0,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ExpiresAt` datetime DEFAULT NULL,
  `ReservedAt` datetime DEFAULT NULL,
  `SoldAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Listings_Users` (`SellerId`),
  KEY `FK_Listings_Categories` (`CategoryId`),
  KEY `FK_Listings_MeetupLocations` (`MeetupLocationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MeetupLocations`
--

CREATE TABLE IF NOT EXISTS `MeetupLocations` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `LocationDetails` text DEFAULT NULL,
  `Latitude` double NOT NULL DEFAULT 0,
  `Longitude` double NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `MeetupLocations`
--

INSERT INTO `MeetupLocations` (`Id`, `Name`, `Description`, `LocationDetails`, `Latitude`, `Longitude`, `IsActive`, `CreatedAt`) VALUES
(1, 'Library Lobby', 'Main Campus University Library Ground Floor', 'Near Security Checkpoint', 0, 0, 1, '2026-09-01 12:39:33'),
(2, 'Student Cafeteria', 'Central Food Court & Dining Area', 'Center Tables', 0, 0, 1, '2026-09-01 12:39:33'),
(3, 'School Gate Main Entrance', 'Main Campus Pedestrian Gate', 'Guard Post Area', 0, 0, 1, '2026-09-01 12:39:33'),
(4, 'Student Plaza', 'Open Covered Court Plaza', 'Near Information Kiosk', 0, 0, 1, '2026-09-01 12:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `PaymentRecords`
--

CREATE TABLE IF NOT EXISTS `PaymentRecords` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `ListingId` int(11) NOT NULL,
  `Amount` decimal(18,2) NOT NULL,
  `Currency` varchar(10) NOT NULL DEFAULT 'PHP',
  `Provider` varchar(50) NOT NULL DEFAULT 'PayMongo',
  `ProviderReference` varchar(255) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'PAID',
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `PaidAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_PaymentRecords_Users` (`UserId`),
  KEY `FK_PaymentRecords_Listings` (`ListingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE IF NOT EXISTS `Reports` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ReporterId` int(11) NOT NULL,
  `ReportedUserId` int(11) DEFAULT NULL,
  `ListingId` int(11) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL DEFAULT 'Scam',
  `Details` text DEFAULT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'PENDING',
  `InternalNotes` text DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StudentProfiles`
--

CREATE TABLE IF NOT EXISTS `StudentProfiles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `StudentNumber` varchar(100) NOT NULL,
  `SchoolEmail` varchar(255) NOT NULL,
  `Course` varchar(150) NOT NULL,
  `YearLevel` varchar(50) NOT NULL,
  `ProfileImage` longtext DEFAULT NULL,
  `VerificationStatus` varchar(50) NOT NULL DEFAULT 'VERIFIED',
  `Rating` double NOT NULL DEFAULT 5,
  `CompletedTransactions` int(11) NOT NULL DEFAULT 0,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`Id`),
  KEY `FK_StudentProfiles_Users` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `StudentProfiles` (Romeo Only)
--

INSERT INTO `StudentProfiles` (`Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `SchoolEmail`, `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`, `CreatedAt`, `UpdatedAt`) VALUES
(2, 104, 'Romeo Paolo', 'Tolentino', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', NULL, 'VERIFIED', 5, 0, '2026-09-01 14:31:07', '2026-09-01 14:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL DEFAULT 'STUDENT',
  `Status` varchar(50) NOT NULL DEFAULT 'VERIFIED',
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastLoginAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Users` (Admin & Romeo Only)
--

INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`, `UpdatedAt`, `LastLoginAt`) VALUES
(100, 'admin', 'Pogilameg', 'ADMIN', 'VERIFIED', '2026-09-01 13:26:08', '2026-09-01 13:26:08', NULL),
(104, 'romeopaolotolentino@gmail.com', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', '2026-09-01 14:31:07', '2026-09-01 14:31:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `WantedPosts`
--

CREATE TABLE IF NOT EXISTS `WantedPosts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `MaximumBudget` decimal(18,2) NOT NULL,
  `Condition` varchar(50) NOT NULL DEFAULT 'Any',
  `ImageUrl` longtext DEFAULT NULL,
  `MeetupLocationId` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`Id`),
  KEY `FK_WantedPosts_Users` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Constraints for dumped tables
--

ALTER TABLE `ListingImages`
  ADD CONSTRAINT `FK_ListingImages_Listings` FOREIGN KEY (`ListingId`) REFERENCES `Listings` (`Id`) ON DELETE CASCADE;

ALTER TABLE `Listings`
  ADD CONSTRAINT `FK_Listings_Categories` FOREIGN KEY (`CategoryId`) REFERENCES `Categories` (`Id`),
  ADD CONSTRAINT `FK_Listings_MeetupLocations` FOREIGN KEY (`MeetupLocationId`) REFERENCES `MeetupLocations` (`Id`),
  ADD CONSTRAINT `FK_Listings_Users` FOREIGN KEY (`SellerId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

ALTER TABLE `PaymentRecords`
  ADD CONSTRAINT `FK_PaymentRecords_Listings` FOREIGN KEY (`ListingId`) REFERENCES `Listings` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_PaymentRecords_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

ALTER TABLE `StudentProfiles`
  ADD CONSTRAINT `FK_StudentProfiles_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

ALTER TABLE `WantedPosts`
  ADD CONSTRAINT `FK_WantedPosts_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
