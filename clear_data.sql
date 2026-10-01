-- ========================================================
-- PasaBuy Campus Marketplace & RentEase Clean Database Reset
-- Execute in phpMyAdmin SQL tab to wipe all dummy data
-- KEEP ONLY:
-- 1. Admin (admin / admin@pasabuy.site)
-- 2. romeopaolotolentino@gmail.com (UserId 104)
-- 3. pogilameg@gmail.com (UserId 105)
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Wipe all listings & photos
DELETE FROM `ListingImages`;
DELETE FROM `Listings`;

-- 2. Wipe all wanted posts, payments, reports, chat & audit logs
DELETE FROM `WantedPosts`;
DELETE FROM `PaymentRecords`;
DELETE FROM `Reports`;
DELETE FROM `AuditLogs`;
DELETE FROM `ChatMessages`;
DELETE FROM `OtpVerifications` WHERE 1=1;

-- 3. Wipe any rental order records, tickets & obsolete driver/rider entries
DELETE FROM `rental_order_items` WHERE 1=1;
DELETE FROM `rental_orders` WHERE 1=1;
DELETE FROM `rental_issues` WHERE 1=1;
DROP TABLE IF EXISTS `rental_drivers`;
DROP TABLE IF EXISTS `Riders`;

-- 4. Wipe all users EXCEPT Admin, Romeo Paolo Tolentino, and Pogilameg
DELETE FROM `StudentProfiles` WHERE `UserId` NOT IN (100, 104, 105) 
  AND `SchoolEmail` NOT IN ('romeopaolotolentino@gmail.com', 'pogilameg@gmail.com');

DELETE FROM `Users` WHERE `Email` NOT IN (
  'admin', 
  'admin@pasabuy.site', 
  'admin@pasabuy.edu.ph', 
  'romeopaolotolentino@gmail.com', 
  'pogilameg@gmail.com'
) AND `Id` NOT IN (100, 104, 105);

-- 5. Seed / Ensure Admin Accounts (Password: Pogilameg)
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) 
VALUES (100, 'admin', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`) 
VALUES ('admin@pasabuy.site', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

-- 6. Seed / Ensure Romeo Paolo Tolentino (UserId 104 - Password: Pogilameg)
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`) 
VALUES (104, 'romeopaolotolentino@gmail.com', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW())
ON DUPLICATE KEY UPDATE 
  `Email` = 'romeopaolotolentino@gmail.com',
  `PasswordHash` = '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C',
  `Role` = 'STUDENT',
  `Status` = 'VERIFIED';

DELETE FROM `StudentProfiles` WHERE `UserId` = 104 OR `SchoolEmail` = 'romeopaolotolentino@gmail.com';
INSERT INTO `StudentProfiles` (
  `Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `SchoolEmail`, 
  `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`
) VALUES (
  2, 104, 'Romeo Paolo', 'Tolentino', '09668257301', 'romeopaolotolentino@gmail.com', 
  'BSIT', '4th Yr', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80', 'VERIFIED', 5.0, 12
);

-- 7. Seed / Ensure Pogilameg Tester (UserId 105 - Password: Pogilameg)
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`) 
VALUES (105, 'pogilameg@gmail.com', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW())
ON DUPLICATE KEY UPDATE 
  `Email` = 'pogilameg@gmail.com',
  `PasswordHash` = '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C',
  `Role` = 'STUDENT',
  `Status` = 'VERIFIED';

DELETE FROM `StudentProfiles` WHERE `UserId` = 105 OR `SchoolEmail` = 'pogilameg@gmail.com';
INSERT INTO `StudentProfiles` (
  `Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `SchoolEmail`, 
  `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`
) VALUES (
  3, 105, 'Pogilameg', 'Tester', '09171234567', 'pogilameg@gmail.com', 
  'BSCS', '3rd Yr', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80', 'VERIFIED', 5.0, 8
);

-- 8. Reset Auto Increment IDs
ALTER TABLE `Listings` AUTO_INCREMENT = 1;
ALTER TABLE `ListingImages` AUTO_INCREMENT = 1;
ALTER TABLE `PaymentRecords` AUTO_INCREMENT = 1;
ALTER TABLE `WantedPosts` AUTO_INCREMENT = 1;
ALTER TABLE `Reports` AUTO_INCREMENT = 1;
ALTER TABLE `AuditLogs` AUTO_INCREMENT = 1;
ALTER TABLE `ChatMessages` AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;
