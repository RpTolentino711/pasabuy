-- Insert additional test users
INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`) VALUES
(105, 'john.doe@student.edu.ph', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW()),
(106, 'maria.santos@student.edu.ph', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW()),
(107, 'kevin.ramos@student.edu.ph', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW()),
(108, 'anna.cruz@student.edu.ph', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW());

-- Insert student profiles for new users
INSERT INTO `StudentProfiles` (`Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `SchoolEmail`, `Course`, `YearLevel`, `VerificationStatus`, `Rating`, `CompletedTransactions`, `CreatedAt`) VALUES
(3, 105, 'John', 'Doe', '2023-00123', 'john.doe@student.edu.ph', 'BS Computer Science', '3rd Year', 'VERIFIED', 5.0, 2, NOW()),
(4, 106, 'Maria', 'Santos', '2023-00456', 'maria.santos@student.edu.ph', 'BS Civil Engineering', '2nd Year', 'VERIFIED', 4.8, 1, NOW()),
(5, 107, 'Kevin', 'Ramos', '2024-00891', 'kevin.ramos@student.edu.ph', 'BS Electrical Engineering', '1st Year', 'VERIFIED', 5.0, 0, NOW()),
(6, 108, 'Anna', 'Cruz', '2023-00234', 'anna.cruz@student.edu.ph', 'BS Information Technology', '2nd Year', 'VERIFIED', 4.9, 3, NOW());

-- Insert sample listings (ACTIVE listings)
INSERT INTO `Listings` (`Id`, `SellerId`, `CategoryId`, `Title`, `Description`, `Price`, `Condition`, `Status`, `MeetupLocationId`, `Views`, `FavoritesCount`, `CreatedAt`, `ExpiresAt`) VALUES
(1, 105, 2, 'Dell Laptop - Great Condition', 'Dell Inspiron 15, Intel i5, 8GB RAM, 256GB SSD. Used for 1 year. Very good condition, minimal scratches. Includes charger and original box. Perfect for college coursework.', 18000, 'Excellent', 'ACTIVE', 1, 45, 3, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(2, 106, 1, 'Mechanical Pencil Set + Rulers', 'Complete drafting kit with high-quality mechanical pencils (0.5mm, 0.7mm), metal rulers (30cm, 45cm), erasers, and carrying pouch. Ideal for engineering and architecture students.', 450, 'Like New', 'ACTIVE', 2, 12, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(3, 107, 3, 'Organic Chemistry Textbook - NEW', 'Morrison & Boyd Organic Chemistry 6th Edition. Unopened, brand new. Important reference for CHEM 201. Bought extra by mistake.', 1200, 'New', 'ACTIVE', 1, 28, 2, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(4, 108, 4, 'Apple AirPods Pro - Sealed Box', 'Brand new, factory sealed. Never opened. Latest model with active noise cancellation. Bought as gift but need funds for tuition. Includes all accessories.', 7500, 'New', 'ACTIVE', 3, 67, 5, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(5, 104, 2, 'Wireless Mouse + USB Keyboard Bundle', 'Logitech wireless mouse (MX Master 3) and mechanical keyboard. Both in excellent working condition. Upgraded to gaming peripherals. Willing to negotiate.', 2800, 'Very Good', 'ACTIVE', 2, 33, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(6, 105, 1, 'Graphing Calculator TI-84 Plus', 'Texas Instruments TI-84 Plus CE. Fully functional, minimal battery usage. Completed all math requirements. Includes manual and USB cable.', 2500, 'Good', 'ACTIVE', 1, 19, 0, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(7, 106, 5, 'Campus Pasabuy - Homemade Pastries Bundle', 'Fresh baked daily. Chocolate chip cookies, ube brownies, and soufflé cheesecake slices. Available Mon-Fri after 4PM. Pre-order via chat. Premium ingredients, hygienically prepared.', 180, 'Fresh', 'ACTIVE', 4, 51, 8, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY)),
(8, 107, 1, 'Engineering Blueprint Pad A2 Size', '50 sheets of engineering-grade blueprint paper. Perfect for drawing assignments and projects. Minimal usage (only 10 sheets used). Acid-free, durable paper.', 350, 'Like New', 'ACTIVE', 2, 8, 0, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(9, 108, 4, 'Sony WH-CH720N Wireless Headphones', 'Excellent noise cancellation, 35+ hour battery life. Light wear on ear cups. Works perfectly. Original box and cable included. Upgraded to premium model.', 3200, 'Excellent', 'ACTIVE', 3, 42, 2, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(10, 104, 3, 'Physics Lab Manual Bundle - Semester 1 & 2', 'Complete physics lab manuals with specimen answers and solutions. Covers mechanics, thermodynamics, waves. Clean condition, minimal annotations. Perfect study reference.', 800, 'Good', 'ACTIVE', 1, 15, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY));

-- Insert listing images
INSERT INTO `ListingImages` (`Id`, `ListingId`, `ImageUrl`, `SortOrder`, `IsPrimary`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1588872657840-790ff3d1b4d7?w=500&q=80', 1, 1),
(2, 1, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&q=80', 2, 0),
(3, 2, 'https://images.unsplash.com/photo-1609933882555-9d3e2eca75f9?w=500&q=80', 1, 1),
(4, 3, 'https://images.unsplash.com/photo-1532012197267-da84ec266817?w=500&q=80', 1, 1),
(5, 4, 'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?w=500&q=80', 1, 1),
(6, 5, 'https://images.unsplash.com/photo-1587522431346-c1a168be0e2c?w=500&q=80', 1, 1),
(7, 5, 'https://images.unsplash.com/photo-1587892211997-7e0e188a7587?w=500&q=80', 2, 0),
(8, 6, 'https://images.unsplash.com/photo-1611532736579-6b16e2b50449?w=500&q=80', 1, 1),
(9, 7, 'https://images.unsplash.com/photo-1585951237318-26b3911abbf7?w=500&q=80', 1, 1),
(10, 8, 'https://images.unsplash.com/photo-1609933882555-9d3e2eca75f9?w=500&q=80', 1, 1),
(11, 9, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80', 1, 1),
(12, 10, 'https://images.unsplash.com/photo-1532012197267-da84ec266817?w=500&q=80', 1, 1);

-- Insert payment records for active listings
INSERT INTO `PaymentRecords` (`Id`, `UserId`, `ListingId`, `Amount`, `Currency`, `Provider`, `ProviderReference`, `Status`, `CreatedAt`, `PaidAt`) VALUES
(1, 105, 1, 5.00, 'PHP', 'PayMongo', 'PM-laptop-001', 'PAID', NOW(), NOW()),
(2, 106, 2, 1.00, 'PHP', 'PayMongo', 'PM-pencil-002', 'PAID', NOW(), NOW()),
(3, 107, 3, 1.00, 'PHP', 'PayMongo', 'PM-chemistry-003', 'PAID', NOW(), NOW()),
(4, 108, 4, 10.00, 'PHP', 'PayMongo', 'PM-airpods-004', 'PAID', NOW(), NOW()),
(5, 104, 5, 5.00, 'PHP', 'PayMongo', 'PM-keyboard-005', 'PAID', NOW(), NOW()),
(6, 105, 6, 5.00, 'PHP', 'PayMongo', 'PM-calculator-006', 'PAID', NOW(), NOW()),
(7, 106, 7, 1.00, 'PHP', 'PayMongo', 'PM-pastries-007', 'PAID', NOW(), NOW()),
(8, 107, 8, 1.00, 'PHP', 'PayMongo', 'PM-blueprint-008', 'PAID', NOW(), NOW()),
(9, 108, 9, 5.00, 'PHP', 'PayMongo', 'PM-headphones-009', 'PAID', NOW(), NOW()),
(10, 104, 10, 1.00, 'PHP', 'PayMongo', 'PM-physics-010', 'PAID', NOW(), NOW());

-- Set AUTO_INCREMENT values for next inserts
ALTER TABLE `Users` AUTO_INCREMENT = 109;
ALTER TABLE `StudentProfiles` AUTO_INCREMENT = 7;
ALTER TABLE `Listings` AUTO_INCREMENT = 11;
ALTER TABLE `ListingImages` AUTO_INCREMENT = 13;
ALTER TABLE `PaymentRecords` AUTO_INCREMENT = 11;

COMMIT;
