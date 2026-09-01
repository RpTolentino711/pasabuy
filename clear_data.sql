-- ========================================================
-- PasaBuy Campus Marketplace - Clear All Dummy / Sample Data
-- Execute this SQL script in phpMyAdmin to wipe all sample listings,
-- dummy wanted posts, test payments, and fake reports.
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Wipe all sample marketplace listings and images
TRUNCATE TABLE `ListingImages`;
TRUNCATE TABLE `Listings`;

-- Wipe all sample wanted posts and responses
TRUNCATE TABLE `WantedPosts`;

-- Wipe test payment records & moderation logs
TRUNCATE TABLE `PaymentRecords`;
TRUNCATE TABLE `Reports`;
TRUNCATE TABLE `AuditLogs`;

SET FOREIGN_KEY_CHECKS = 1;
