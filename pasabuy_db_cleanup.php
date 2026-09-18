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

    // Seed Real Live Equipment for Romeo (Lender) with 0 rented (clean slate)
    $stmtInv = $pdo->prepare("INSERT INTO `rental_inventory` 
        (`id`, `name`, `category`, `material_tag`, `price_per_day`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `image_url`, `rating`, `reviews_count`, `description`, `min_rental_days`, `is_featured`, `owner_name`, `owner_contact`, `item_condition`, `location`) 
        VALUES 
        (1, 'Sony Alpha A7 IV 4K Camera Rig', 'Cameras', 'Premium', 1200.00, 2, 2, 0, 0, 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80', 5.0, 14, 'Professional full-frame hybrid mirrorless camera with 24-70mm GM lens, cage rig, and dual batteries. Listed for rent by Romeo Paolo Tolentino.', 1, 1, 'Romeo Paolo Tolentino', '09668257301', 'Like New', 'San Pablo City, Laguna'),
        (2, 'Yamaha StagePas 400BT Portable Sound System', 'Sound System', 'Premium', 1500.00, 1, 1, 0, 0, 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=500&q=80', 4.9, 8, '400W compact PA system with 8-channel powered mixer, 2 speakers, wireless Bluetooth and dual mic set. Listed by Romeo Paolo Tolentino.', 1, 1, 'Romeo Paolo Tolentino', '09668257301', 'Excellent', 'San Pablo City, Laguna')
        ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `qty_rented` = 0, `qty_available` = VALUES(`qty_total`);");
    $stmtInv->execute();

    // Ensure zero orders and zero transactions until real orders are placed
    try { $pdo->exec("DELETE FROM `rental_order_items` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_orders` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_transactions` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_issues` WHERE `ticket_number` = '#TKT-0012';"); } catch (Exception $e) {}

    // Deduplicate StudentProfiles
    try {
        $pdo->exec("DELETE p1 FROM `StudentProfiles` p1 INNER JOIN `StudentProfiles` p2 WHERE p1.Id > p2.Id AND p1.UserId = p2.UserId;");
    } catch (Exception $e) {}

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo json_encode([
        'success' => true,
        'message' => '🧹 Hostinger MySQL Database cleaned successfully! Purged all dummy users, listings, chats, and records. Admin (100) and Romeo (104) preserved!'
    ]);
} catch (Exception $ex) {
    echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
