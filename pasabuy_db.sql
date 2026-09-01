-- ========================================================
-- PasaBuy Campus Marketplace Complete MySQL Database Script
-- Compatible with Hostinger / XAMPP / MariaDB / phpMyAdmin / MySQL Workbench
-- ========================================================

-- --------------------------------------------------------
-- Table structure for Users
-- --------------------------------------------------------
DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL DEFAULT 'STUDENT',
  `Status` varchar(50) NOT NULL DEFAULT 'VERIFIED',
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LastLoginAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for StudentProfiles
-- --------------------------------------------------------
DROP TABLE IF EXISTS `StudentProfiles`;
CREATE TABLE `StudentProfiles` (
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
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `FK_StudentProfiles_Users` (`UserId`),
  CONSTRAINT `FK_StudentProfiles_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for Categories
-- --------------------------------------------------------
DROP TABLE IF EXISTS `Categories`;
CREATE TABLE `Categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `IconClass` varchar(100) NOT NULL DEFAULT 'tag',
  `SortOrder` int(11) NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for MeetupLocations
-- --------------------------------------------------------
DROP TABLE IF EXISTS `MeetupLocations`;
CREATE TABLE `MeetupLocations` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `LocationDetails` text DEFAULT NULL,
  `Latitude` double NOT NULL DEFAULT 0,
  `Longitude` double NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for Listings
-- --------------------------------------------------------
DROP TABLE IF EXISTS `Listings`;
CREATE TABLE `Listings` (
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
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ExpiresAt` datetime DEFAULT NULL,
  `ReservedAt` datetime DEFAULT NULL,
  `SoldAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Listings_Users` (`SellerId`),
  KEY `FK_Listings_Categories` (`CategoryId`),
  KEY `FK_Listings_MeetupLocations` (`MeetupLocationId`),
  CONSTRAINT `FK_Listings_Categories` FOREIGN KEY (`CategoryId`) REFERENCES `Categories` (`Id`),
  CONSTRAINT `FK_Listings_MeetupLocations` FOREIGN KEY (`MeetupLocationId`) REFERENCES `MeetupLocations` (`Id`),
  CONSTRAINT `FK_Listings_Users` FOREIGN KEY (`SellerId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for ListingImages
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ListingImages`;
CREATE TABLE `ListingImages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ListingId` int(11) NOT NULL,
  `ImageUrl` longtext NOT NULL,
  `SortOrder` int(11) NOT NULL DEFAULT 0,
  `IsPrimary` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `FK_ListingImages_Listings` (`ListingId`),
  CONSTRAINT `FK_ListingImages_Listings` FOREIGN KEY (`ListingId`) REFERENCES `Listings` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for WantedPosts
-- --------------------------------------------------------
DROP TABLE IF EXISTS `WantedPosts`;
CREATE TABLE `WantedPosts` (
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
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `FK_WantedPosts_Users` (`UserId`),
  CONSTRAINT `FK_WantedPosts_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for PaymentRecords
-- --------------------------------------------------------
DROP TABLE IF EXISTS `PaymentRecords`;
CREATE TABLE `PaymentRecords` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `ListingId` int(11) NOT NULL,
  `Amount` decimal(18,2) NOT NULL,
  `Currency` varchar(10) NOT NULL DEFAULT 'PHP',
  `Provider` varchar(50) NOT NULL DEFAULT 'PayMongo',
  `ProviderReference` varchar(255) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'PAID',
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PaidAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_PaymentRecords_Users` (`UserId`),
  KEY `FK_PaymentRecords_Listings` (`ListingId`),
  CONSTRAINT `FK_PaymentRecords_Listings` FOREIGN KEY (`ListingId`) REFERENCES `Listings` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `FK_PaymentRecords_Users` FOREIGN KEY (`UserId`) REFERENCES `Users` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for Reports
-- --------------------------------------------------------
DROP TABLE IF EXISTS `Reports`;
CREATE TABLE `Reports` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ReporterId` int(11) NOT NULL,
  `ReportedUserId` int(11) DEFAULT NULL,
  `ListingId` int(11) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL DEFAULT 'Scam',
  `Details` text DEFAULT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'PENDING',
  `InternalNotes` text DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for AuditLogs
-- --------------------------------------------------------
DROP TABLE IF EXISTS `AuditLogs`;
CREATE TABLE `AuditLogs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AdminId` int(11) NOT NULL,
  `Action` varchar(100) NOT NULL,
  `TargetType` varchar(100) NOT NULL,
  `TargetId` varchar(100) NOT NULL,
  `Details` text DEFAULT NULL,
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IpAddress` varchar(50) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Seed Initial Data into pasabuy_db
-- --------------------------------------------------------

-- Categories
INSERT INTO `Categories` (`Id`, `Name`, `Description`, `IconClass`, `SortOrder`, `IsActive`) VALUES
(1, 'School Supplies', 'Calculators, Pens, Notebooks, Drafting Tools', 'pen-ruler', 1, 1),
(2, 'Electronics', 'Mice, Keyboards, Powerbanks, Cables', 'laptop', 2, 1),
(3, 'Books', 'Textbooks, Reviewers, Lab Manuals', 'book', 3, 1),
(4, 'Gadgets', 'Tablets, Headphones, Smartwatches', 'mobile-screen-button', 4, 1),
(5, 'Food / Pasabuy', 'Campus Snack Delivery & Meal Pasabuy', 'utensils', 5, 1);

-- Meetup Locations
INSERT INTO `MeetupLocations` (`Id`, `Name`, `Description`, `LocationDetails`, `IsActive`) VALUES
(1, 'Library Lobby', 'Main Campus University Library Ground Floor', 'Near Security Checkpoint', 1),
(2, 'Student Cafeteria', 'Central Food Court & Dining Area', 'Center Tables', 1),
(3, 'School Gate Main Entrance', 'Main Campus Pedestrian Gate', 'Guard Post Area', 1),
(4, 'Student Plaza', 'Open Covered Court Plaza', 'Near Information Kiosk', 1);

-- Default Student Account
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) VALUES
(1, 'john.doe@student.edu.ph', 'hashed_pass_123', 'STUDENT', 'VERIFIED');

INSERT INTO `StudentProfiles` (`Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `SchoolEmail`, `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`) VALUES
(1, 1, 'John', 'Doe', '2023-00123', 'john.doe@student.edu.ph', 'BS Computer Science', '3rd Yr', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80', 'VERIFIED', 4.9, 18);

-- Admin Account
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) VALUES
(99, 'admin@pasabuy.edu.ph', 'admin_hash_999', 'ADMIN', 'VERIFIED');
