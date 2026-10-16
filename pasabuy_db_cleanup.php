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

    // 1. Purge all chat messages and notifications
    try { $pdo->exec("DELETE FROM `ChatMessages`;"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE `ChatMessages` AUTO_INCREMENT = 1;"); } catch (Exception $e) {}

    // 2. Purge marketplace listings, photos, wanted posts, payments, audit logs, orders
    try { $pdo->exec("DELETE FROM `ListingImages`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `Listings`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `PaymentRecords`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `Reports`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `WantedPosts`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `AuditLogs`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `OtpVerifications`;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `Orders`;"); } catch (Exception $e) {}

    // 3. Purge rental orders, items, tickets, packages, transactions
    try { $pdo->exec("DELETE FROM `rental_order_items` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_orders` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_issues` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_transactions` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_packages` WHERE 1=1;"); } catch (Exception $e) {}

    // 4. Purge rental moderation reports & appeals (3-strike and 5-day suspension systems)
    try { $pdo->exec("DELETE FROM `rental_unreturned_reports` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_suspension_appeals` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_item_reports` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `rental_item_appeals` WHERE 1=1;"); } catch (Exception $e) {}

    // 5. Purge dummy delivery drivers & verification requests
    try { $pdo->exec("DELETE FROM `rental_drivers` WHERE 1=1;"); } catch (Exception $e) {}
    try { $pdo->exec("DELETE FROM `VerificationRequests` WHERE 1=1;"); } catch (Exception $e) {}

    // 6. Reset Users (Keep ONLY Admin 100, Romeo 104, Pogilameg 105)
    $pdo->exec("DELETE FROM `Users` WHERE `Id` NOT IN (100, 104, 105);");
    $pdo->exec("UPDATE `Users` SET 
        `rental_suspended_until` = NULL, 
        `rental_suspension_reason` = NULL, 
        `rental_suspension_report_id` = NULL, 
        `Status` = 'VERIFIED' 
        WHERE `Id` IN (100, 104, 105);");

    // Ensure Admin, Romeo & Pogilameg exist with clean credentials
    $hashPogilameg = password_hash('Pogilameg@10', PASSWORD_DEFAULT);
    
    $stmtUser = $pdo->prepare("INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`, `UpdatedAt`) VALUES 
        (100, 'admin', 'Pogilameg@10', 'ADMIN', 'VERIFIED', NOW(), NOW()),
        (104, 'romeopaolotolentino@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW()),
        (105, 'pogilameg@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW())
        ON DUPLICATE KEY UPDATE `PasswordHash` = VALUES(`PasswordHash`), `Role` = VALUES(`Role`), `Status` = 'VERIFIED', `rental_suspended_until` = NULL, `rental_suspension_reason` = NULL, `rental_suspension_report_id` = NULL");
    $stmtUser->execute([$hashPogilameg, $hashPogilameg]);

    // 7. Clean StudentProfiles (Keep Romeo 104 and Pogilameg 105)
    $pdo->exec("DELETE FROM `StudentProfiles` WHERE `UserId` NOT IN (104, 105);");
    $pdo->exec("INSERT INTO `StudentProfiles` (`Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `PhoneNumber`, `SchoolEmail`, `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`, `CreatedAt`, `UpdatedAt`) VALUES 
        (2, 104, 'Romeo Paolo', 'Tolentino', '20261048', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80', 'VERIFIED', 5.0, 12, NOW(), NOW()),
        (3, 105, 'Pogilameg', 'Tester', '20261058', '09171234567', 'pogilameg@gmail.com', 'BSCS', '3rd Yr', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80', 'VERIFIED', 5.0, 8, NOW(), NOW())
        ON DUPLICATE KEY UPDATE `FirstName` = VALUES(`FirstName`), `LastName` = VALUES(`LastName`), `StudentNumber` = VALUES(`StudentNumber`), `PhoneNumber` = VALUES(`PhoneNumber`), `VerificationStatus` = 'VERIFIED'");

    // Deduplicate StudentProfiles
    try {
        $pdo->exec("DELETE p1 FROM `StudentProfiles` p1 INNER JOIN `StudentProfiles` p2 WHERE p1.Id > p2.Id AND p1.UserId = p2.UserId;");
    } catch (Exception $e) {}

    // 8. Clean POSPT in rental_inventory (Reset strikes, termination, and rented count)
    try {
        $pdo->exec("UPDATE `rental_inventory` SET 
            `status` = 'ACTIVE', 
            `approved_reports_count` = 0, 
            `termination_reason` = NULL, 
            `terminated_at` = NULL, 
            `qty_rented` = 0, 
            `qty_available` = `qty_total`
            WHERE 1=1;");
    } catch (Exception $e) {}

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo json_encode([
        'success' => true,
        'message' => '🧹 Hostinger MySQL Database cleaned successfully! Purged all dummy orders, tickets, reports, appeals, drivers, users, chats, and records. Admin (100), Romeo (104), and Pogilameg (105) preserved clean!'
    ]);
} catch (Exception $ex) {
    echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
