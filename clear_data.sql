-- ========================================================
-- PasaBuy Campus Marketplace - Clear Data & Set Admin User
-- Execute this SQL script in phpMyAdmin to wipe sample data
-- and create the Admin user account: admin / Pogilameg
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Wipe sample listing photos, listings, wanted requests & test data
DELETE FROM `ListingImages`;
DELETE FROM `Listings`;
DELETE FROM `WantedPosts`;
DELETE FROM `PaymentRecords`;
DELETE FROM `Reports`;
DELETE FROM `AuditLogs`;

-- 2. Insert or Update Admin Account (Username: admin, Password: Pogilameg)
INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`) 
VALUES ('admin', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

-- Also insert matching admin email if needed
INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`) 
VALUES ('admin@pasabuy.site', 'Pogilameg', 'ADMIN', 'VERIFIED')
ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg', `Role` = 'ADMIN', `Status` = 'VERIFIED';

SET FOREIGN_KEY_CHECKS = 1;
