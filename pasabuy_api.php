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
// 1. GET ALL LISTINGS (Home / Explore)
// ---------------------------------------------------------
if ($action === 'listings' || $action === 'get_listings') {
    $sql = "SELECT l.*, sp.FirstName, sp.LastName, sp.SchoolEmail 
            FROM Listings l 
            LEFT JOIN StudentProfiles sp ON l.SellerId = sp.UserId 
            WHERE l.Status = 'ACTIVE' 
            ORDER BY l.CreatedAt DESC";
    $stmt = $db->query($sql);
    $listings = $stmt->fetchAll();

    // Fetch images for each listing
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

    // Record PayMongo ₱5.00 posting fee
    $payStmt = $db->prepare("INSERT INTO PaymentRecords (UserId, ListingId, Amount, PaymentMethod, TransactionId, Status, CreatedAt) VALUES (?, ?, 5.00, 'GCash / PayMongo', ?, 'PAID', NOW())");
    $payStmt->execute([$sellerId, $listingId, 'PM-' . time() . '-' . random_int(1000, 9999)]);

    echo json_encode(['success' => true, 'message' => 'Listing published successfully!', 'id' => $listingId]);
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
