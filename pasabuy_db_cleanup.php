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

    // Clean Users (Keep Admin 100 and Romeo 104 only)
    $pdo->exec("DELETE FROM Users WHERE Id NOT IN (100, 104);");
    
    // Ensure Admin & Romeo exist
    $pdo->exec("INSERT IGNORE INTO Users (Id, Email, PasswordHash, Role, Status, CreatedAt, UpdatedAt) VALUES 
        (100, 'admin', 'Pogilameg', 'ADMIN', 'VERIFIED', NOW(), NOW()),
        (104, 'romeopaolotolentino@gmail.com', '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C', 'STUDENT', 'VERIFIED', NOW(), NOW());");

    // Clean StudentProfiles (Keep Romeo 104 only)
    $pdo->exec("DELETE FROM StudentProfiles WHERE UserId != 104;");
    $pdo->exec("INSERT IGNORE INTO StudentProfiles (Id, UserId, FirstName, LastName, StudentNumber, SchoolEmail, Course, YearLevel, VerificationStatus, Rating, CompletedTransactions, CreatedAt, UpdatedAt) VALUES 
        (2, 104, 'Romeo Paolo', 'Tolentino', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', 'VERIFIED', 5.0, 0, NOW(), NOW());");

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo json_encode([
        'success' => true,
        'message' => '🧹 Hostinger MySQL Database cleaned successfully! Purged all dummy users, listings, chats, and records. Admin (100) and Romeo (104) preserved!'
    ]);
} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
}
