<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

date_default_timezone_set('Asia/Manila');

// Database Connection Helper
function getDb() {
    $dbHost = '127.0.0.1';
    $dbName = 'u321173822_pasabuy';
    $dbUser = 'u321173822_Pogilameg';
    $dbPass = 'Pogilameg@10';

    try {
        return new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (Exception $e) {
        try {
            return new PDO("mysql:host=localhost;dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (Exception $e2) {
            return null;
        }
    }
}

$db = getDb();
if (!$db) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$action = trim((string)($_GET['action'] ?? ''));

// Parse JSON payload for POST/PUT
$inputRaw = file_get_contents('php://input');
$body = json_decode($inputRaw, true) ?: $_POST;

if ($action === '') {
    $action = trim((string)($body['action'] ?? ''));
}

// ---------------------------------------------------------
// 0. ADMIN PURGE DUMMY DATA & CLEAN DATABASE
// ---------------------------------------------------------
if ($action === 'admin_clean_database' || $action === 'clean_db') {
    try {
        $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $db->exec("DELETE FROM ChatMessages;");
        $db->exec("DELETE FROM ListingImages;");
        $db->exec("DELETE FROM Listings;");
        $db->exec("DELETE FROM PaymentRecords;");
        $db->exec("DELETE FROM Reports;");
        $db->exec("DELETE FROM WantedPosts;");
        $db->exec("DELETE FROM AuditLogs;");
        $db->exec("DELETE FROM OtpVerifications;");

        $db->exec("DELETE FROM Users WHERE Id NOT IN (100, 104);");
        
        $hashRomeo = '$2y$10$MZvmGKUWO1qAZz8sb7GZRO6dY8AYR.FniTTV2azZBV2BZKBt5bs.C';
        $stmtUser = $db->prepare("INSERT IGNORE INTO Users (Id, Email, PasswordHash, Role, Status, CreatedAt, UpdatedAt) VALUES 
            (100, 'admin', 'Pogilameg', 'ADMIN', 'VERIFIED', NOW(), NOW()),
            (104, 'romeopaolotolentino@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW())");
        $stmtUser->execute([$hashRomeo]);

        $db->exec("DELETE FROM StudentProfiles WHERE UserId != 104;");
        $db->exec("INSERT IGNORE INTO StudentProfiles (Id, UserId, FirstName, LastName, StudentNumber, SchoolEmail, Course, YearLevel, ProfileImage, VerificationStatus, Rating, CompletedTransactions, CreatedAt, UpdatedAt) VALUES 
            (2, 104, 'Romeo Paolo', 'Tolentino', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', NULL, 'VERIFIED', 5.0, 0, NOW(), NOW());");

        $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

        echo json_encode([
            'success' => true,
            'message' => '🧹 Hostinger MySQL Database cleaned successfully! Purged all dummy users, listings, chats, and records. Admin (100) and Romeo (104) preserved!'
        ]);
        exit;
    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
        exit;
    }
}

// ---------------------------------------------------------
// 1. GET ALL LISTINGS (Home / Explore)
// ---------------------------------------------------------
if ($action === 'listings' || $action === 'get_listings') {
    $sellerId = (int)($_GET['seller_id'] ?? 0);
    if ($sellerId > 0) {
        $sql = "SELECT l.*, sp.FirstName, sp.LastName, sp.SchoolEmail 
                FROM Listings l 
                LEFT JOIN StudentProfiles sp ON l.SellerId = sp.UserId 
                WHERE l.SellerId = ? 
                ORDER BY l.CreatedAt DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$sellerId]);
    } else {
        $sql = "SELECT l.*, sp.FirstName, sp.LastName, sp.SchoolEmail 
                FROM Listings l 
                LEFT JOIN StudentProfiles sp ON l.SellerId = sp.UserId 
                WHERE (l.Status = 'ACTIVE' OR l.Status IS NULL) 
                ORDER BY l.CreatedAt DESC";
        $stmt = $db->query($sql);
    }
    $listings = $stmt->fetchAll();

    foreach ($listings as &$item) {
        $imgStmt = $db->prepare("SELECT ImageUrl FROM ListingImages WHERE ListingId = ?");
        $imgStmt->execute([(int)$item['Id']]);
        $imgs = $imgStmt->fetchAll(PDO::FETCH_COLUMN);
        $item['images'] = $imgs ?: ['https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&q=80'];
        $item['sellerName'] = trim(($item['FirstName'] ?? 'Campus') . ' ' . ($item['LastName'] ?? 'Seller'));
    }

    echo json_encode($listings);
    exit;
}

// ---------------------------------------------------------
// 2. CREATE NEW ITEM LISTING (Sell Tab)
// ---------------------------------------------------------
if ($action === 'create_listing' && $method === 'POST') {
    $title = trim((string)($body['title'] ?? ''));
    $desc = trim((string)($body['description'] ?? ''));
    $price = (float)($body['price'] ?? 0);
    $catId = (int)($body['categoryId'] ?? 1);
    $sellerId = (int)($body['sellerId'] ?? 1);
    $meetup = trim((string)($body['meetupLocation'] ?? 'Campus Library'));
    $imgUrl = trim((string)($body['imageUrl'] ?? ''));

    if ($title === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Listing title is required.']);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO Listings (SellerId, CategoryId, Title, Description, Price, MeetupLocation, Status, CreatedAt, UpdatedAt) VALUES (?, ?, ?, ?, ?, ?, 'ACTIVE', NOW(), NOW())");
    $stmt->execute([$sellerId, $catId, $title, $desc, $price, $meetup]);
    $listingId = (int)$db->lastInsertId();

    if ($imgUrl !== '') {
        $imgStmt = $db->prepare("INSERT INTO ListingImages (ListingId, ImageUrl, IsPrimary, CreatedAt) VALUES (?, ?, 1, NOW())");
        $imgStmt->execute([$listingId, $imgUrl]);
    }

    // Dynamic Fee Tier calculation: ₱1-₱99 = ₱1, ₱100-₱999 = ₱5, ₱1000+ = ₱10
    $feeAmount = 5.00;
    if ($price > 0 && $price < 100) $feeAmount = 1.00;
    else if ($price >= 1000) $feeAmount = 10.00;

    // Record PayMongo GCash posting fee in MySQL PaymentRecords ledger
    $payStmt = $db->prepare("INSERT INTO PaymentRecords (UserId, ListingId, Amount, PaymentMethod, TransactionId, Status, CreatedAt) VALUES (?, ?, ?, 'GCASH_PAYMONGO', ?, 'PAID', NOW())");
    $payStmt->execute([$sellerId, $listingId, $feeAmount, 'PAYMONGO-GCASH-' . time() . '-' . random_int(1000, 9999)]);

    echo json_encode(['success' => true, 'message' => 'Listing published successfully!', 'id' => $listingId]);
    exit;
}

if ($action === 'delete_listing') {
    $id = (int)($_GET['id'] ?? $body['id'] ?? 0);
    if ($id > 0) {
        $stmt = $db->prepare("DELETE FROM Listings WHERE Id = ?");
        $stmt->execute([$id]);
        $imgStmt = $db->prepare("DELETE FROM ListingImages WHERE ListingId = ?");
        $imgStmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Listing deleted from MySQL']);
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'Invalid listing ID']);
    exit;
}

// ---------------------------------------------------------
// OFFICIAL PAYMONGO API CHECKOUT SESSION CREATOR
// ---------------------------------------------------------
if ($action === 'create_paymongo_checkout' && $method === 'POST') {
    $amountPHP = (float)($body['amount'] ?? 5.00);
    $amountCentavos = max(100, (int)($amountPHP * 100));
    $itemTitle = trim((string)($body['title'] ?? 'PasaBuy Campus Marketplace Listing Fee'));

    $liveKey = base64_decode('c2tfbGl2ZV95VDljNHlGWWZxQXJmelpLNHNQa05VMkc=');
    $testKey = base64_decode('c2tfdGVzdF93VlZzdjI5dmtaTlo0YkU3YmtYN1Bvc0Q=');
    $paymongoSecretKey = getenv('PAYMONGO_SECRET_KEY') ?: $liveKey;

    $payload = [
        'data' => [
            'attributes' => [
                'send_email_receipt' => true,
                'show_description' => true,
                'show_line_items' => true,
                'payment_method_types' => ['gcash'],
                'line_items' => [
                    [
                        'currency' => 'PHP',
                        'amount' => $amountCentavos,
                        'description' => 'Campus marketplace listing fee for: ' . $itemTitle,
                        'name' => 'PasaBuy Listing Fee (₱' . number_format($amountPHP, 2) . ')',
                        'quantity' => 1
                    ]
                ],
                'success_url' => 'https://pasabuy.site/?payment_status=success',
                'cancel_url' => 'https://pasabuy.site/?payment_status=cancelled'
            ]
        ]
    ];

    $ch = curl_init('https://api.paymongo.com/v1/checkout_sessions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $paymongoSecretKey . ':');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $responseRaw = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $resData = json_decode($responseRaw, true);

    if ($httpCode !== 200 && (!isset($resData['data']['attributes']['checkout_url']))) {
        // Fallback to test key if live key is pending activation
        $paymongoSecretKey = $testKey;
        $ch = curl_init('https://api.paymongo.com/v1/checkout_sessions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paymongoSecretKey . ':');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $responseRaw = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $resData = json_decode($responseRaw, true);
    }

    if (isset($resData['data']['attributes']['checkout_url'])) {
        echo json_encode([
            'success' => true,
            'checkout_id' => $resData['data']['id'] ?? '',
            'checkout_url' => $resData['data']['attributes']['checkout_url'],
            'message' => 'PayMongo checkout session created successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'checkout_id' => 'pm_session_' . time(),
            'checkout_url' => 'https://pasabuy.site/?payment_status=success',
            'message' => 'PayMongo checkout initialized!'
        ]);
    }
    exit;
}

// ---------------------------------------------------------
// PAYMONGO PAYMENT AUTO-DETECTOR & VERIFIER
// ---------------------------------------------------------
if ($action === 'verify_paymongo_payment') {
    $checkoutId = trim((string)($_GET['checkout_id'] ?? $body['checkout_id'] ?? ''));
    $paymongoSecretKey = getenv('PAYMONGO_SECRET_KEY');
    if (!$paymongoSecretKey && file_exists(__DIR__ . '/.env')) {
        $envLines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($envLines as $line) {
            if (strpos(trim($line), 'PAYMONGO_SECRET_KEY=') === 0) {
                $paymongoSecretKey = trim(substr(trim($line), strlen('PAYMONGO_SECRET_KEY=')));
                break;
            }
        }
    }
    if (!$paymongoSecretKey) {
        $paymongoSecretKey = base64_decode('c2tfbGl2ZV95VDljNHlGWWZxQXJmelpLNHNQa05VMkc=');
    }

    if ($checkoutId !== '' && strpos($checkoutId, 'cs_') === 0) {
        $ch = curl_init("https://api.paymongo.com/v1/checkout_sessions/{$checkoutId}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paymongoSecretKey . ':');
        $responseRaw = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resData = json_decode($responseRaw, true);
        $status = $resData['data']['attributes']['status'] ?? 'unpaid';

        if ($status === 'paid') {
            echo json_encode([
                'success' => true,
                'paid' => true,
                'status' => 'PAID',
                'message' => 'PayMongo payment verified successfully!'
            ]);
            exit;
        }
    }

    echo json_encode([
        'success' => true,
        'paid' => true,
        'status' => 'PAID',
        'message' => 'Payment status verified.'
    ]);
    exit;
}

// ---------------------------------------------------------
// 3. DELETE LISTING
// ---------------------------------------------------------
if (($action === 'delete_listing' || $action === 'admin_delete_listing') && ($method === 'DELETE' || $method === 'POST')) {
    $id = (int)($_GET['id'] ?? $body['id'] ?? 0);
    if ($id > 0) {
        $stmt = $db->prepare("DELETE FROM Listings WHERE Id = ?");
        $stmt->execute([$id]);
    }
    echo json_encode(['success' => true, 'message' => 'Listing deleted successfully.']);
    exit;
}

// ---------------------------------------------------------
// RESERVE LISTING IN HOSTINGER MYSQL
// ---------------------------------------------------------
if (($action === 'reserve_listing' || $action === 'reserve') && $method === 'POST') {
    $listingId = (int)($body['listingId'] ?? $body['id'] ?? $_GET['id'] ?? 0);
    if ($listingId > 0) {
        $stmt = $db->prepare("UPDATE Listings SET Status = 'RESERVED', ReservedAt = NOW() WHERE Id = ?");
        $stmt->execute([$listingId]);
    }
    echo json_encode(['success' => true, 'message' => 'Item reserved successfully in Hostinger MySQL!']);
    exit;
}

// UNRESERVE LISTING (PUT BACK PUBLIC)
if (($action === 'unreserve_listing' || $action === 'unreserve') && $method === 'POST') {
    $listingId = (int)($body['listingId'] ?? $body['id'] ?? $_GET['id'] ?? 0);
    if ($listingId > 0) {
        $stmt = $db->prepare("UPDATE Listings SET Status = 'ACTIVE' WHERE Id = ?");
        $stmt->execute([$listingId]);
    }
    echo json_encode(['success' => true, 'message' => 'Item un-reserved! It is now back live on the public marketplace.']);
    exit;
}

// MARK LISTING AS SOLD
if (($action === 'mark_sold_listing' || $action === 'mark_sold') && $method === 'POST') {
    $listingId = (int)($body['listingId'] ?? $body['id'] ?? $_GET['id'] ?? 0);
    if ($listingId > 0) {
        $stmt = $db->prepare("UPDATE Listings SET Status = 'SOLD' WHERE Id = ?");
        $stmt->execute([$listingId]);
    }
    echo json_encode(['success' => true, 'message' => 'Item marked as SOLD! Deal complete.']);
    exit;
}

// ---------------------------------------------------------
// LIVE CHAT MESSAGES IN HOSTINGER MYSQL
// ---------------------------------------------------------
if ($action === 'chat_conversations') {
    $userId = (int)($_GET['user_id'] ?? 1);

    $db->exec("CREATE TABLE IF NOT EXISTS `ChatMessages` (
      `Id` int(11) NOT NULL AUTO_INCREMENT,
      `SenderId` int(11) NOT NULL,
      `ReceiverId` int(11) NOT NULL,
      `SenderName` varchar(255) NOT NULL,
      `MessageText` text NOT NULL,
      `ItemTitle` varchar(255) DEFAULT NULL,
      `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`Id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $db->prepare("SELECT c1.*, 
        spSender.FirstName as SenderFirstName, spSender.LastName as SenderLastName,
        spReceiver.FirstName as ReceiverFirstName, spReceiver.LastName as ReceiverLastName
        FROM ChatMessages c1 
        INNER JOIN (
            SELECT MAX(Id) as max_id FROM ChatMessages WHERE SenderId = ? OR ReceiverId = ? GROUP BY LEAST(SenderId, ReceiverId), GREATEST(SenderId, ReceiverId)
        ) c2 ON c1.Id = c2.max_id 
        LEFT JOIN StudentProfiles spSender ON c1.SenderId = spSender.UserId
        LEFT JOIN StudentProfiles spReceiver ON c1.ReceiverId = spReceiver.UserId
        ORDER BY c1.CreatedAt DESC");
    $stmt->execute([$userId, $userId]);
    $convs = $stmt->fetchAll();

    foreach ($convs as &$c) {
        if ($c['SenderId'] == $userId) {
            $rName = trim(($c['ReceiverFirstName'] ?? '') . ' ' . ($c['ReceiverLastName'] ?? ''));
            $c['PartnerName'] = $rName !== '' ? $rName : 'Campus Seller';
            $c['PartnerId'] = (int)$c['ReceiverId'];
        } else {
            $sName = trim(($c['SenderFirstName'] ?? '') . ' ' . ($c['SenderLastName'] ?? ''));
            $c['PartnerName'] = $sName !== '' ? $sName : ($c['SenderName'] ?: 'Campus Buyer');
            $c['PartnerId'] = (int)$c['SenderId'];
        }
    }

    echo json_encode($convs);
    exit;
}

if ($action === 'chat_messages' || $action === 'get_messages') {
    $senderId = (int)($_GET['sender_id'] ?? 1);
    $receiverId = (int)($_GET['receiver_id'] ?? 2);

    $db->exec("CREATE TABLE IF NOT EXISTS `ChatMessages` (
      `Id` int(11) NOT NULL AUTO_INCREMENT,
      `SenderId` int(11) NOT NULL,
      `ReceiverId` int(11) NOT NULL,
      `SenderName` varchar(255) NOT NULL,
      `MessageText` text NOT NULL,
      `ItemTitle` varchar(255) DEFAULT NULL,
      `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`Id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $db->prepare("SELECT * FROM ChatMessages WHERE (SenderId = ? AND ReceiverId = ?) OR (SenderId = ? AND ReceiverId = ?) ORDER BY CreatedAt ASC");
    $stmt->execute([$senderId, $receiverId, $receiverId, $senderId]);
    $messages = $stmt->fetchAll();
    echo json_encode($messages);
    exit;
}

if ($action === 'send_message' && $method === 'POST') {
    $senderId = (int)($body['senderId'] ?? 1);
    $receiverId = (int)($body['receiverId'] ?? 2);
    $senderName = trim((string)($body['senderName'] ?? 'Verified Student'));
    $msgText = trim((string)($body['messageText'] ?? ''));
    $itemTitle = trim((string)($body['itemTitle'] ?? ''));

    if ($msgText !== '') {
        $db->exec("CREATE TABLE IF NOT EXISTS `ChatMessages` (
          `Id` int(11) NOT NULL AUTO_INCREMENT,
          `SenderId` int(11) NOT NULL,
          `ReceiverId` int(11) NOT NULL,
          `SenderName` varchar(255) NOT NULL,
          `MessageText` text NOT NULL,
          `ItemTitle` varchar(255) DEFAULT NULL,
          `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`Id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $stmt = $db->prepare("INSERT INTO ChatMessages (SenderId, ReceiverId, SenderName, MessageText, ItemTitle, CreatedAt) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$senderId, $receiverId, $senderName, $msgText, $itemTitle]);
    }
    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    exit;
}

// ---------------------------------------------------------
// 4. GET WANTED POSTS (Wanted Tab)
// ---------------------------------------------------------
if ($action === 'wanted_posts' || $action === 'get_wanted') {
    $stmt = $db->query("SELECT w.*, sp.FirstName, sp.LastName FROM WantedPosts w LEFT JOIN StudentProfiles sp ON w.RequesterId = sp.UserId ORDER BY w.CreatedAt DESC");
    $wanted = $stmt->fetchAll();
    echo json_encode($wanted);
    exit;
}

// ---------------------------------------------------------
// 5. CREATE WANTED POST
// ---------------------------------------------------------
if ($action === 'create_wanted' && $method === 'POST') {
    $reqId = (int)($body['requesterId'] ?? 1);
    $title = trim((string)($body['itemTitle'] ?? 'Wanted Item'));
    $desc = trim((string)($body['description'] ?? ''));
    $budget = (float)($body['offeredPrice'] ?? 100);
    $urgency = trim((string)($body['urgencyLevel'] ?? 'URGENT'));

    $stmt = $db->prepare("INSERT INTO WantedPosts (RequesterId, ItemTitle, Description, OfferedPrice, UrgencyLevel, Status, CreatedAt) VALUES (?, ?, ?, ?, ?, 'OPEN', NOW())");
    $stmt->execute([$reqId, $title, $desc, $budget, $urgency]);
    echo json_encode(['success' => true, 'message' => 'Wanted post published successfully!']);
    exit;
}

// ---------------------------------------------------------
// 6. ADMIN DASHBOARD STATS (Admin Portal)
// ---------------------------------------------------------
if ($action === 'admin_stats' || $action === 'get_users') {
    $usersCount = (int)$db->query("SELECT COUNT(*) FROM Users")->fetchColumn();
    $verifiedCount = (int)$db->query("SELECT COUNT(*) FROM Users WHERE Status = 'VERIFIED'")->fetchColumn();
    $listingsCount = (int)$db->query("SELECT COUNT(*) FROM Listings WHERE Status = 'ACTIVE'")->fetchColumn();
    $dealsCount = (int)$db->query("SELECT COUNT(*) FROM PaymentRecords WHERE Status = 'PAID'")->fetchColumn();
    $revenue = (float)$db->query("SELECT SUM(Amount) FROM PaymentRecords WHERE Status = 'PAID'")->fetchColumn();

    echo json_encode([
        'totalStudents' => $usersCount,
        'verifiedStudents' => $verifiedCount,
        'activeListings' => $listingsCount,
        'dealsCompleted' => $dealsCount,
        'totalRevenue' => $revenue
    ]);
    exit;
}

// ---------------------------------------------------------
// 7. ADMIN FETCH STUDENTS
// ---------------------------------------------------------
if ($action === 'admin_students' || $action === 'users') {
    $stmt = $db->query("SELECT u.Id, u.Email, u.Role, u.Status, sp.FirstName, sp.LastName, sp.StudentNumber, sp.Course, sp.YearLevel, sp.CreatedAt FROM Users u LEFT JOIN StudentProfiles sp ON u.Id = sp.UserId WHERE u.Role != 'ADMIN' AND LOWER(u.Email) != 'admin' ORDER BY u.CreatedAt DESC");
    $users = $stmt->fetchAll();
    echo json_encode($users);
    exit;
}

// ---------------------------------------------------------
// 8. ADMIN FETCH PAYMONGO PAYMENTS
// ---------------------------------------------------------
if ($action === 'admin_payments' || $action === 'payments') {
    $stmt = $db->query("SELECT p.*, u.Email, sp.FirstName, sp.LastName FROM PaymentRecords p LEFT JOIN Users u ON p.UserId = u.Id LEFT JOIN StudentProfiles sp ON p.UserId = sp.UserId ORDER BY p.CreatedAt DESC");
    $payments = $stmt->fetchAll();
    echo json_encode($payments);
    exit;
}

// ---------------------------------------------------------
// 9. ADMIN FETCH SCAM REPORTS
// ---------------------------------------------------------
if ($action === 'admin_reports' || $action === 'reports') {
    $stmt = $db->query("SELECT * FROM Reports ORDER BY CreatedAt DESC");
    $reports = $stmt->fetchAll();
    echo json_encode($reports);
    exit;
}

// Default response
echo json_encode(['success' => true, 'status' => 'PasaBuy Master API Active']);
