<?php
/**
 * PasaBuy Live Hostinger Database Cleaner
 * Purges all dummy test data, leaving ONLY Admin (100) and Romeo Paolo Tolentino (104).
 */

header('Content-Type: application/json; charset=utf-8');

$dbHost = '127.0.0.1';
$dbName = 'u321173822_pasabuy';
$dbUser = 'u321173822_Pogilameg';
$dbPass = 'Pogilameg@10';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (Exception $e2) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e2->getMessage()]);
        exit;
    }
}

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

    // Purge dummy tables
    $pdo->exec("DELETE FROM ChatMessages;");
    $pdo->exec("DELETE FROM ListingImages;");
    $pdo->exec("DELETE FROM Listings;");
    $pdo->exec("DELETE FROM PaymentRecords;");
    $pdo->exec("DELETE FROM Reports;");
    $pdo->exec("DELETE FROM WantedPosts;");
    $pdo->exec("DELETE FROM AuditLogs;");
    $pdo->exec("DELETE FROM OtpVerifications;");
    try { $pdo->exec("DELETE FROM rental_order_items;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM rental_orders;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM rental_issues;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM rental_packages;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM rental_inventory;"); } catch (Exception $e) {}

    // Clean Users (Keep Admin 100, Romeo 104, Pogilameg 105)
    $pdo->exec("DELETE FROM Users WHERE Id NOT IN (100, 104, 105);");
    
    // Ensure Admin, Romeo & Pogilameg exist with password Pogilameg@10
    $hashPogilameg = password_hash('Pogilameg@10', PASSWORD_DEFAULT);
    
    $stmtUser = $pdo->prepare("INSERT INTO Users (Id, Email, PasswordHash, Role, Status, CreatedAt, UpdatedAt) VALUES 
        (100, 'admin', 'Pogilameg@10', 'ADMIN', 'VERIFIED', NOW(), NOW()),
        (104, 'romeopaolotolentino@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW()),
        (105, 'pogilameg@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW())
        ON DUPLICATE KEY UPDATE `PasswordHash` = VALUES(`PasswordHash`), `Role` = VALUES(`Role`), `Status` = VALUES(`Status`)");
    $stmtUser->execute([$hashPogilameg, $hashPogilameg]);

    // Clean StudentProfiles (Keep Romeo 104 and Pogilameg 105)
    $pdo->exec("DELETE FROM StudentProfiles WHERE UserId NOT IN (104, 105);");
    $pdo->exec("INSERT INTO StudentProfiles (Id, UserId, FirstName, LastName, StudentNumber, SchoolEmail, Course, YearLevel, ProfileImage, VerificationStatus, Rating, CompletedTransactions, CreatedAt, UpdatedAt) VALUES 
        (2, 104, 'Romeo Paolo', 'Tolentino', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', NULL, 'VERIFIED', 5.0, 1, NOW(), NOW()),
        (3, 105, 'Pogilameg', 'Tester', 'pogilameg@10', 'pogilameg@gmail.com', 'BSIT', '3rd Yr', NULL, 'VERIFIED', 5.0, 1, NOW(), NOW())
        ON DUPLICATE KEY UPDATE `FirstName` = VALUES(`FirstName`), `LastName` = VALUES(`LastName`), `StudentNumber` = VALUES(`StudentNumber`)");

    // Seed Real Live Equipment for Romeo (Lender)
    $stmtInv = $pdo->prepare("INSERT INTO `rental_inventory` 
        (`id`, `name`, `category`, `material_tag`, `price_per_day`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `image_url`, `rating`, `reviews_count`, `description`, `min_rental_days`, `is_featured`, `owner_name`, `owner_contact`, `item_condition`, `location`) 
        VALUES (1, 'Sony Alpha A7 IV 4K Camera Rig', 'Cameras', 'Premium', 1200.00, 2, 1, 1, 0, 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80', 5.0, 14, 'Professional full-frame hybrid mirrorless camera with 24-70mm GM lens, cage rig, and dual batteries. Listed for rent by Romeo Paolo Tolentino.', 1, 1, 'Romeo Paolo Tolentino', '09668257301', 'Like New', 'San Pablo City, Laguna')
        ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);");
    $stmtInv->execute();

    // Seed Real Live Order placed by Pogilameg (Renter)
    $stmtOrd = $pdo->prepare("INSERT INTO `rental_orders` 
        (`id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `delivery_option`, `delivery_address`, `rental_start_date`, `rental_days`, `subtotal`, `service_charge`, `delivery_fee`, `discount`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `estimated_arrival`, `assigned_rider_name`, `assigned_rider_phone`, `rider_current_lat`, `rider_current_lng`)
        VALUES (1, '#ORD-1001', 'Pogilameg Tester', 'pogilameg@gmail.com', '09175557788', 'DELIVERY', 'LSPU Main Hall, San Pablo City, Laguna', CURDATE(), 2, 2400.00, 240.00, 150.00, 0.00, 2790.00, 'GCASH', 'PAID', 'ON_THE_WAY', '3:30 PM', 'Juan Dela Cruz', '09187654321', 14.0683, 121.3256)
        ON DUPLICATE KEY UPDATE `order_status` = VALUES(`order_status`);");
    $stmtOrd->execute();

    // Seed Order Item
    $stmtItem = $pdo->prepare("INSERT INTO `rental_order_items` (`order_id`, `product_id`, `product_name`, `price_per_day`, `quantity`, `subtotal`) VALUES (1, 1, 'Sony Alpha A7 IV 4K Camera Rig', 1200.00, 1, 2400.00) ON DUPLICATE KEY UPDATE `product_name` = VALUES(`product_name`);");
    $stmtItem->execute();

    // Seed Support Ticket
    $stmtTkt = $pdo->prepare("INSERT INTO `rental_issues` (`id`, `ticket_number`, `order_code`, `customer_name`, `issue_title`, `description`, `status`, `status_display`, `priority`, `assigned_to`, `created_at`) VALUES (1, '#TKT-0012', '#ORD-1001', 'Pogilameg Tester', 'Delivery Schedule Clarification', 'Requesting arrival before 3:00 PM for the multimedia organization event setup.', 'IN_PROGRESS', 'In Progress', 'MEDIUM', 'Support Team', NOW()) ON DUPLICATE KEY UPDATE `issue_title` = VALUES(`issue_title`);");
    $stmtTkt->execute();

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo json_encode([
        'success' => true,
        'message' => '🧹 Hostinger MySQL Database cleaned successfully! Purged all dummy users, listings, chats, and records. Admin (100) and Romeo (104) preserved!'
    ]);
} catch (Exception $ex) {
    echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
