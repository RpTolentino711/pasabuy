<?php
/**
 * RentEase Admin Portal Backend API
 * Full REST engine powering all 11 Admin UI modules with live MySQL database connection.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Manila');

// ----------------------------------------------------------
// DATABASE CONNECTION HELPER
// ----------------------------------------------------------
function getAdminDb() {
    $dbName = 'u321173822_pasabuy';
    $dbUser = 'u321173822_Pogilameg';
    $dbPass = 'Pogilameg@10';

    $pdoOpts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2
    ];

    // 1. Hostinger socket
    try {
        return new PDO("mysql:host=localhost;dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, $pdoOpts);
    } catch (Exception $e1) {
        // 2. 127.0.0.1 TCP Hostinger
        try {
            return new PDO("mysql:host=127.0.0.1;dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, $pdoOpts);
        } catch (Exception $e2) {
            // 3. Local pasabuy database
            try {
                return new PDO("mysql:host=127.0.0.1;dbname=pasabuy;charset=utf8mb4", "root", "", $pdoOpts);
            } catch (Exception $e3) {
                return null;
            }
        }
    }
}

$db = getAdminDb();

// ----------------------------------------------------------
// DATABASE SCHEMA & TESTER ACCOUNTS INITIALIZER
// ----------------------------------------------------------
if ($db) {
    // 1. Settings table
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_settings` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `setting_key` VARCHAR(100) UNIQUE NOT NULL,
            `setting_value` TEXT,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Seed default rates if empty
        $cnt = $db->query("SELECT COUNT(*) FROM `rental_settings`")->fetchColumn();
        if ($cnt == 0) {
            $defaultSettings = [
                'event_setup_fee' => '500.00',
                'delivery_fee_per_km' => '50.00',
                'service_charge_rate' => '10',
                'tax_rate' => '12',
                'min_order_delivery' => '1500.00',
                'auto_calculate_charges' => '1',
                'business_name' => 'RentEase Equipment Rentals',
                'business_email' => 'support@rentease.com',
                'business_phone' => '0917 123 4567',
                'business_address' => 'Mataasnakahoy, Batangas / San Pablo, Laguna',
                'auto_backup' => '1',
                'email_notifications' => '1',
                'sms_notifications' => '0',
                'maintenance_mode' => '0'
            ];
            $stmtSet = $db->prepare("INSERT INTO `rental_settings` (`setting_key`, `setting_value`) VALUES (?, ?)");
            foreach ($defaultSettings as $k => $v) {
                $stmtSet->execute([$k, $v]);
            }
        }
    } catch (Exception $e) {}

    // Ensure POSPT is owned by Pogilameg Tester and marked as featured
    // Moderation and 3-strike schema migrations
    try {
        $db->exec("ALTER TABLE `rental_inventory` ADD COLUMN `status` VARCHAR(50) DEFAULT 'ACTIVE'");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE `rental_inventory` ADD COLUMN `approved_reports_count` INT DEFAULT 0");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE `rental_inventory` ADD COLUMN `termination_reason` TEXT DEFAULT NULL");
    } catch (Exception $e) {}
    try {
        $db->exec("ALTER TABLE `rental_inventory` ADD COLUMN `terminated_at` DATETIME DEFAULT NULL");
    } catch (Exception $e) {}

    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_item_reports` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `item_id` INT NOT NULL,
            `item_name` VARCHAR(255) NOT NULL,
            `owner_id` INT NOT NULL,
            `owner_name` VARCHAR(150) NOT NULL,
            `reporter_id` INT NOT NULL,
            `reporter_name` VARCHAR(150) NOT NULL,
            `reason` VARCHAR(255) NOT NULL,
            `details` TEXT NOT NULL,
            `evidence_photo` LONGTEXT DEFAULT NULL,
            `status` ENUM('PENDING', 'APPROVED', 'DISMISSED') DEFAULT 'PENDING',
            `admin_notes` TEXT DEFAULT NULL,
            `reviewed_at` DATETIME DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_item_appeals` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `item_id` INT NOT NULL,
            `item_name` VARCHAR(255) NOT NULL,
            `owner_id` INT NOT NULL,
            `owner_name` VARCHAR(150) NOT NULL,
            `owner_email` VARCHAR(150) DEFAULT NULL,
            `appeal_reason` TEXT NOT NULL,
            `evidence_photo` LONGTEXT DEFAULT NULL,
            `status` ENUM('PENDING', 'ACCEPTED', 'REJECTED') DEFAULT 'PENDING',
            `admin_decision_notes` TEXT DEFAULT NULL,
            `reviewed_at` DATETIME DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    // Auto-migrate rental timer, unreturned reports, and 5-day suspension system
    try { $db->exec("ALTER TABLE `Users` ADD COLUMN `rental_suspended_until` DATETIME DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `Users` ADD COLUMN `rental_suspension_reason` TEXT DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `Users` ADD COLUMN `rental_suspension_report_id` INT DEFAULT NULL"); } catch (Exception $e) {}

    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `owner_id` INT DEFAULT 104"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `renter_id` INT DEFAULT 105"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `item_id` INT DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `item_name` VARCHAR(255) DEFAULT 'Campus Equipment'"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `rental_timer_start` DATETIME DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `rental_timer_end` DATETIME DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `timer_status` VARCHAR(50) DEFAULT 'NOT_STARTED'"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `owner_agreed` TINYINT(1) DEFAULT 0"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `owner_agreed_at` DATETIME DEFAULT NULL"); } catch (Exception $e) {}
    try { $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `unreturned_reported` TINYINT(1) DEFAULT 0"); } catch (Exception $e) {}

    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_unreturned_reports` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `order_code` VARCHAR(50) NOT NULL,
            `item_id` INT DEFAULT NULL,
            `item_name` VARCHAR(255) NOT NULL,
            `owner_id` INT NOT NULL,
            `owner_name` VARCHAR(150) NOT NULL,
            `owner_email` VARCHAR(150) NOT NULL,
            `renter_id` INT NOT NULL,
            `renter_name` VARCHAR(150) NOT NULL,
            `renter_email` VARCHAR(150) NOT NULL,
            `reason` VARCHAR(255) NOT NULL DEFAULT 'Item not returned after rental period',
            `details` TEXT DEFAULT NULL,
            `photo_url` LONGTEXT DEFAULT NULL,
            `status` ENUM('PENDING', 'APPROVED', 'DISMISSED') DEFAULT 'PENDING',
            `admin_notes` TEXT DEFAULT NULL,
            `suspension_days` INT DEFAULT 5,
            `suspended_until` DATETIME DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `reviewed_at` DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_suspension_appeals` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `report_id` INT DEFAULT NULL,
            `user_id` INT NOT NULL,
            `user_email` VARCHAR(150) NOT NULL,
            `user_name` VARCHAR(150) NOT NULL,
            `appeal_reason` TEXT NOT NULL,
            `photo_url` LONGTEXT DEFAULT NULL,
            `status` ENUM('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'PENDING',
            `admin_decision_notes` TEXT DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `reviewed_at` DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    // 2. Transactions table
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_transactions` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `transaction_code` VARCHAR(50) NOT NULL,
            `order_code` VARCHAR(50) DEFAULT NULL,
            `customer_name` VARCHAR(150) NOT NULL,
            `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            `type` ENUM('PAYMENT', 'REFUND', 'SERVICE_CHARGE', 'DEPOSIT') NOT NULL DEFAULT 'PAYMENT',
            `status` ENUM('SUCCESSFUL', 'PROCESSED', 'PENDING', 'FAILED') NOT NULL DEFAULT 'SUCCESSFUL',
            `payment_channel` VARCHAR(50) DEFAULT 'GCash',
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    // 2b. Registered Delivery Drivers / Fleet table
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `rental_drivers` (
            `id` INT PRIMARY KEY AUTO_INCREMENT,
            `name` VARCHAR(150) NOT NULL,
            `phone` VARCHAR(50) NOT NULL,
            `vehicle_type` VARCHAR(50) DEFAULT 'Motorcycle',
            `vehicle_model` VARCHAR(100) DEFAULT 'Honda Click 125i',
            `plate_number` VARCHAR(50) DEFAULT '456-XYZ',
            `license_no` VARCHAR(100) DEFAULT 'D02-23-001234',
            `status` ENUM('AVAILABLE', 'BUSY', 'OFFLINE') DEFAULT 'AVAILABLE',
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Drivers table created cleanly with zero dummy data
    } catch (Exception $e) {}

    // 2c. VerificationRequests table
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `VerificationRequests` (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `UserId` INT NOT NULL,
            `Hometown` VARCHAR(255) NULL,
            `HomeAddress` TEXT NULL,
            `PostalCode` VARCHAR(50) NULL,
            `PhoneNumber` VARCHAR(50) NULL,
            `GuardianName` VARCHAR(255) NULL,
            `GuardianPhone` VARCHAR(50) NULL,
            `IdType` VARCHAR(100) NULL,
            `IdNumber` VARCHAR(100) NULL,
            `IdFrontImage` LONGTEXT NULL,
            `Status` VARCHAR(50) DEFAULT 'PENDING',
            `RejectionReason` TEXT NULL,
            `CreatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `UpdatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } catch (Exception $e) {}

    // 2c. Order tracking columns & Issue Step reporting migration
    try {
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `delivery_plate_number` VARCHAR(50) DEFAULT 'MC-8888-JY'");
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `pickup_proof_photo` LONGTEXT DEFAULT NULL");
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `pickup_proof_note` TEXT DEFAULT NULL");
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `pickup_proof_time` DATETIME DEFAULT NULL");
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `renter_received_confirmed` TINYINT(1) DEFAULT 0");
        $db->exec("ALTER TABLE `rental_orders` ADD COLUMN `renter_received_time` DATETIME DEFAULT NULL");
    } catch (Exception $e) {}

    try {
        $db->exec("ALTER TABLE `rental_issues` ADD COLUMN `stage` VARCHAR(100) DEFAULT NULL");
        $db->exec("ALTER TABLE `rental_issues` ADD COLUMN `reported_by_role` VARCHAR(50) DEFAULT 'RENTER'");
        $db->exec("ALTER TABLE `rental_issues` ADD COLUMN `evidence_photo` LONGTEXT DEFAULT NULL");
        $db->exec("ALTER TABLE `rental_issues` ADD COLUMN `priority` ENUM('LOW', 'MEDIUM', 'HIGH', 'CRITICAL') DEFAULT 'MEDIUM'");
        $db->exec("ALTER TABLE `rental_issues` ADD COLUMN `assigned_to` VARCHAR(150) DEFAULT 'Support Team'");
    } catch (Exception $e) {}

    // 3. Ensure 3 test users exist in Users and StudentProfiles
    try {
        $hashPogilameg = password_hash('Pogilameg@10', PASSWORD_DEFAULT);

        // Ensure Admin (100)
        $db->exec("INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) VALUES 
            (100, 'admin', 'Pogilameg@10', 'ADMIN', 'VERIFIED')
            ON DUPLICATE KEY UPDATE `PasswordHash` = 'Pogilameg@10', `Role` = 'ADMIN', `Status` = 'VERIFIED'");

        // Ensure Romeo (104 - Lender / Poster)
        $db->exec("INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) VALUES 
            (104, 'romeopaolotolentino@gmail.com', '{$hashPogilameg}', 'STUDENT', 'VERIFIED')
            ON DUPLICATE KEY UPDATE `PasswordHash` = '{$hashPogilameg}', `Role` = 'STUDENT', `Status` = 'VERIFIED'");

        // Ensure Pogilameg (105 - Renter / Customer)
        $db->exec("INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`) VALUES 
            (105, 'pogilameg@gmail.com', '{$hashPogilameg}', 'STUDENT', 'VERIFIED')
            ON DUPLICATE KEY UPDATE `PasswordHash` = '{$hashPogilameg}', `Role` = 'STUDENT', `Status` = 'VERIFIED'");

        // Ensure StudentProfiles with numeric StudentNumber and PhoneNumber
        $db->exec("INSERT INTO `StudentProfiles` (`UserId`, `FirstName`, `LastName`, `StudentNumber`, `PhoneNumber`, `SchoolEmail`, `Course`, `YearLevel`, `Rating`, `VerificationStatus`) VALUES 
            (104, 'Romeo Paolo', 'Tolentino', '20261048', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', 5.0, 'VERIFIED')
            ON DUPLICATE KEY UPDATE `FirstName` = 'Romeo Paolo', `LastName` = 'Tolentino', `StudentNumber` = IF(`StudentNumber` = '09668257301' OR `StudentNumber` LIKE '%@%', '20261048', `StudentNumber`), `PhoneNumber` = COALESCE(NULLIF(`PhoneNumber`, ''), '09668257301')");

        $db->exec("INSERT INTO `StudentProfiles` (`UserId`, `FirstName`, `LastName`, `StudentNumber`, `PhoneNumber`, `SchoolEmail`, `Course`, `YearLevel`, `Rating`, `VerificationStatus`) VALUES 
            (105, 'Pogilameg', 'Tester', '20261058', '09171234567', 'pogilameg@gmail.com', 'BSIT', '3rd Yr', 5.0, 'VERIFIED')
            ON DUPLICATE KEY UPDATE `FirstName` = 'Pogilameg', `LastName` = 'Tester', `StudentNumber` = IF(`StudentNumber` = 'pogilameg@10' OR `StudentNumber` LIKE '%@%', '20261058', `StudentNumber`), `PhoneNumber` = COALESCE(NULLIF(`PhoneNumber`, ''), '09171234567')");

        // Clean any existing non-numeric student numbers in DB
        $db->exec("UPDATE `StudentProfiles` SET `StudentNumber` = '20261058', `PhoneNumber` = '09171234567' WHERE `UserId` = 105 AND (`StudentNumber` = 'pogilameg@10' OR `StudentNumber` LIKE '%@%');");
        $db->exec("UPDATE `StudentProfiles` SET `StudentNumber` = '20261048', `PhoneNumber` = '09668257301' WHERE `UserId` = 104 AND (`StudentNumber` = '09668257301' OR `StudentNumber` LIKE '%@%');");
        $db->exec("UPDATE `StudentProfiles` SET `StudentNumber` = '2023183099', `PhoneNumber` = '09171234567' WHERE `UserId` = 113 AND (`StudentNumber` = '2023-183099' OR `StudentNumber` LIKE '%-%');");
    } catch (Exception $e) {}

    // Clean slate: do not auto-seed equipment so that when stock is deleted, it remains 0

    // Clear seeded demo orders and transactions so platform starts with zero sales until real orders are placed
    try {
        $db->exec("DELETE FROM `rental_order_items` WHERE `order_id` IN (SELECT id FROM `rental_orders` WHERE `order_code` = '#ORD-1001')");
        $db->exec("DELETE FROM `rental_orders` WHERE `order_code` = '#ORD-1001'");
        $db->exec("DELETE FROM `rental_transactions` WHERE `transaction_code` = '#TRX-8801'");
        $db->exec("DELETE FROM `rental_issues` WHERE `ticket_number` = '#TKT-0012'");
        $db->exec("UPDATE `rental_inventory` SET `qty_rented` = 0, `qty_available` = `qty_total` WHERE `qty_rented` > 0");

        // One-time auto-wipe of demo/legacy stock so that total stock is reset to 0
        $isPurged = $db->query("SELECT `setting_value` FROM `rental_settings` WHERE `setting_key` = 'stock_purged_zero'")->fetchColumn();
        if (!$isPurged) {
            $db->exec("DELETE FROM `rental_order_items` WHERE 1=1;");
            $db->exec("DELETE FROM `rental_inventory` WHERE 1=1;");
            $db->exec("INSERT INTO `rental_settings` (`setting_key`, `setting_value`) VALUES ('stock_purged_zero', '1') ON DUPLICATE KEY UPDATE `setting_value` = '1'");
        }
    } catch (Exception $eClean) {}

    // Deduplicate StudentProfiles so users appear only once
    try {
        $db->exec("DELETE p1 FROM `StudentProfiles` p1 INNER JOIN `StudentProfiles` p2 WHERE p1.Id > p2.Id AND p1.UserId = p2.UserId;");
    } catch (Exception $eDedup) {}
}

$inputRaw = file_get_contents('php://input');
$jsonBody = json_decode($inputRaw, true);
$req = is_array($jsonBody) ? array_merge($_REQUEST, $jsonBody) : $_REQUEST;
$action = trim((string)($req['action'] ?? $_REQUEST['action'] ?? 'get_dashboard'));

// ----------------------------------------------------------
// 1. AUTHENTICATION & SESSION
// ----------------------------------------------------------
if ($action === 'login') {
    $username = trim((string)($req['username'] ?? ''));
    $password = trim((string)($req['password'] ?? ''));

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please enter username and password.']);
        exit;
    }

    // Accept Admin credentials
    $isAdminValid = false;
    if ($username === 'admin' && ($password === 'Pogilameg@10' || $password === 'Pogilameg')) {
        $isAdminValid = true;
    }

    if (!$isAdminValid && $db) {
        $stmt = $db->prepare("SELECT * FROM `Users` WHERE (`Email` = ? OR `Id` = 100) AND `Role` = 'ADMIN' LIMIT 1");
        $stmt->execute([$username]);
        $adminUser = $stmt->fetch();
        if ($adminUser) {
            if ($password === $adminUser['PasswordHash'] || password_verify($password, $adminUser['PasswordHash']) || $password === 'Pogilameg@10' || $password === 'Pogilameg') {
                $isAdminValid = true;
            }
        }
    }

    if ($isAdminValid) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        $_SESSION['admin_name'] = 'System Administrator';
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'username' => 'admin',
                'name' => 'System Administrator',
                'role' => 'ADMIN'
            ]
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid admin credentials. Use admin / Pogilameg@10']);
    exit;
}

if ($action === 'check_auth') {
    $isLogged = !empty($_SESSION['admin_logged_in']);
    echo json_encode([
        'success' => true,
        'authenticated' => $isLogged,
        'user' => $isLogged ? [
            'username' => $_SESSION['admin_username'] ?? 'admin',
            'name' => $_SESSION['admin_name'] ?? 'System Administrator',
            'role' => 'ADMIN'
        ] : null
    ]);
    exit;
}

if ($action === 'logout') {
    $_SESSION['admin_logged_in'] = false;
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
    exit;
}

// ----------------------------------------------------------
// 2. DASHBOARD AGGREGATE STATS (Live Platform Overview)
// ----------------------------------------------------------
if ($action === 'get_dashboard') {
    if (!$db) {
        echo json_encode([
            'success' => true,
            'stats' => [
                'total_revenue' => 246750,
                'total_orders' => 186,
                'active_deliveries' => 8,
                'total_stock' => 248,
                'low_stock_items' => 12,
                'out_of_stock_items' => 3,
                'active_tickets' => 5
            ],
            'recent_orders' => [],
            'recent_tickets' => []
        ]);
        exit;
    }

    $totalRevenue = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0) FROM `rental_orders` WHERE `payment_status` = 'PAID'")->fetchColumn();
    $totalOrders = (int)$db->query("SELECT COUNT(*) FROM `rental_orders`")->fetchColumn();
    $activeDeliveries = (int)$db->query("SELECT COUNT(*) FROM `rental_orders` WHERE `order_status` IN ('CONFIRMED', 'PREPARING', 'MEETUP', 'PROCESSING', 'LOOKING_FOR_RIDER', 'PICKUP', 'ON_THE_WAY')")->fetchColumn();
    
    $totalStock = (int)$db->query("SELECT COALESCE(SUM(qty_total), 0) FROM `rental_inventory`")->fetchColumn();
    $totalProducts = (int)$db->query("SELECT COUNT(*) FROM `rental_inventory`")->fetchColumn();
    $lowStock = (int)$db->query("SELECT COUNT(*) FROM `rental_inventory` WHERE `qty_available` > 0 AND `qty_available` <= 5")->fetchColumn();
    $outOfStock = (int)$db->query("SELECT COUNT(*) FROM `rental_inventory` WHERE `qty_available` = 0")->fetchColumn();
    $stockValue = (float)$db->query("SELECT COALESCE(SUM(price_per_day * qty_total), 0) FROM `rental_inventory`")->fetchColumn();

    $activeTickets = (int)$db->query("SELECT COUNT(*) FROM `rental_issues` WHERE `status` != 'RESOLVED'")->fetchColumn();

    try {
        $db->exec("DELETE FROM `VerificationRequests` WHERE `UserId` NOT IN (SELECT `Id` FROM `Users`)");
        $pendingVerificationsCount = (int)$db->query("SELECT COUNT(*) FROM `VerificationRequests` vr INNER JOIN `Users` u ON vr.UserId = u.Id WHERE vr.Status = 'PENDING' AND u.Role = 'STUDENT'")->fetchColumn();
        $latestPendingVerifications = $db->query("SELECT vr.Id, vr.UserId, vr.IdType, vr.IdNumber, vr.CreatedAt,
                COALESCE(p.FirstName, 'Student') as FirstName,
                COALESCE(p.LastName, 'User') as LastName,
                COALESCE(p.StudentNumber, 'N/A') as StudentNumber,
                COALESCE(p.Course, 'BSIT') as Course,
                COALESCE(p.YearLevel, 'N/A') as YearLevel,
                u.Email
         FROM `VerificationRequests` vr
         JOIN `Users` u ON vr.UserId = u.Id
         LEFT JOIN `StudentProfiles` p ON u.Id = p.UserId
         WHERE vr.Status = 'PENDING' AND u.Role = 'STUDENT'
         ORDER BY vr.CreatedAt DESC
         LIMIT 5")->fetchAll();
    } catch (Exception $e) {}

    $latestCustomerId = 0;
    $newCustomersCount = 0;
    try {
        $latestCustomerId = (int)$db->query("SELECT COALESCE(MAX(Id), 0) FROM `Users` WHERE `Role` = 'STUDENT'")->fetchColumn();
        $newCustomersCount = (int)$db->query("SELECT COUNT(*) FROM `Users` WHERE `Role` = 'STUDENT' AND `CreatedAt` >= (NOW() - INTERVAL 24 HOUR)")->fetchColumn();
    } catch (Exception $e) {}

    $recentOrders = $db->query("SELECT * FROM `rental_orders` ORDER BY `id` DESC LIMIT 6")->fetchAll();
    $recentTickets = $db->query("SELECT * FROM `rental_issues` ORDER BY `id` DESC LIMIT 6")->fetchAll();

    echo json_encode([
        'success' => true,
        'stats' => [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'active_deliveries' => $activeDeliveries,
            'total_stock' => $totalStock,
            'total_products' => $totalProducts,
            'low_stock_items' => $lowStock,
            'out_of_stock_items' => $outOfStock,
            'stock_value' => $stockValue,
            'active_tickets' => $activeTickets,
            'pending_verifications_count' => $pendingVerificationsCount,
            'latest_pending_verifications' => $latestPendingVerifications,
            'latest_customer_id' => $latestCustomerId,
            'new_customers_count' => $newCustomersCount
        ],
        'recent_orders' => $recentOrders,
        'recent_tickets' => $recentTickets
    ]);
    exit;
}

// ----------------------------------------------------------
// 3. PRODUCTS & INVENTORY MODULE
// ----------------------------------------------------------
if ($action === 'get_products' || $action === 'get_inventory') {
    if (!$db) {
        echo json_encode(['success' => true, 'products' => [], 'stats' => ['total_items' => 0, 'low_stock' => 0, 'out_of_stock' => 0, 'stock_value' => 0]]);
        exit;
    }

    $category = trim((string)($req['category'] ?? 'All'));
    $availability = trim((string)($req['availability'] ?? 'All'));
    $search = trim((string)($req['search'] ?? ''));

    $sql = "SELECT * FROM `rental_inventory` WHERE 1=1";
    $params = [];

    if ($category !== 'All' && $category !== '') {
        $sql .= " AND `category` = ?";
        $params[] = $category;
    }
    if ($availability === 'In Stock') {
        $sql .= " AND `qty_available` > 5";
    } elseif ($availability === 'Low Stock') {
        $sql .= " AND `qty_available` > 0 AND `qty_available` <= 5";
    } elseif ($availability === 'Out of Stock') {
        $sql .= " AND `qty_available` = 0";
    }
    if ($search !== '') {
        $sql .= " AND (`name` LIKE ? OR `owner_name` LIKE ? OR `category` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY `id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    // Calculate status for each product
    foreach ($products as &$p) {
        $avail = (int)$p['qty_available'];
        if ($avail <= 0) {
            $p['stock_status'] = 'Out of Stock';
            $p['badge_class'] = 'bg-danger-subtle text-danger';
        } elseif ($avail <= 5) {
            $p['stock_status'] = 'Low Stock';
            $p['badge_class'] = 'bg-warning-subtle text-warning';
        } else {
            $p['stock_status'] = 'In Stock';
            $p['badge_class'] = 'bg-success-subtle text-success';
        }
    }

    $totalItems = (int)$db->query("SELECT COALESCE(SUM(qty_total), 0) FROM `rental_inventory`")->fetchColumn();
    $lowStock = (int)$db->query("SELECT COUNT(*) FROM `rental_inventory` WHERE `qty_available` > 0 AND `qty_available` <= 5")->fetchColumn();
    $outOfStock = (int)$db->query("SELECT COUNT(*) FROM `rental_inventory` WHERE `qty_available` = 0")->fetchColumn();
    $stockValue = (float)$db->query("SELECT COALESCE(SUM(price_per_day * qty_total), 0) FROM `rental_inventory`")->fetchColumn();

    echo json_encode([
        'success' => true,
        'count' => count($products),
        'products' => $products,
        'stats' => [
            'total_items' => $totalItems,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock,
            'stock_value' => $stockValue
        ]
    ]);
    exit;
}

if ($action === 'add_product') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $name = trim((string)($req['name'] ?? ''));
    $category = trim((string)($req['category'] ?? 'General'));
    $material = trim((string)($req['material_tag'] ?? 'Standard'));
    $price = (float)($req['price_per_day'] ?? 0);
    $qty = (int)($req['qty_total'] ?? 1);
    $desc = trim((string)($req['description'] ?? ''));
    $img = trim((string)($req['image_url'] ?? 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80'));
    $owner = trim((string)($req['owner_name'] ?? 'Admin'));
    $contact = trim((string)($req['owner_contact'] ?? '0917 123 4567'));
    $condition = trim((string)($req['item_condition'] ?? 'Good'));
    $location = trim((string)($req['location'] ?? 'San Pablo City, Laguna'));

    if (empty($name) || $price <= 0 || $qty < 1) {
        echo json_encode(['success' => false, 'message' => 'Please provide valid name, price, and quantity.']);
        exit;
    }

    $isPog = (stripos($owner, 'pogilameg') !== false);
    $ownerId = $isPog ? 105 : 104;
    $ownerEmail = $isPog ? 'pogilameg@gmail.com' : 'romeopaolotolentino@gmail.com';
    $ownerContact = $isPog ? '09171234567' : ($contact ?: '09668257301');

    $stmt = $db->prepare("INSERT INTO `rental_inventory` 
        (`name`, `category`, `material_tag`, `price_per_day`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `image_url`, `rating`, `reviews_count`, `description`, `min_rental_days`, `is_featured`, `owner_id`, `owner_name`, `owner_email`, `owner_contact`, `item_condition`, `location`)
        VALUES (?, ?, ?, ?, ?, ?, 0, 0, ?, 5.0, 1, ?, 1, 1, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $category, $material, $price, $qty, $qty, $img, $desc, $ownerId, $owner, $ownerEmail, $ownerContact, $condition, $location]);

    echo json_encode(['success' => true, 'message' => "Product '{$name}' created successfully."]);
    exit;
}

if ($action === 'update_product') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $name = trim((string)($req['name'] ?? ''));
    $category = trim((string)($req['category'] ?? 'General'));
    $price = (float)($req['price_per_day'] ?? 0);
    $qty = (int)($req['qty_total'] ?? 1);
    $qtyAvail = (int)($req['qty_available'] ?? $qty);
    $desc = trim((string)($req['description'] ?? ''));

    $stmt = $db->prepare("UPDATE `rental_inventory` SET `name` = ?, `category` = ?, `price_per_day` = ?, `qty_total` = ?, `qty_available` = ?, `description` = ? WHERE `id` = ?");
    $stmt->execute([$name, $category, $price, $qty, $qtyAvail, $desc, $id]);

    echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
    exit;
}

if ($action === 'delete_product') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $stmt = $db->prepare("DELETE FROM `rental_inventory` WHERE `id` = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Equipment listing taken down successfully by Admin.']);
    exit;
}

if ($action === 'clear_all_inventory' || $action === 'delete_all_stock' || $action === 'wipe_stock') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    try {
        $db->exec("DELETE FROM `rental_order_items` WHERE 1=1;");
        $db->exec("DELETE FROM `rental_inventory` WHERE 1=1;");
        echo json_encode(['success' => true, 'message' => 'All inventory and equipment stock deleted successfully (0 units).']);
        exit;
    } catch (Exception $eClear) {
        echo json_encode(['success' => false, 'message' => $eClear->getMessage()]);
        exit;
    }
}

if ($action === 'adjust_stock') {
    echo json_encode([
        'success' => false, 
        'message' => 'Admins cannot adjust equipment stock. Stock adjustments are restricted to the student lender.'
    ]);
    exit;
}

// ----------------------------------------------------------
// 4. ORDERS MODULE (Incoming, History, Status Update)
// ----------------------------------------------------------
if ($action === 'get_orders') {
    if (!$db) { echo json_encode(['success' => true, 'orders' => []]); exit; }
    $status = trim((string)($req['status'] ?? 'All'));
    $search = trim((string)($req['search'] ?? ''));
    $subtab = trim((string)($req['subtab'] ?? 'incoming'));

    $sql = "SELECT o.*,
                   (SELECT COUNT(*) FROM `rental_issues` WHERE `order_code` = o.order_code AND `status` != 'RESOLVED') as reported_issues_count
            FROM `rental_orders` o WHERE 1=1";
    $params = [];

    if ($status !== 'All' && $status !== '') {
        $sql .= " AND o.`order_status` = ?";
        $params[] = strtoupper($status);
    }
    if ($subtab === 'incoming') {
        $sql .= " AND (o.`order_status` IN ('PENDING', 'CONFIRMED', 'PROCESSING', 'PREPARING', 'MEETUP', 'LOOKING_FOR_RIDER', 'PICKUP', 'ON_THE_WAY') OR o.`order_status` IS NULL)";
    } elseif ($subtab === 'history') {
        $sql .= " AND o.`order_status` IN ('DELIVERED', 'RETURN_DELIVERY', 'RETURNED', 'COMPLETED', 'CANCELLED', 'RIDER_CANCELLED')";
    }

    if ($search !== '') {
        $sql .= " AND (o.`order_code` LIKE ? OR o.`customer_name` LIKE ? OR o.`customer_phone` LIKE ? OR o.`owner_name` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY o.`id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll();

    foreach ($orders as &$ord) {
        $st = strtoupper((string)($ord['order_status'] ?? 'CONFIRMED'));
        switch ($st) {
            case 'CONFIRMED':
                $ord['step_number'] = 1;
                $ord['step_name'] = 'Step 1: Confirmed';
                break;
            case 'PREPARING':
            case 'PROCESSING':
                $ord['step_number'] = 2;
                $ord['step_name'] = 'Step 2: Equipment Prepared';
                break;
            case 'MEETUP':
            case 'LOOKING_FOR_RIDER':
            case 'PICKUP':
            case 'ON_THE_WAY':
                $ord['step_number'] = 3;
                $ord['step_name'] = 'Step 3: Campus Meetup & Coordination';
                break;
            case 'DELIVERED':
                $ord['step_number'] = 4;
                $ord['step_name'] = 'Step 4: Handed Over & Active';
                break;
            case 'RETURN_DELIVERY':
            case 'RETURNED':
                $ord['step_number'] = 5;
                $ord['step_name'] = 'Step 5: Returned & Restocked';
                break;
            case 'RIDER_CANCELLED':
            case 'CANCELLED':
                $ord['step_number'] = 0;
                $ord['step_name'] = 'Cancelled';
                break;
            default:
                $ord['step_number'] = 1;
                $ord['step_name'] = 'Step 1: Confirmed';
        }
    }

    echo json_encode(['success' => true, 'count' => count($orders), 'orders' => $orders]);
    exit;
}

if ($action === 'get_order_details') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $orderCode = trim((string)($req['order_code'] ?? ''));

    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM `rental_orders` WHERE `id` = ? LIMIT 1");
        $stmt->execute([$id]);
    } else {
        $stmt = $db->prepare("SELECT * FROM `rental_orders` WHERE `order_code` = ? LIMIT 1");
        $stmt->execute([$orderCode]);
    }
    $order = $stmt->fetch();
    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }

    // Fetch order items
    $itemsStmt = $db->prepare("SELECT * FROM `rental_order_items` WHERE `order_id` = ?");
    $itemsStmt->execute([$order['id']]);
    $items = $itemsStmt->fetchAll();

    // Fetch all reported issues for this order
    $issuesStmt = $db->prepare("SELECT * FROM `rental_issues` WHERE `order_code` = ? ORDER BY `id` DESC");
    $issuesStmt->execute([$order['order_code']]);
    // Enrich order with step lifecycle info
    $ownerAgreed = (int)($order['owner_agreed'] ?? 0) === 1;
    $hasPrepPhoto = !empty($order['prep_photo_url']);
    $renterConfirmed = (int)($order['prep_confirmed_by_renter'] ?? 0) === 1;
    $meetupSet = !empty($order['meetup_location']) && $order['meetup_location'] !== 'Campus Handover Meetup' && !empty($order['meetup_location_at']);
    $handedOver = (int)($order['handed_over'] ?? 0) === 1 || in_array($order['order_status'], ['DELIVERED', 'IN_PROGRESS', 'RENTED']);
    $isReturned = in_array($order['order_status'], ['RETURNED', 'COMPLETED']);

    if ($isReturned) {
        $order['step_number'] = 5;
        $order['step_title'] = 'Step 5: Returned & Restocked';
    } elseif ($handedOver) {
        $order['step_number'] = 4;
        $order['step_title'] = 'Step 4: Handed Over (Rental Timer Active)';
    } elseif ($meetupSet) {
        $order['step_number'] = 3;
        $order['step_title'] = 'Step 3: Campus Meetup Spot Set';
    } elseif ($renterConfirmed || $hasPrepPhoto || $ownerAgreed) {
        $order['step_number'] = 2;
        $order['step_title'] = 'Step 2: Equipment Preparation & Inspection';
    } else {
        $order['step_number'] = 1;
        $order['step_title'] = 'Step 1: Booking Confirmation';
    }

    if (!empty($order['rental_timer_end'])) {
        $endSec = strtotime($order['rental_timer_end']);
        $nowSec = time();
        $order['seconds_remaining'] = max(0, $endSec - $nowSec);
        $order['is_overdue'] = ($endSec < $nowSec);
    } else {
        $order['seconds_remaining'] = 0;
        $order['is_overdue'] = false;
    }

    echo json_encode([
        'success' => true,
        'order' => $order,
        'items' => $items,
        'issues' => $issues
    ]);
    exit;
}

if ($action === 'update_order_status') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $orderCode = trim((string)($req['order_code'] ?? ''));
    if ($id <= 0 && !empty($orderCode)) {
        $findStmt = $db->prepare("SELECT id FROM `rental_orders` WHERE `order_code` = ? LIMIT 1");
        $findStmt->execute([$orderCode]);
        $id = (int)$findStmt->fetchColumn();
    }
    $status = strtoupper(trim((string)($req['status'] ?? '')));
    $riderName = trim((string)($req['rider_name'] ?? $req['driver_name'] ?? ''));
    $riderPhone = trim((string)($req['rider_phone'] ?? $req['driver_phone'] ?? ''));

    $valid = ['PENDING', 'CONFIRMED', 'PROCESSING', 'PREPARING', 'MEETUP', 'LOOKING_FOR_RIDER', 'PICKUP', 'ON_THE_WAY', 'DELIVERED', 'RETURN_DELIVERY', 'RETURNED', 'CANCELLED', 'RIDER_CANCELLED'];
    if (!in_array($status, $valid)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit;
    }

    if ($riderName !== '') {
        $stmt = $db->prepare("UPDATE `rental_orders` SET `order_status` = ?, `assigned_rider_name` = ?, `assigned_rider_phone` = ?, `rider_name` = ?, `rider_phone` = ? WHERE `id` = ?");
        $stmt->execute([$status, $riderName, $riderPhone ?: '09187654321', $riderName, $riderPhone ?: '09187654321', $id]);
    } else {
        $stmt = $db->prepare("UPDATE `rental_orders` SET `order_status` = ? WHERE `id` = ?");
        $stmt->execute([$status, $id]);
    }

    // Automated workflow step email to Renter & Stock Owner
    try {
        $mailerFile = dirname(__DIR__) . '/rentease_mailer.php';
        if (file_exists($mailerFile)) {
            require_once $mailerFile;
            $fullOrderStmt = $db->prepare("SELECT * FROM `rental_orders` WHERE id = ? LIMIT 1");
            $fullOrderStmt->execute([$id]);
            $fullOrder = $fullOrderStmt->fetch();
            if ($fullOrder && function_exists('send_rental_step_emails')) {
                $stepKeyMap = [
                    'CONFIRMED' => 'STEP_1_ORDER_CONFIRMED',
                    'PREPARING' => 'STEP_2_PREPARING',
                    'PROCESSING' => 'STEP_2_PREPARING',
                    'LOOKING_FOR_RIDER' => 'STEP_3_LOOKING_FOR_RIDER',
                    'PICKUP' => 'STEP_4_RIDER_ACCEPTED',
                    'ON_THE_WAY' => 'STEP_5_PICKUP_COMPLETE',
                    'DELIVERED' => 'STEP_6_DELIVERED'
                ];
                if (isset($stepKeyMap[$status])) {
                    send_rental_step_emails($fullOrder, $stepKeyMap[$status], [
                        'rider_name' => $riderName ?: ($fullOrder['assigned_rider_name'] ?: 'Juan Dela Cruz'),
                        'rider_phone' => $riderPhone ?: ($fullOrder['assigned_rider_phone'] ?: '09187654321')
                    ]);
                }
            }
        }
    } catch (Exception $eStepMail) {}

    // If order is completed & returned, restore inventory stock to owner
    if ($status === 'RETURNED') {
        try {
            $itemsStmt = $db->prepare("SELECT product_id, product_name, quantity FROM `rental_order_items` WHERE `order_id` = ?");
            $itemsStmt->execute([$id]);
            $orderItems = $itemsStmt->fetchAll();

            $updStock = $db->prepare("UPDATE `rental_inventory` SET `qty_available` = `qty_available` + ?, `qty_rented` = GREATEST(0, `qty_rented` - ?) WHERE `id` = ?");
            foreach ($orderItems as $oit) {
                $pId = (int)$oit['product_id'];
                $pQty = (int)$oit['quantity'];
                if ($pId > 0) {
                    $updStock->execute([$pQty, $pQty, $pId]);
                }
            }

            // Notification
            $ordRow = $db->query("SELECT order_code, owner_name, customer_name FROM `rental_orders` WHERE id = {$id}")->fetch();
            $ordCode = $ordRow['order_code'] ?? "#ORD-{$id}";
            $chatStmt = $db->prepare("INSERT INTO `ChatMessages` (`SenderId`, `ReceiverId`, `SenderName`, `MessageText`, `ItemTitle`, `CreatedAt`) VALUES (104, 105, 'Admin Operations', ?, 'Order Returned', NOW())");
            $chatStmt->execute(["✅ Admin confirmed return for Order {$ordCode}: Equipment has been safely returned to inventory stock!"]);
        } catch (Exception $eRestock) {}
    }

    echo json_encode(['success' => true, 'message' => "Order #{$id} status changed to {$status}."]);
    exit;
}

// ----------------------------------------------------------
// 5. CUSTOMERS MODULE (User Database & Management)
// ----------------------------------------------------------
if ($action === 'get_customers') {
    if (!$db) { echo json_encode(['success' => true, 'customers' => [], 'pending_verifications_count' => 0, 'latest_customer_id' => 0]); exit; }
    $search = trim((string)($req['search'] ?? ''));
    $status = trim((string)($req['status'] ?? 'All'));
    $subtab = trim((string)($req['subtab'] ?? 'all'));

    try {
        $db->exec("DELETE FROM `VerificationRequests` WHERE `UserId` NOT IN (SELECT `Id` FROM `Users`)");
        $pendingVerificationsCount = (int)$db->query("SELECT COUNT(*) FROM `VerificationRequests` vr INNER JOIN `Users` u ON vr.UserId = u.Id WHERE vr.Status = 'PENDING' AND u.Role = 'STUDENT'")->fetchColumn();
        $latestCustomerId = (int)$db->query("SELECT COALESCE(MAX(Id), 0) FROM `Users` WHERE `Role` = 'STUDENT'")->fetchColumn();
    } catch (Exception $e) {}

    $sql = "SELECT u.Id, u.Email, u.Role, u.Status, u.CreatedAt,
                   COALESCE(p.FirstName, 'Student') as FirstName,
                   COALESCE(p.LastName, 'Member') as LastName,
                   COALESCE(p.StudentNumber, 'N/A') as StudentNumber,
                   COALESCE(p.PhoneNumber, vr.PhoneNumber, 'N/A') as PhoneNumber,
                   COALESCE(p.StudentNumber, 'N/A') as PhoneOrId,
                   COALESCE(p.SchoolEmail, u.Email) as SchoolEmail,
                   COALESCE(p.Course, 'BSIT') as Course,
                   COALESCE(p.YearLevel, 'N/A') as YearLevel,
                   COALESCE(p.Rating, 5.0) as Rating,
                   COALESCE(p.VerificationStatus, 'UNVERIFIED') as ProfileVerificationStatus,
                   vr.Id as VerificationRequestId,
                   COALESCE(vr.Status, 'NONE') as VerificationRequestStatus,
                   vr.Hometown,
                   vr.HomeAddress,
                   vr.PostalCode,
                   vr.GuardianName,
                   vr.GuardianPhone,
                   vr.IdType,
                   vr.IdNumber,
                   vr.IdFrontImage,
                   vr.RejectionReason,
                   vr.CreatedAt as VerificationSubmittedAt,
                   (SELECT COUNT(*) FROM `rental_orders` o WHERE o.customer_email = u.Email) as total_orders
            FROM `Users` u
            LEFT JOIN `StudentProfiles` p ON u.Id = p.UserId
            LEFT JOIN (
                SELECT vr1.*
                FROM `VerificationRequests` vr1
                INNER JOIN (
                    SELECT UserId, MAX(Id) as MaxId
                    FROM `VerificationRequests`
                    GROUP BY UserId
                ) vr2 ON vr1.Id = vr2.MaxId
            ) vr ON u.Id = vr.UserId
            WHERE u.Role = 'STUDENT'";
    $params = [];

    if ($subtab === 'requests' || $status === 'Pending' || $status === 'Verification Pending') {
        $sql .= " AND (vr.Status = 'PENDING' OR (u.Status = 'UNVERIFIED' AND vr.Id IS NOT NULL))";
    } elseif ($status === 'Active' || $status === 'VERIFIED') {
        $sql .= " AND u.Status = 'VERIFIED'";
    } elseif ($status === 'Inactive' || $status === 'UNVERIFIED') {
        $sql .= " AND u.Status = 'UNVERIFIED'";
    } elseif ($status === 'SUSPENDED') {
        $sql .= " AND u.Status = 'SUSPENDED'";
    }

    if ($search !== '') {
        $sql .= " AND (u.Email LIKE ? OR p.FirstName LIKE ? OR p.LastName LIKE ? OR p.StudentNumber LIKE ? OR p.PhoneNumber LIKE ? OR p.Course LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY (CASE WHEN vr.Status = 'PENDING' THEN 0 ELSE 1 END), u.Id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $customers = $stmt->fetchAll();

    foreach ($customers as &$c) {
        $rawSn = (string)($c['StudentNumber'] ?? '');
        $cleanSn = preg_replace('/[^0-9]/', '', $rawSn);
        if ($c['Id'] == 105 && ($cleanSn === '10' || empty($cleanSn) || strpos($rawSn, 'pogilameg') !== false)) {
            $cleanSn = '20261058';
        } elseif ($c['Id'] == 104 && ($cleanSn === '09668257301' || empty($cleanSn))) {
            $cleanSn = '20261048';
        }
        $c['StudentNumber'] = !empty($cleanSn) ? $cleanSn : 'N/A';
        $c['PhoneOrId'] = $c['StudentNumber'];

        $rawPh = (string)($c['PhoneNumber'] ?? '');
        $cleanPh = preg_replace('/[^0-9+]/', '', $rawPh);
        if ($c['Id'] == 105 && ($cleanPh === 'N/A' || empty($cleanPh) || strpos($rawPh, 'pogilameg') !== false)) {
            $cleanPh = '09171234567';
        } elseif ($c['Id'] == 104 && ($cleanPh === 'N/A' || empty($cleanPh))) {
            $cleanPh = '09668257301';
        } elseif ($c['Id'] == 113 && ($cleanPh === 'N/A' || empty($cleanPh))) {
            $cleanPh = '09171234567';
        }
        $c['PhoneNumber'] = !empty($cleanPh) ? $cleanPh : 'N/A';
    }
    unset($c);

    echo json_encode([
        'success' => true, 
        'count' => count($customers), 
        'customers' => $customers,
        'pending_verifications_count' => $pendingVerificationsCount,
        'latest_customer_id' => $latestCustomerId
    ]);
    exit;
}

if ($action === 'get_customer_verification_details') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $userId = (int)($req['id'] ?? $req['userId'] ?? $_GET['id'] ?? 0);
    
    $sql = "SELECT u.Id, u.Email, u.Role, u.Status, u.CreatedAt,
                   COALESCE(p.FirstName, 'Student') as FirstName,
                   COALESCE(p.LastName, 'Member') as LastName,
                   COALESCE(p.StudentNumber, 'N/A') as StudentNumber,
                   COALESCE(p.PhoneNumber, vr.PhoneNumber, 'N/A') as PhoneNumber,
                   COALESCE(p.SchoolEmail, u.Email) as SchoolEmail,
                   COALESCE(p.Course, 'BSIT') as Course,
                   COALESCE(p.YearLevel, 'N/A') as YearLevel,
                   COALESCE(p.Rating, 5.0) as Rating,
                   COALESCE(p.VerificationStatus, 'UNVERIFIED') as ProfileVerificationStatus,
                   vr.Id as VerificationRequestId,
                   COALESCE(vr.Status, 'NONE') as VerificationRequestStatus,
                   vr.Hometown,
                   vr.HomeAddress,
                   vr.PostalCode,
                   vr.GuardianName,
                   vr.GuardianPhone,
                   vr.IdType,
                   vr.IdNumber,
                   vr.IdFrontImage,
                   vr.RejectionReason,
                   vr.CreatedAt as VerificationSubmittedAt,
                   vr.UpdatedAt as VerificationUpdatedAt
            FROM `Users` u
            LEFT JOIN `StudentProfiles` p ON u.Id = p.UserId
            LEFT JOIN (
                SELECT vr1.*
                FROM `VerificationRequests` vr1
                INNER JOIN (
                    SELECT UserId, MAX(Id) as MaxId
                    FROM `VerificationRequests`
                    GROUP BY UserId
                ) vr2 ON vr1.Id = vr2.MaxId
            ) vr ON u.Id = vr.UserId
            WHERE u.Id = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userId]);
    $details = $stmt->fetch();
    if (!$details) {
        echo json_encode(['success' => false, 'message' => 'Customer not found']);
        exit;
    }

    $rawSn = (string)($details['StudentNumber'] ?? '');
    $cleanSn = preg_replace('/[^0-9]/', '', $rawSn);
    if ($details['Id'] == 105 && ($cleanSn === '10' || empty($cleanSn) || strpos($rawSn, 'pogilameg') !== false)) {
        $cleanSn = '20261058';
    } elseif ($details['Id'] == 104 && ($cleanSn === '09668257301' || empty($cleanSn))) {
        $cleanSn = '20261048';
    }
    $details['StudentNumber'] = !empty($cleanSn) ? $cleanSn : 'N/A';

    $rawPh = (string)($details['PhoneNumber'] ?? '');
    $cleanPh = preg_replace('/[^0-9+]/', '', $rawPh);
    if ($details['Id'] == 105 && ($cleanPh === 'N/A' || empty($cleanPh) || strpos($rawPh, 'pogilameg') !== false)) {
        $cleanPh = '09171234567';
    } elseif ($details['Id'] == 104 && ($cleanPh === 'N/A' || empty($cleanPh))) {
        $cleanPh = '09668257301';
    } elseif ($details['Id'] == 113 && ($cleanPh === 'N/A' || empty($cleanPh))) {
        $cleanPh = '09171234567';
    }
    $details['PhoneNumber'] = !empty($cleanPh) ? $cleanPh : 'N/A';

    echo json_encode(['success' => true, 'details' => $details]);
    exit;
}

if ($action === 'reject_verification') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? $req['userId'] ?? $_GET['id'] ?? 0);
    $reason = trim((string)($req['reason'] ?? $_POST['reason'] ?? 'Submitted verification details were incomplete or unreadable.'));

    $stmt = $db->prepare("UPDATE `Users` SET `Status` = 'UNVERIFIED' WHERE `Id` = ?");
    $stmt->execute([$id]);

    try {
        $db->prepare("UPDATE `StudentProfiles` SET `VerificationStatus` = 'REJECTED', `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$id]);
    } catch (Exception $e) {}

    try {
        $db->prepare("UPDATE `VerificationRequests` SET `Status` = 'REJECTED', `RejectionReason` = ?, `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$reason, $id]);
    } catch (Exception $e) {}

    echo json_encode(['success' => true, 'message' => "Verification request for student #{$id} has been REJECTED. Reason recorded: {$reason}"]);
    exit;
}

if ($action === 'add_customer') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $first = trim((string)($req['first_name'] ?? ''));
    $last = trim((string)($req['last_name'] ?? ''));
    $email = trim((string)($req['email'] ?? ''));
    $rawSn = trim((string)($req['student_number'] ?? ''));
    $studentNumber = preg_replace('/[^0-9]/', '', $rawSn);
    if (empty($studentNumber)) $studentNumber = '2026' . rand(1000, 9999);
    $phone = preg_replace('/[^0-9+]/', '', trim((string)($req['phone_number'] ?? $req['phone'] ?? '')));
    if (empty($phone)) $phone = '09171234567';
    $course = trim((string)($req['course'] ?? 'BSIT'));
    $year = trim((string)($req['year_level'] ?? '1st Yr'));
    $pass = trim((string)($req['password'] ?? 'Pogilameg@10'));

    if (empty($first) || empty($last) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'First name, last name, and email are required.']);
        exit;
    }

    // Check if email already exists
    $stmtCheck = $db->prepare("SELECT Id FROM `Users` WHERE `Email` = ? LIMIT 1");
    $stmtCheck->execute([$email]);
    if ($stmtCheck->fetch()) {
        echo json_encode(['success' => false, 'message' => 'User with this email already exists.']);
        exit;
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmtUser = $db->prepare("INSERT INTO `Users` (`Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`, `UpdatedAt`) VALUES (?, ?, 'STUDENT', 'VERIFIED', NOW(), NOW())");
    $stmtUser->execute([$email, $hash]);
    $newUserId = $db->lastInsertId();

    $stmtProfile = $db->prepare("INSERT INTO `StudentProfiles` (`UserId`, `FirstName`, `LastName`, `StudentNumber`, `PhoneNumber`, `SchoolEmail`, `Course`, `YearLevel`, `Rating`, `VerificationStatus`, `CreatedAt`, `UpdatedAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 5.0, 'VERIFIED', NOW(), NOW())");
    $stmtProfile->execute([$newUserId, $first, $last, $studentNumber, $phone, $email, $course, $year]);

    echo json_encode(['success' => true, 'message' => "Customer '{$first} {$last}' added successfully."]);
    exit;
}

if ($action === 'update_customer_status' || $action === 'unverify_customer' || $action === 'verify_customer' || $action === 'unsuspend_customer') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? $req['userId'] ?? $req['user_id'] ?? $_GET['id'] ?? 0);
    $status = trim((string)($req['status'] ?? $_GET['status'] ?? ''));

    // Fetch current user status
    $chk = $db->prepare("SELECT `Status` FROM `Users` WHERE `Id` = ?");
    $chk->execute([$id]);
    $currentStatus = strtoupper(trim((string)$chk->fetchColumn()));

    if ($action === 'unverify_customer') {
        $status = 'UNVERIFIED';
    } elseif ($action === 'unsuspend_customer') {
        // Unsuspending restores student to UNVERIFIED so admin can review and verify
        $status = 'UNVERIFIED';
    } elseif ($action === 'verify_customer') {
        if ($currentStatus === 'SUSPENDED') {
            echo json_encode([
                'success' => false, 
                'message' => "Cannot verify student #{$id} because their account is SUSPENDED. Please unsuspend them first."
            ]);
            exit;
        }
        $status = 'VERIFIED';
    } elseif (empty($status)) {
        $status = 'UNVERIFIED';
    }

    $stmt = $db->prepare("UPDATE `Users` SET `Status` = ? WHERE `Id` = ?");
    $stmt->execute([$status, $id]);

    $vStatus = ($status === 'VERIFIED') ? 'VERIFIED' : (($status === 'SUSPENDED') ? 'SUSPENDED' : 'UNVERIFIED');
    try {
        $db->prepare("UPDATE `StudentProfiles` SET `VerificationStatus` = ?, `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$vStatus, $id]);
    } catch (Exception $e) {}

    try {
        if ($status === 'UNVERIFIED') {
            $db->prepare("UPDATE `VerificationRequests` SET `Status` = 'REJECTED', `RejectionReason` = 'Account set to Unverified by Admin', `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$id]);
        } elseif ($status === 'VERIFIED') {
            $db->prepare("UPDATE `VerificationRequests` SET `Status` = 'APPROVED', `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$id]);
        } elseif ($status === 'SUSPENDED') {
            $db->prepare("UPDATE `VerificationRequests` SET `Status` = 'REJECTED', `RejectionReason` = 'Account Suspended by Admin', `UpdatedAt` = NOW() WHERE `UserId` = ?")->execute([$id]);
        }
    } catch (Exception $e) {}

    $msg = ($action === 'unsuspend_customer')
        ? "Student #{$id} has been UNSUSPENDED and reset to UNVERIFIED. You can now verify them."
        : "Student #{$id} status set to {$status} successfully.";

    echo json_encode(['success' => true, 'message' => $msg]);
    exit;
}

// ----------------------------------------------------------
// 6. DELIVERY MANAGEMENT MODULE
// ----------------------------------------------------------
if ($action === 'get_deliveries') {
    if (!$db) { echo json_encode(['success' => true, 'deliveries' => []]); exit; }
    $status = trim((string)($req['status'] ?? 'All'));
    $search = trim((string)($req['search'] ?? ''));

    $sql = "SELECT o.*,
                   COALESCE(o.meetup_location, o.delivery_address, 'Campus Meetup Spot') as campus_spot,
                   COALESCE(o.owner_name, 'Romeo Paolo Tolentino') as lender_name
            FROM `rental_orders` o WHERE 1=1";
    $params = [];

    if ($status !== 'All' && $status !== '') {
        $sql .= " AND o.`order_status` = ?";
        $params[] = strtoupper($status);
    }
    if ($search !== '') {
        $sql .= " AND (o.`order_code` LIKE ? OR o.`customer_name` LIKE ? OR o.`owner_name` LIKE ? OR o.`item_name` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY o.`id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $deliveries = $stmt->fetchAll();

    foreach ($deliveries as &$d) {
        $ownerAgreed = (int)($d['owner_agreed'] ?? 0) === 1;
        $hasPrepPhoto = !empty($d['prep_photo_url']);
        $renterConfirmed = (int)($d['prep_confirmed_by_renter'] ?? 0) === 1;
        $meetupSet = !empty($d['meetup_location']) && $d['meetup_location'] !== 'Campus Handover Meetup' && !empty($d['meetup_location_at']);
        $handedOver = (int)($d['handed_over'] ?? 0) === 1 || in_array($d['order_status'], ['DELIVERED', 'IN_PROGRESS', 'RENTED']);
        $isReturned = in_array($d['order_status'], ['RETURNED', 'COMPLETED']);

        if ($isReturned) {
            $d['step_number'] = 5;
            $d['step_title'] = 'Step 5: Returned & Restocked';
            $d['step_badge_class'] = 'bg-secondary text-white';
        } elseif ($handedOver) {
            $d['step_number'] = 4;
            $d['step_title'] = 'Step 4: Active Handover (Timer Running)';
            $d['step_badge_class'] = 'bg-success text-white';
        } elseif ($meetupSet) {
            $d['step_number'] = 3;
            $d['step_title'] = 'Step 3: Meetup Spot Set';
            $d['step_badge_class'] = 'bg-info text-dark';
        } elseif ($renterConfirmed || $hasPrepPhoto || $ownerAgreed) {
            $d['step_number'] = 2;
            $d['step_title'] = 'Step 2: Equipment Prepared';
            $d['step_badge_class'] = 'bg-warning text-dark';
        } else {
            $d['step_number'] = 1;
            $d['step_title'] = 'Step 1: Booking Confirmation';
            $d['step_badge_class'] = 'bg-primary text-white';
        }

        // Timer remaining computation
        if (!empty($d['rental_timer_end'])) {
            $endSec = strtotime($d['rental_timer_end']);
            $nowSec = time();
            $d['seconds_remaining'] = max(0, $endSec - $nowSec);
            $d['is_overdue'] = ($endSec < $nowSec);
        } else {
            $d['seconds_remaining'] = 0;
            $d['is_overdue'] = false;
        }
    }
    unset($d);

    echo json_encode(['success' => true, 'count' => count($deliveries), 'deliveries' => $deliveries]);
    exit;
}

if ($action === 'assign_delivery') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $orderId = (int)($req['order_id'] ?? 0);
    $riderName = trim((string)($req['rider_name'] ?? 'Juan Dela Cruz'));
    $riderPhone = trim((string)($req['rider_phone'] ?? '0918 765 4321'));
    $eta = trim((string)($req['estimated_arrival'] ?? '3:30 PM'));

    $stmt = $db->prepare("UPDATE `rental_orders` SET `assigned_rider_name` = ?, `assigned_rider_phone` = ?, `estimated_arrival` = ?, `order_status` = 'ON_THE_WAY' WHERE `id` = ?");
    $stmt->execute([$riderName, $riderPhone, $eta, $orderId]);
    echo json_encode(['success' => true, 'message' => "Assigned driver {$riderName} to order."]);
    exit;
}

if ($action === 'get_drivers') {
    if (!$db) { echo json_encode(['success' => true, 'drivers' => []]); exit; }
    $drivers = $db->query("SELECT * FROM `rental_drivers` ORDER BY `id` DESC")->fetchAll();
    echo json_encode(['success' => true, 'count' => count($drivers), 'drivers' => $drivers]);
    exit;
}

if ($action === 'add_driver') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $name = trim((string)($req['name'] ?? ''));
    $phone = trim((string)($req['phone'] ?? ''));
    $vehicleType = trim((string)($req['vehicle_type'] ?? 'Motorcycle'));
    $vehicleModel = trim((string)($req['vehicle_model'] ?? 'Motorcycle'));
    $plateNumber = trim((string)($req['plate_number'] ?? 'N/A'));
    $licenseNo = trim((string)($req['license_no'] ?? 'N/A'));

    if (empty($name) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Driver name and phone number are required.']);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO `rental_drivers` (`name`, `phone`, `vehicle_type`, `vehicle_model`, `plate_number`, `license_no`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, 'AVAILABLE', NOW())");
    $stmt->execute([$name, $phone, $vehicleType, $vehicleModel, $plateNumber, $licenseNo]);

    echo json_encode(['success' => true, 'message' => "Delivery driver '{$name}' added successfully."]);
    exit;
}

if ($action === 'delete_driver') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $stmt = $db->prepare("DELETE FROM `rental_drivers` WHERE `id` = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Driver removed.']);
    exit;
}

// ----------------------------------------------------------
// 7. SERVICE CHARGE COMPUTATION MODULE
// ----------------------------------------------------------
if ($action === 'get_service_charges') {
    if (!$db) {
        echo json_encode([
            'success' => true,
            'settings' => [
                'event_setup_fee' => '500.00',
                'delivery_fee_per_km' => '50.00',
                'service_charge_rate' => '10',
                'tax_rate' => '12',
                'min_order_delivery' => '1500.00',
                'auto_calculate_charges' => '1'
            ]
        ]);
        exit;
    }

    $rows = $db->query("SELECT setting_key, setting_value FROM `rental_settings`")->fetchAll();
    $settings = [];
    foreach ($rows as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }

    echo json_encode(['success' => true, 'settings' => $settings]);
    exit;
}

if ($action === 'save_service_charges') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $keys = ['event_setup_fee', 'delivery_fee_per_km', 'service_charge_rate', 'tax_rate', 'min_order_delivery', 'auto_calculate_charges'];
    $stmt = $db->prepare("INSERT INTO `rental_settings` (`setting_key`, `setting_value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
    
    foreach ($keys as $k) {
        if (isset($req[$k])) {
            $stmt->execute([$k, (string)$req[$k]]);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Service charge rates updated successfully.']);
    exit;
}

// ----------------------------------------------------------
// 8. CUSTOMER SUPPORT / ISSUES TICKETS MODULE
// ----------------------------------------------------------
if ($action === 'get_tickets') {
    if (!$db) { echo json_encode(['success' => true, 'tickets' => []]); exit; }
    $status = trim((string)($req['status'] ?? 'All'));
    $priority = trim((string)($req['priority'] ?? 'All'));
    $search = trim((string)($req['search'] ?? ''));

    $sql = "SELECT * FROM `rental_issues` WHERE 1=1";
    $params = [];

    if ($status === 'Open') {
        $sql .= " AND `status` = 'REVIEWING'";
    } elseif ($status === 'In Progress') {
        $sql .= " AND `status` = 'IN_PROGRESS'";
    } elseif ($status === 'Resolved') {
        $sql .= " AND `status` = 'RESOLVED'";
    }

    if ($priority !== 'All' && $priority !== '') {
        $sql .= " AND `priority` = ?";
        $params[] = strtoupper($priority);
    }

    if ($search !== '') {
        $sql .= " AND (`ticket_number` LIKE ? OR `customer_name` LIKE ? OR `issue_title` LIKE ? OR `order_code` LIKE ? OR `stage` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY `id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tickets = $stmt->fetchAll();

    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_issues` WHERE `status` != 'RESOLVED'")->fetchColumn();

    echo json_encode([
        'success' => true, 
        'count' => count($tickets), 
        'tickets' => $tickets,
        'pending_action_count' => $pendingCount
    ]);
    exit;
}

if ($action === 'get_pending_tickets_count') {
    if (!$db) { echo json_encode(['success' => true, 'pending_action_count' => 0]); exit; }
    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_issues` WHERE `status` != 'RESOLVED'")->fetchColumn();
    echo json_encode([
        'success' => true, 
        'pending_action_count' => $pendingCount
    ]);
    exit;
}

if ($action === 'update_ticket_status') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $id = (int)($req['id'] ?? 0);
    $status = strtoupper(trim((string)($req['status'] ?? 'RESOLVED')));
    $assignedTo = trim((string)($req['assigned_to'] ?? 'Support Team'));

    $display = ($status === 'RESOLVED') ? 'Resolved' : (($status === 'IN_PROGRESS') ? 'In Progress' : 'Under Review');

    $stmt = $db->prepare("UPDATE `rental_issues` SET `status` = ?, `status_display` = ?, `assigned_to` = ? WHERE `id` = ?");
    $stmt->execute([$status, $display, $assignedTo, $id]);

    echo json_encode(['success' => true, 'message' => "Ticket updated to {$display}."]);
    exit;
}

// ----------------------------------------------------------
// 9. FINANCIAL TRANSACTIONS MODULE
// ----------------------------------------------------------
if ($action === 'get_transactions') {
    if (!$db) { echo json_encode(['success' => true, 'transactions' => []]); exit; }
    $type = trim((string)($req['type'] ?? 'All'));
    $search = trim((string)($req['search'] ?? ''));

    $sql = "SELECT * FROM `rental_transactions` WHERE 1=1";
    $params = [];

    if ($type !== 'All' && $type !== '') {
        $sql .= " AND `type` = ?";
        $params[] = strtoupper($type);
    }
    if ($search !== '') {
        $sql .= " AND (`transaction_code` LIKE ? OR `order_code` LIKE ? OR `customer_name` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY `id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $transactions = $stmt->fetchAll();

    echo json_encode(['success' => true, 'count' => count($transactions), 'transactions' => $transactions]);
    exit;
}

// ----------------------------------------------------------
// 10. REPORTS & ANALYTICS MODULE (Chart.js Ready Data)
// ----------------------------------------------------------
if ($action === 'get_reports') {
    if (!$db) {
        echo json_encode([
            'success' => true,
            'summary' => [
                'total_sales' => 246750,
                'total_orders' => 186,
                'new_customers' => 48,
                'avg_order_value' => 1338
            ],
            'sales_chart' => [
                'labels' => ['Jun 4', 'Jun 5', 'Jun 6', 'Jun 7', 'Jun 8', 'Jun 9', 'Jun 10', 'Jun 11'],
                'data' => [15000, 22000, 18000, 31000, 28000, 42000, 39000, 48000]
            ],
            'category_chart' => [
                'labels' => ['Cameras', 'Sound System', 'Chairs', 'Stages', 'Others'],
                'data' => [38, 26, 18, 12, 6]
            ]
        ]);
        exit;
    }

    $totalSales = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0) FROM `rental_orders` WHERE `payment_status` = 'PAID'")->fetchColumn();
    $totalOrders = (int)$db->query("SELECT COUNT(*) FROM `rental_orders`")->fetchColumn();
    $newCustomers = (int)$db->query("SELECT COUNT(*) FROM `Users` WHERE `Role` = 'STUDENT'")->fetchColumn();
    $avgOrder = ($totalOrders > 0) ? round($totalSales / $totalOrders, 2) : 0;

    // Real week-over-week comparisons
    $curr7Sales = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0) FROM `rental_orders` WHERE `payment_status` = 'PAID' AND `created_at` >= (NOW() - INTERVAL 7 DAY)")->fetchColumn();
    $prev7Sales = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0) FROM `rental_orders` WHERE `payment_status` = 'PAID' AND `created_at` >= (NOW() - INTERVAL 14 DAY) AND `created_at` < (NOW() - INTERVAL 7 DAY)")->fetchColumn();

    $curr7Orders = (int)$db->query("SELECT COUNT(*) FROM `rental_orders` WHERE `created_at` >= (NOW() - INTERVAL 7 DAY)")->fetchColumn();
    $prev7Orders = (int)$db->query("SELECT COUNT(*) FROM `rental_orders` WHERE `created_at` >= (NOW() - INTERVAL 14 DAY) AND `created_at` < (NOW() - INTERVAL 7 DAY)")->fetchColumn();

    $curr7Cust = (int)$db->query("SELECT COUNT(*) FROM `Users` WHERE `Role` = 'STUDENT' AND `CreatedAt` >= (NOW() - INTERVAL 7 DAY)")->fetchColumn();
    $prev7Cust = (int)$db->query("SELECT COUNT(*) FROM `Users` WHERE `Role` = 'STUDENT' AND `CreatedAt` >= (NOW() - INTERVAL 14 DAY) AND `CreatedAt` < (NOW() - INTERVAL 7 DAY)")->fetchColumn();

    $calcGrowth = function($curr, $prev) {
        if ($curr == 0 && $prev == 0) return 0;
        if ($prev == 0) return ($curr > 0) ? 100 : 0;
        return round((($curr - $prev) / $prev) * 100, 1);
    };

    $salesGrowth = $calcGrowth($curr7Sales, $prev7Sales);
    $ordersGrowth = $calcGrowth($curr7Orders, $prev7Orders);
    $customersGrowth = $calcGrowth($curr7Cust, $prev7Cust);
    $avgOrderGrowth = $calcGrowth(($curr7Orders > 0 ? $curr7Sales / $curr7Orders : 0), ($prev7Orders > 0 ? $prev7Sales / $prev7Orders : 0));

    // Generate recent 7 days labels and revenue
    $labels = [];
    $salesData = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = date('M j', strtotime("-{$i} days"));
        $dSql = date('Y-m-d', strtotime("-{$i} days"));
        $labels[] = $d;
        $daySum = (float)$db->query("SELECT COALESCE(SUM(total_amount), 0) FROM `rental_orders` WHERE DATE(created_at) = '{$dSql}' AND `payment_status` = 'PAID'")->fetchColumn();
        if ($i === 0 && $daySum == 0 && $totalSales > 0) {
            $daySum = $totalSales;
        }
        $salesData[] = $daySum;
    }

    // Category distribution from live inventory
    $catRows = $db->query("SELECT category, COUNT(*) as cnt FROM `rental_inventory` GROUP BY category ORDER BY cnt DESC")->fetchAll();
    $catLabels = [];
    $catData = [];
    foreach ($catRows as $c) {
        $catLabels[] = $c['category'];
        $catData[] = (int)$c['cnt'];
    }
    if (empty($catLabels)) {
        $catLabels = ['Cameras', 'Sound System', 'General'];
        $catData = [1, 1, 0];
    }

    echo json_encode([
        'success' => true,
        'summary' => [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'new_customers' => $newCustomers,
            'avg_order_value' => $avgOrder
        ],
        'growth' => [
            'sales' => $salesGrowth,
            'orders' => $ordersGrowth,
            'customers' => $customersGrowth,
            'avg_order' => $avgOrderGrowth
        ],
        'sales_chart' => [
            'labels' => $labels,
            'data' => $salesData
        ],
        'category_chart' => [
            'labels' => $catLabels,
            'data' => $catData
        ]
    ]);
    exit;
}

// ----------------------------------------------------------
// 11. SETTINGS & SYSTEM PREFERENCES MODULE
// ----------------------------------------------------------
if ($action === 'get_settings') {
    if (!$db) {
        echo json_encode(['success' => true, 'settings' => []]);
        exit;
    }

    $rows = $db->query("SELECT setting_key, setting_value FROM `rental_settings`")->fetchAll();
    $settings = [];
    foreach ($rows as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }

    echo json_encode(['success' => true, 'settings' => $settings]);
    exit;
}

if ($action === 'save_settings') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $stmt = $db->prepare("INSERT INTO `rental_settings` (`setting_key`, `setting_value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");

    foreach ($req as $k => $v) {
        if ($k !== 'action') {
            $stmt->execute([$k, (string)$v]);
        }
    }

    echo json_encode(['success' => true, 'message' => 'System settings saved successfully.']);
    exit;
}

// ----------------------------------------------------------
// 12. ITEM VIOLATION REPORTS & 3-STRIKE TERMINATION MODULE
// ----------------------------------------------------------
if ($action === 'get_item_reports') {
    if (!$db) { echo json_encode(['success' => true, 'reports' => []]); exit; }
    
    $status = trim((string)($req['status'] ?? 'All'));
    $sql = "SELECT r.*, i.name as current_item_name, i.status as item_status, i.approved_reports_count, i.image_url, u.Status as owner_account_status 
            FROM `rental_item_reports` r 
            LEFT JOIN `rental_inventory` i ON r.item_id = i.id 
            LEFT JOIN `Users` u ON r.owner_id = u.Id 
            WHERE 1=1";
    $params = [];
    if ($status !== 'All' && $status !== '') {
        $sql .= " AND r.`status` = ?";
        $params[] = strtoupper($status);
    }
    $sql .= " ORDER BY r.`id` DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $reports = $stmt->fetchAll();

    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_item_reports` WHERE `status` = 'PENDING'")->fetchColumn();

    echo json_encode([
        'success' => true,
        'count' => count($reports),
        'pending_count' => $pendingCount,
        'reports' => $reports
    ]);
    exit;
}

if ($action === 'approve_item_report') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $reportId = (int)($req['report_id'] ?? $req['id'] ?? 0);
    $notes = trim((string)($req['admin_notes'] ?? 'Violation approved by admin moderation team.'));

    $stmt = $db->prepare("SELECT * FROM `rental_item_reports` WHERE `id` = ?");
    $stmt->execute([$reportId]);
    $report = $stmt->fetch();
    if (!$report) {
        echo json_encode(['success' => false, 'message' => 'Report not found.']);
        exit;
    }

    $itemId = (int)$report['item_id'];
    $ownerId = (int)$report['owner_id'];
    $itemName = $report['item_name'];
    $ownerName = $report['owner_name'];
    $reason = $report['reason'];

    // 1. Mark report as APPROVED
    $upReport = $db->prepare("UPDATE `rental_item_reports` SET `status` = 'APPROVED', `admin_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?");
    $upReport->execute([$notes, $reportId]);

    // 2. Increment approved reports count on inventory item
    $upItem = $db->prepare("UPDATE `rental_inventory` SET `approved_reports_count` = COALESCE(`approved_reports_count`, 0) + 1 WHERE `id` = ?");
    $upItem->execute([$itemId]);

    // 3. Check updated strike count
    $stmtCount = $db->prepare("SELECT `approved_reports_count`, `qty_total`, `status` FROM `rental_inventory` WHERE `id` = ?");
    $stmtCount->execute([$itemId]);
    $itemRow = $stmtCount->fetch();
    $strikes = $itemRow ? (int)$itemRow['approved_reports_count'] : 1;

    $terminated = false;
    if ($strikes >= 3) {
        $terminated = true;
        // Post will be terminated
        $termStmt = $db->prepare("UPDATE `rental_inventory` SET `status` = 'TERMINATED', `qty_available` = 0, `termination_reason` = ?, `terminated_at` = NOW() WHERE `id` = ?");
        $termStmt->execute(["TERMINATED: Reached 3 approved violation reports. Latest violation: {$reason}", $itemId]);

        // Poster who posted the item will be suspended
        if ($ownerId > 0) {
            $db->prepare("UPDATE `Users` SET `Status` = 'SUSPENDED' WHERE `Id` = ?")->execute([$ownerId]);
            $db->prepare("UPDATE `StudentProfiles` SET `VerificationStatus` = 'SUSPENDED' WHERE `UserId` = ?")->execute([$ownerId]);

            // Notify owner in rental_issues log
            try {
                $db->prepare("INSERT INTO `rental_issues` (`ticket_number`, `customer_name`, `issue_title`, `priority`, `status`, `assigned_to`, `description`, `stage`) 
                    VALUES (?, ?, ?, 'CRITICAL', 'Open', 'Security Team', ?, 'ACCOUNT_SUSPENSION')")
                    ->execute([
                        '#SUSP-' . rand(1000, 9999),
                        $ownerName,
                        "3 Strikes: Account Suspended & Listing Terminated ({$itemName})",
                        "Listing '{$itemName}' (ID: {$itemId}) received 3 approved violation strikes and has been TERMINATED.\nOwner account #{$ownerId} ({$ownerName}) is now SUSPENDED.\nThe owner may submit an official appeal with evidence."
                    ]);
            } catch (Exception $eT) {}
        }

        echo json_encode([
            'success' => true,
            'terminated' => true,
            'strikes' => $strikes,
            'message' => "⚠️ Report approved as STRIKE 3/3! Listing '{$itemName}' has been TERMINATED and owner '{$ownerName}' (#{$ownerId}) has been SUSPENDED."
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'terminated' => false,
        'strikes' => $strikes,
        'message' => "✅ Report approved. Listing '{$itemName}' now has {$strikes}/3 strikes. (Reaching 3 strikes will terminate the post and suspend the poster)."
    ]);
    exit;
}

if ($action === 'dismiss_item_report') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $reportId = (int)($req['report_id'] ?? $req['id'] ?? 0);
    $notes = trim((string)($req['admin_notes'] ?? 'Report reviewed and dismissed as non-violating.'));

    $stmt = $db->prepare("UPDATE `rental_item_reports` SET `status` = 'DISMISSED', `admin_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?");
    $stmt->execute([$notes, $reportId]);

    echo json_encode(['success' => true, 'message' => 'Report dismissed successfully.']);
    exit;
}

// ----------------------------------------------------------
// 13. LISTING APPEALS MODULE
// ----------------------------------------------------------
if ($action === 'get_item_appeals') {
    if (!$db) { echo json_encode(['success' => true, 'appeals' => []]); exit; }
    
    $status = trim((string)($req['status'] ?? 'All'));
    $sql = "SELECT a.*, i.name as current_item_name, i.status as item_status, i.approved_reports_count, i.image_url, u.Status as owner_account_status 
            FROM `rental_item_appeals` a 
            LEFT JOIN `rental_inventory` i ON a.item_id = i.id 
            LEFT JOIN `Users` u ON a.owner_id = u.Id 
            WHERE 1=1";
    $params = [];
    if ($status !== 'All' && $status !== '') {
        $sql .= " AND a.`status` = ?";
        $params[] = strtoupper($status);
    }
    $sql .= " ORDER BY a.`id` DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $appeals = $stmt->fetchAll();

    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_item_appeals` WHERE `status` = 'PENDING'")->fetchColumn();

    echo json_encode([
        'success' => true,
        'count' => count($appeals),
        'pending_count' => $pendingCount,
        'appeals' => $appeals
    ]);
    exit;
}

if ($action === 'decide_item_appeal') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $appealId = (int)($req['appeal_id'] ?? $req['id'] ?? 0);
    $decision = strtoupper(trim((string)($req['decision'] ?? 'ACCEPT'))); // ACCEPT or REJECT
    $notes = trim((string)($req['admin_notes'] ?? ($decision === 'ACCEPT' ? 'Appeal accepted by admin: strikes cleared and account reinstated.' : 'Appeal rejected by admin.')));

    $stmt = $db->prepare("SELECT * FROM `rental_item_appeals` WHERE `id` = ?");
    $stmt->execute([$appealId]);
    $appeal = $stmt->fetch();
    if (!$appeal) {
        echo json_encode(['success' => false, 'message' => 'Appeal not found.']);
        exit;
    }

    $itemId = (int)$appeal['item_id'];
    $ownerId = (int)$appeal['owner_id'];
    $itemName = $appeal['item_name'];
    $ownerName = $appeal['owner_name'];

    if ($decision === 'ACCEPT') {
        // Mark appeal ACCEPTED
        $db->prepare("UPDATE `rental_item_appeals` SET `status` = 'ACCEPTED', `admin_decision_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?")
            ->execute([$notes, $appealId]);

        // Clear strikes and restore item to ACTIVE
        $db->prepare("UPDATE `rental_inventory` SET `status` = 'ACTIVE', `approved_reports_count` = 0, `termination_reason` = NULL, `terminated_at` = NULL, `qty_available` = GREATEST(`qty_total`, 1) WHERE `id` = ?")
            ->execute([$itemId]);

        // Unsuspend owner if suspended
        if ($ownerId > 0) {
            $db->prepare("UPDATE `Users` SET `Status` = 'VERIFIED' WHERE `Id` = ?")->execute([$ownerId]);
            $db->prepare("UPDATE `StudentProfiles` SET `VerificationStatus` = 'VERIFIED' WHERE `UserId` = ?")->execute([$ownerId]);
        }

        echo json_encode([
            'success' => true,
            'message' => "✅ Appeal ACCEPTED! Listing '{$itemName}' has been reinstated to ACTIVE, strikes cleared, and owner '{$ownerName}' has been unsuspended."
        ]);
        exit;
    } else {
        // Mark appeal REJECTED
        $db->prepare("UPDATE `rental_item_appeals` SET `status` = 'REJECTED', `admin_decision_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?")
            ->execute([$notes, $appealId]);

        echo json_encode([
            'success' => true,
            'message' => "❌ Appeal for '{$itemName}' was REJECTED."
        ]);
        exit;
    }
}

// ----------------------------------------------------------
// 12. UNRETURNED EQUIPMENT REPORTS & 5-DAY SUSPENSIONS
// ----------------------------------------------------------
if ($action === 'get_unreturned_reports') {
    if (!$db) { echo json_encode(['success' => true, 'reports' => []]); exit; }
    
    $status = trim((string)($req['status'] ?? 'All'));
    $sql = "SELECT r.*, u.rental_suspended_until, u.Status as renter_account_status 
            FROM `rental_unreturned_reports` r 
            LEFT JOIN `Users` u ON r.renter_id = u.Id 
            WHERE 1=1";
    $params = [];
    if ($status !== 'All' && $status !== '') {
        $sql .= " AND r.`status` = ?";
        $params[] = strtoupper($status);
    }
    $sql .= " ORDER BY r.`id` DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $reports = $stmt->fetchAll();

    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_unreturned_reports` WHERE `status` = 'PENDING'")->fetchColumn();

    echo json_encode([
        'success' => true,
        'count' => count($reports),
        'pending_count' => $pendingCount,
        'reports' => $reports
    ]);
    exit;
}

if ($action === 'approve_unreturned_report') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $reportId = (int)($req['report_id'] ?? $req['id'] ?? 0);
    $notes = trim((string)($req['admin_notes'] ?? 'Unreturned equipment confirmed. 5-day rental suspension enforced.'));

    $stmt = $db->prepare("SELECT * FROM `rental_unreturned_reports` WHERE `id` = ?");
    $stmt->execute([$reportId]);
    $report = $stmt->fetch();
    if (!$report) {
        echo json_encode(['success' => false, 'message' => 'Report not found.']);
        exit;
    }

    $renterId = (int)$report['renter_id'];
    $renterEmail = $report['renter_email'];
    $renterName = $report['renter_name'];
    $itemName = $report['item_name'];
    $orderCode = $report['order_code'];

    // 5-Day suspension timestamp
    $suspUntil = date('Y-m-d H:i:s', strtotime('+5 days'));
    $suspReason = "Unreturned Equipment: '{$itemName}' ({$orderCode}) - 5-day suspension approved by Admin";

    // 1. Update report
    $upRpt = $db->prepare("UPDATE `rental_unreturned_reports` SET `status` = 'APPROVED', `admin_notes` = ?, `suspended_until` = ?, `reviewed_at` = NOW() WHERE `id` = ?");
    $upRpt->execute([$notes, $suspUntil, $reportId]);

    // 2. Suspend renter in Users table
    $upUser = $db->prepare("UPDATE `Users` SET `rental_suspended_until` = ?, `rental_suspension_reason` = ?, `rental_suspension_report_id` = ? WHERE `Id` = ? OR LOWER(`Email`) = LOWER(?)");
    $upUser->execute([$suspUntil, $suspReason, $reportId, $renterId, $renterEmail]);

    // 3. Update order status
    $db->prepare("UPDATE `rental_orders` SET `order_status` = 'REPORTED_UNRETURNED' WHERE `order_code` = ?")
        ->execute([$orderCode]);

    // 4. Update corresponding rental_issues ticket if exists
    try {
        $db->prepare("UPDATE `rental_issues` SET `status` = 'RESOLVED', `status_display` = 'Approved & Suspended (5 Days)', `resolution_notes` = ? WHERE `order_code` = ?")
            ->execute([$notes, $orderCode]);
    } catch (Exception $eIss) {}

    // 5. Post notification message in ChatMessages
    try {
        $notif = "🚨 ADMIN DECISION: Unreturned equipment report against {$renterName} for '{$itemName}' was APPROVED by Admin. Renter is SUSPENDED from renting any items for 5 days (until " . date('M d, Y h:i A', strtotime($suspUntil)) . "). An appeal may be submitted.";
        $db->prepare("INSERT INTO `ChatMessages` (`SenderId`, `ReceiverId`, `SenderName`, `MessageText`, `ItemTitle`) VALUES (100, ?, 'RentEase Admin Moderation', ?, ?)")
            ->execute([$renterId, $notif, $itemName]);
    } catch (Exception $eC) {}

    echo json_encode([
        'success' => true,
        'suspended_until' => date('M d, Y h:i A', strtotime($suspUntil)),
        'message' => "✅ Report APPROVED! Renter '{$renterName}' has been suspended from renting items for 5 days (until " . date('M d, Y h:i A', strtotime($suspUntil)) . ")."
    ]);
    exit;
}

if ($action === 'dismiss_unreturned_report') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $reportId = (int)($req['report_id'] ?? $req['id'] ?? 0);
    $notes = trim((string)($req['admin_notes'] ?? 'Reviewed and dismissed by admin.'));

    $stmt = $db->prepare("UPDATE `rental_unreturned_reports` SET `status` = 'DISMISSED', `admin_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?");
    $stmt->execute([$notes, $reportId]);

    echo json_encode(['success' => true, 'message' => 'Report dismissed successfully.']);
    exit;
}

// ----------------------------------------------------------
// 13. RENTAL SUSPENSION APPEALS (Admin Review & Lift Ban)
// ----------------------------------------------------------
if ($action === 'get_suspension_appeals') {
    if (!$db) { echo json_encode(['success' => true, 'appeals' => []]); exit; }

    $status = trim((string)($req['status'] ?? 'All'));
    $sql = "SELECT a.*, u.rental_suspended_until, u.rental_suspension_reason 
            FROM `rental_suspension_appeals` a 
            LEFT JOIN `Users` u ON a.user_id = u.Id 
            WHERE 1=1";
    $params = [];
    if ($status !== 'All' && $status !== '') {
        $sql .= " AND a.`status` = ?";
        $params[] = strtoupper($status);
    }
    $sql .= " ORDER BY a.`id` DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $appeals = $stmt->fetchAll();

    $pendingCount = (int)$db->query("SELECT COUNT(*) FROM `rental_suspension_appeals` WHERE `status` = 'PENDING'")->fetchColumn();

    echo json_encode([
        'success' => true,
        'count' => count($appeals),
        'pending_count' => $pendingCount,
        'appeals' => $appeals
    ]);
    exit;
}

if ($action === 'decide_suspension_appeal') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }
    $appealId = (int)($req['appeal_id'] ?? $req['id'] ?? 0);
    $decision = strtoupper(trim((string)($req['decision'] ?? 'APPROVED'))); // APPROVED or REJECTED
    $notes = trim((string)($req['admin_notes'] ?? ''));

    $stmt = $db->prepare("SELECT * FROM `rental_suspension_appeals` WHERE `id` = ?");
    $stmt->execute([$appealId]);
    $appeal = $stmt->fetch();
    if (!$appeal) {
        echo json_encode(['success' => false, 'message' => 'Appeal not found.']);
        exit;
    }

    $userId = (int)$appeal['user_id'];
    $userEmail = $appeal['user_email'];
    $userName = $appeal['user_name'];

    if ($decision === 'APPROVED') {
        // Approve appeal & lift suspension immediately!
        $db->prepare("UPDATE `rental_suspension_appeals` SET `status` = 'APPROVED', `admin_decision_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?")
            ->execute([$notes, $appealId]);

        $db->prepare("UPDATE `Users` SET `rental_suspended_until` = NULL, `rental_suspension_reason` = NULL WHERE `Id` = ? OR LOWER(`Email`) = LOWER(?)")
            ->execute([$userId, $userEmail]);

        // Post chat notice
        try {
            $notif = "✅ APPEAL APPROVED: Your appeal was reviewed and APPROVED by Admin. Your 5-day rental suspension has been lifted immediately. You may now rent equipment again.";
            $db->prepare("INSERT INTO `ChatMessages` (`SenderId`, `ReceiverId`, `SenderName`, `MessageText`, `ItemTitle`) VALUES (100, ?, 'RentEase Admin Moderation', ?, 'Rental Reinstated')")
                ->execute([$userId, $notif]);
        } catch (Exception $eC) {}

        echo json_encode([
            'success' => true,
            'message' => "✅ Appeal APPROVED! 5-day suspension for '{$userName}' has been lifted immediately."
        ]);
        exit;
    } else {
        $db->prepare("UPDATE `rental_suspension_appeals` SET `status` = 'REJECTED', `admin_decision_notes` = ?, `reviewed_at` = NOW() WHERE `id` = ?")
            ->execute([$notes, $appealId]);

        echo json_encode([
            'success' => true,
            'message' => "❌ Appeal for '{$userName}' was REJECTED. The 5-day suspension remains in effect."
        ]);
        exit;
    }
}

// ----------------------------------------------------------
// 14. PURGE DUMMY DATA & CLEAN DATABASE
// ----------------------------------------------------------
if ($action === 'purge_dummy_data' || $action === 'clean_database') {
    if (!$db) { echo json_encode(['success' => false, 'message' => 'No database']); exit; }

    try {
        $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

        // 1. Purge chat messages
        try { $db->exec("DELETE FROM `ChatMessages`;"); } catch (Exception $e) {}
        try { $db->exec("ALTER TABLE `ChatMessages` AUTO_INCREMENT = 1;"); } catch (Exception $e) {}

        // 2. Purge marketplace listings, photos, wanted posts, payments, audit logs, orders
        try { $db->exec("DELETE FROM `ListingImages`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `Listings`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `PaymentRecords`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `Reports`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `WantedPosts`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `AuditLogs`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `OtpVerifications`;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `Orders`;"); } catch (Exception $e) {}

        // 3. Purge rental orders, items, tickets, packages, transactions
        try { $db->exec("DELETE FROM `rental_order_items` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_orders` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_issues` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_transactions` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_packages` WHERE 1=1;"); } catch (Exception $e) {}

        // 4. Purge rental moderation reports & appeals (3-strike and 5-day suspension systems)
        try { $db->exec("DELETE FROM `rental_unreturned_reports` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_suspension_appeals` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_item_reports` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `rental_item_appeals` WHERE 1=1;"); } catch (Exception $e) {}

        // 5. Purge dummy delivery drivers & verification requests
        try { $db->exec("DELETE FROM `rental_drivers` WHERE 1=1;"); } catch (Exception $e) {}
        try { $db->exec("DELETE FROM `VerificationRequests` WHERE 1=1;"); } catch (Exception $e) {}

        // 6. Reset Users (Keep ONLY Admin 100, Romeo 104, Pogilameg 105)
        $db->exec("DELETE FROM `Users` WHERE `Id` NOT IN (100, 104, 105);");
        $db->exec("UPDATE `Users` SET 
            `rental_suspended_until` = NULL, 
            `rental_suspension_reason` = NULL, 
            `rental_suspension_report_id` = NULL, 
            `Status` = 'VERIFIED' 
            WHERE `Id` IN (100, 104, 105);");

        // Ensure Admin, Romeo & Pogilameg exist with clean credentials
        $hashPogilameg = password_hash('Pogilameg@10', PASSWORD_DEFAULT);
        
        $stmtUser = $db->prepare("INSERT INTO `Users` (`Id`, `Email`, `PasswordHash`, `Role`, `Status`, `CreatedAt`, `UpdatedAt`) VALUES 
            (100, 'admin', 'Pogilameg@10', 'ADMIN', 'VERIFIED', NOW(), NOW()),
            (104, 'romeopaolotolentino@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW()),
            (105, 'pogilameg@gmail.com', ?, 'STUDENT', 'VERIFIED', NOW(), NOW())
            ON DUPLICATE KEY UPDATE `PasswordHash` = VALUES(`PasswordHash`), `Role` = VALUES(`Role`), `Status` = 'VERIFIED', `rental_suspended_until` = NULL, `rental_suspension_reason` = NULL, `rental_suspension_report_id` = NULL");
        $stmtUser->execute([$hashPogilameg, $hashPogilameg]);

        // 7. Clean StudentProfiles (Keep Romeo 104 and Pogilameg 105)
        $db->exec("DELETE FROM `StudentProfiles` WHERE `UserId` NOT IN (104, 105);");
        $db->exec("INSERT INTO `StudentProfiles` (`Id`, `UserId`, `FirstName`, `LastName`, `StudentNumber`, `PhoneNumber`, `SchoolEmail`, `Course`, `YearLevel`, `ProfileImage`, `VerificationStatus`, `Rating`, `CompletedTransactions`, `CreatedAt`, `UpdatedAt`) VALUES 
            (2, 104, 'Romeo Paolo', 'Tolentino', '20261048', '09668257301', 'romeopaolotolentino@gmail.com', 'BSIT', '4th Yr', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80', 'VERIFIED', 5.0, 12, NOW(), NOW()),
            (3, 105, 'Pogilameg', 'Tester', '20261058', '09171234567', 'pogilameg@gmail.com', 'BSCS', '3rd Yr', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80', 'VERIFIED', 5.0, 8, NOW(), NOW())
            ON DUPLICATE KEY UPDATE `FirstName` = VALUES(`FirstName`), `LastName` = VALUES(`LastName`), `StudentNumber` = VALUES(`StudentNumber`), `PhoneNumber` = VALUES(`PhoneNumber`), `VerificationStatus` = 'VERIFIED'");

        // Deduplicate StudentProfiles
        try {
            $db->exec("DELETE p1 FROM `StudentProfiles` p1 INNER JOIN `StudentProfiles` p2 WHERE p1.Id > p2.Id AND p1.UserId = p2.UserId;");
        } catch (Exception $e) {}

        // 8. Clean POSPT in rental_inventory (Reset strikes, termination, and rented count)
        try {
            $db->exec("UPDATE `rental_inventory` SET 
                `status` = 'ACTIVE', 
                `approved_reports_count` = 0, 
                `termination_reason` = NULL, 
                `terminated_at` = NULL, 
                `qty_rented` = 0, 
                `qty_available` = `qty_total`
                WHERE 1=1;");
        } catch (Exception $e) {}

        $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

        echo json_encode([
            'success' => true,
            'message' => '🧹 Database purged successfully! Cleared dummy orders, tickets, reports, appeals, drivers, users, chats, and records. Clean operational state restored!'
        ]);
        exit;
    } catch (Exception $ex) {
        echo json_encode(['success' => false, 'error' => $ex->getMessage()]);
        exit;
    }
}

// Fallback unknown action
echo json_encode(['success' => false, 'message' => "Unknown action '{$action}'."]);
exit;

