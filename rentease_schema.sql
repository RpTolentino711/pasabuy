-- ==========================================================
-- RentEase: Event & Equipment Rental Platform Schema
-- "Easy Rentals. Seamless Events." | "Rent. Book. Celebrate."
-- ==========================================================

-- 1. Rental Inventory Table (Inventory Management Module - 10%)
CREATE TABLE IF NOT EXISTS `rental_inventory` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL, -- Chairs, Tables, Tents, Sound System, Lights, Decorations, Stages, Others
  `material_tag` VARCHAR(50) DEFAULT 'Plastic', -- All, Plastic, Wooden, Premium
  `price_per_day` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `qty_total` INT NOT NULL DEFAULT 100,
  `qty_available` INT NOT NULL DEFAULT 80,
  `qty_rented` INT NOT NULL DEFAULT 15,
  `qty_maintenance` INT NOT NULL DEFAULT 5,
  `image_url` VARCHAR(500) DEFAULT NULL,
  `rating` DECIMAL(2,1) DEFAULT 4.8,
  `reviews_count` INT DEFAULT 120,
  `description` TEXT DEFAULT NULL,
  `min_rental_days` INT DEFAULT 1,
  `is_featured` TINYINT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Rental Packages Table (Marketing Strategy Module - 10%)
CREATE TABLE IF NOT EXISTS `rental_packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `tagline` VARCHAR(255) DEFAULT NULL,
  `bundled_items` TEXT DEFAULT NULL,
  `starting_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` INT DEFAULT 15,
  `badge` VARCHAR(50) DEFAULT 'Popular',
  `image_url` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Rental Orders Table (Online Ordering 20% + Digital Payment 10% + Computation Module)
CREATE TABLE IF NOT EXISTS `rental_orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_code` VARCHAR(50) NOT NULL UNIQUE, -- e.g. #RE-10245
  `customer_name` VARCHAR(150) NOT NULL DEFAULT 'Bea Solis',
  `customer_email` VARCHAR(150) NOT NULL DEFAULT 'bea@gmail.com',
  `customer_phone` VARCHAR(50) DEFAULT '09171234567',
  `delivery_option` ENUM('DELIVERY', 'PICKUP') NOT NULL DEFAULT 'DELIVERY',
  `delivery_address` VARCHAR(255) DEFAULT 'San Pablo, Laguna',
  `rental_start_date` DATE NOT NULL,
  `rental_end_date` DATE DEFAULT NULL,
  `rental_days` INT DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `service_charge` DECIMAL(10,2) NOT NULL DEFAULT 100.00,
  `delivery_fee` DECIMAL(10,2) NOT NULL DEFAULT 150.00,
  `discount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` ENUM('GCASH', 'CARD', 'COD') NOT NULL DEFAULT 'GCASH',
  `payment_status` ENUM('PAID', 'PENDING', 'FAILED') NOT NULL DEFAULT 'PAID',
  `order_status` ENUM('CONFIRMED', 'PREPARING', 'PICKUP', 'ON_THE_WAY', 'DELIVERED', 'RETURNED', 'CANCELLED') NOT NULL DEFAULT 'CONFIRMED',
  `estimated_arrival` VARCHAR(50) DEFAULT '4:30 PM',
  `assigned_rider_name` VARCHAR(100) DEFAULT 'Juan Dela Cruz',
  `assigned_rider_phone` VARCHAR(50) DEFAULT '09187654321',
  `rider_current_lat` DECIMAL(10,8) DEFAULT 14.65000000,
  `rider_current_lng` DECIMAL(11,8) DEFAULT 121.07000000,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Rental Order Items Table
CREATE TABLE IF NOT EXISTS `rental_order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT DEFAULT NULL,
  `product_name` VARCHAR(150) NOT NULL,
  `price_per_day` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `quantity` INT NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  FOREIGN KEY (`order_id`) REFERENCES `rental_orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Rental Issues / Support Center (Customer Support Module - 10%)
CREATE TABLE IF NOT EXISTS `rental_issues` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ticket_number` VARCHAR(50) NOT NULL UNIQUE, -- e.g. #10245
  `order_code` VARCHAR(50) DEFAULT NULL,
  `customer_name` VARCHAR(150) NOT NULL,
  `issue_title` VARCHAR(150) NOT NULL, -- Damaged Chair, Late Delivery, Missing Equipment
  `description` TEXT DEFAULT NULL,
  `status` ENUM('REPORTED', 'REVIEWING', 'IN_PROGRESS', 'RESOLVED') NOT NULL DEFAULT 'REPORTED',
  `status_display` VARCHAR(50) DEFAULT 'Under Review',
  `priority` ENUM('LOW', 'MEDIUM', 'HIGH', 'CRITICAL') NOT NULL DEFAULT 'MEDIUM',
  `resolution_notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Sample Data matching UIDESIFNAPP.png & RentEase.pdf
INSERT INTO `rental_inventory` (`id`, `name`, `category`, `material_tag`, `price_per_day`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `image_url`, `rating`, `reviews_count`, `description`, `min_rental_days`, `is_featured`) VALUES
(1, 'Monoblock Chair', 'Chairs', 'Plastic', 20.00, 235, 150, 80, 5, 'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=500&q=80', 4.8, 120, 'Durable and lightweight monoblock chair, perfect for any event or gathering.', 1, 1),
(2, 'Banquet Chair', 'Chairs', 'Premium', 50.00, 150, 95, 50, 5, 'https://images.unsplash.com/photo-1580481077195-c3a821a5060f?w=500&q=80', 4.9, 85, 'Elegant gold-accent banquet chair with cushioned backrest, ideal for weddings and formal ceremonies.', 1, 1),
(3, 'Folding Chair', 'Chairs', 'Wooden', 35.00, 120, 75, 40, 5, 'https://images.unsplash.com/photo-1503602642458-232111445657?w=500&q=80', 4.7, 64, 'Compact and sturdy folding chair for outdoor and casual parties.', 1, 0),
(4, 'Cushioned Chair', 'Chairs', 'Premium', 60.00, 90, 55, 30, 5, 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=500&q=80', 4.8, 42, 'Ultra-comfortable cushioned dining and event chair with sleek metal frame.', 1, 0),
(5, 'Folding Table', 'Tables', 'Plastic', 40.00, 67, 40, 25, 2, 'https://images.unsplash.com/photo-1530018607912-eff2daa1bac4?w=500&q=80', 4.8, 92, 'Heavy-duty 6-foot rectangular folding banquet table, seats 6-8 people comfortably.', 1, 1),
(6, 'Round Banquet Table', 'Tables', 'Wooden', 75.00, 45, 28, 15, 2, 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=500&q=80', 4.9, 58, 'Large 60-inch round banquet table perfect for reception dining.', 1, 0),
(7, 'Event Tent (10x10ft)', 'Tents', 'Premium', 800.00, 21, 12, 8, 1, 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80', 4.9, 110, 'Heavy-duty waterproof canopy tent for outdoor weddings, corporate events, and parties.', 1, 1),
(8, 'Large Pavilion Tent (20x20ft)', 'Tents', 'Premium', 1800.00, 10, 6, 3, 1, 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=500&q=80', 4.9, 34, 'Spacious commercial grade pavilion tent with decorative sidewalls.', 1, 0),
(9, 'Sound System & Dual Mic', 'Sound System', 'Premium', 1200.00, 27, 15, 10, 2, 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=500&q=80', 4.9, 88, 'Complete party audio package with amplifier, 2 wireless microphones, and Bluetooth mixer.', 1, 1),
(10, 'LED Stage Par Lights', 'Lights', 'Premium', 300.00, 40, 28, 10, 2, 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=500&q=80', 4.8, 51, 'RGB multi-color sound-activated LED wash par lights with remote control.', 1, 0),
(11, 'Balloon Arch & Backdrop Frame', 'Decorations', 'Wooden', 1500.00, 18, 12, 5, 1, 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=500&q=80', 4.8, 73, 'Customizable round metal and wood backdrop frame for photo booth and stage decor.', 1, 0),
(12, 'Modular Stage Platform (4x8ft)', 'Stages', 'Premium', 2500.00, 14, 9, 4, 1, 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=500&q=80', 4.9, 29, 'Heavy-duty modular non-slip stage deck with adjustable height risers and stairs.', 1, 0)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed Event Packages (RentEase.pdf Marketing Strategy - 10%)
INSERT INTO `rental_packages` (`id`, `name`, `tagline`, `bundled_items`, `starting_price`, `discount_percentage`, `badge`, `image_url`) VALUES
(1, 'Birthday Celebration Package', '50 Chairs + 5 Tables + Event Tent', '50x Monoblock Chairs, 5x Folding Tables, 1x Event Tent (10x10ft)', 1499.00, 20, 'Most Popular', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=500&q=80'),
(2, 'Grand Wedding Package', '100 Banquet Chairs + 10 Round Tables + Pavilion + Audio', '100x Banquet Chairs, 10x Round Banquet Tables, 1x Pavilion Tent, 1x Sound System Package', 5999.00, 25, 'Luxury Tier', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=500&q=80'),
(3, 'Weekend Social Gathering Package', '30 Folding Chairs + 3 Tables + Sound System', '30x Folding Chairs, 3x Folding Tables, 1x Sound System & Dual Mic', 2199.00, 15, 'Best Value', 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=500&q=80')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed Live Track Order #RE-10245 (Screen 7 in UIDESIFNAPP.png & RentEase.pdf)
INSERT INTO `rental_orders` (`id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `delivery_option`, `delivery_address`, `rental_start_date`, `rental_days`, `subtotal`, `service_charge`, `delivery_fee`, `discount`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `estimated_arrival`, `assigned_rider_name`, `assigned_rider_phone`, `rider_current_lat`, `rider_current_lng`) VALUES
(1, '#RE-10245', 'Bea Solis', 'bea@gmail.com', '09171234567', 'DELIVERY', 'San Pablo, Laguna', '2026-09-25', 1, 1700.00, 100.00, 150.00, 200.00, 1750.00, 'GCASH', 'PAID', 'ON_THE_WAY', '4:30 PM', 'Juan Dela Cruz', '09187654321', 14.65150000, 121.06920000)
ON DUPLICATE KEY UPDATE `order_status` = VALUES(`order_status`);

INSERT INTO `rental_order_items` (`order_id`, `product_id`, `product_name`, `price_per_day`, `quantity`, `subtotal`) VALUES
(1, 1, 'Monoblock Chair', 20.00, 10, 500.00),
(1, 5, 'Folding Table', 40.00, 2, 400.00),
(1, 7, 'Event Tent (10x10ft)', 800.00, 1, 800.00)
ON DUPLICATE KEY UPDATE `product_name` = VALUES(`product_name`);

-- Seed Issue Center Tickets (RentEase.pdf Customer Support - 10%)
INSERT INTO `rental_issues` (`id`, `ticket_number`, `order_code`, `customer_name`, `issue_title`, `description`, `status`, `status_display`, `priority`) VALUES
(1, '#10245', '#RE-10245', 'Bea Solis', 'Damaged Chair', 'One monoblock chair had a cracked leg upon delivery.', 'REVIEWING', 'Under Review', 'MEDIUM'),
(2, '#10238', '#RE-10238', 'Mark Reyes', 'Late Delivery', 'Equipment arrived 45 minutes past the agreed 2:00 PM schedule.', 'IN_PROGRESS', 'Solving', 'HIGH'),
(3, '#10231', '#RE-10231', 'Elena Santos', 'Missing Equipment', 'Order was missing 2 microphone wireless receivers.', 'RESOLVED', 'Resolved', 'MEDIUM')
ON DUPLICATE KEY UPDATE `issue_title` = VALUES(`issue_title`);
