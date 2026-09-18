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
-- Schema initialized cleanly with zero dummy data.
-- Live equipment is dynamically listed by students via Post Equipment.

