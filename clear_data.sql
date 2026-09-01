-- ========================================================
-- PasaBuy Campus Marketplace - Complete Clean Database Reset
-- Execute in phpMyAdmin SQL tab to wipe all sample/dump users,
-- sample listings, wanted posts, and keep ONLY Admin (Pogilameg)
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Wipe all sample listings & photos
DELETE FROM `ListingImages`;
DELETE FROM `Listings`;

-- 2. Wipe all sample wanted posts, payments, reports & audit logs
DELETE FROM `WantedPosts`;
DELETE FROM `PaymentRecords`;
DELETE FROM `Reports`;
DELETE FROM `AuditLogs`;

-- 3. Wipe all student profiles
DELETE FROM `StudentProfiles`;

-- 4. Wipe all users EXCEPT admin with Pogilameg password
DELETE FROM `Users` WHERE `Email` NOT IN ('admin', 'admin@pasabuy.site');

-- 5. Ensure Admin accounts exist with password Pogilameg
INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`) 
VALUES ('admin', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`) 
VALUES ('admin@pasabuy.site', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

SET FOREIGN_KEY_CHECKS = 1;
