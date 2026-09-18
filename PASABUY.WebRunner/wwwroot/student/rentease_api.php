<?php
// ==========================================================
// RentEase Backend Engine & Computation API
// "Easy Rentals. Seamless Events." | "Rent. Book. Celebrate."
// ==========================================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

date_default_timezone_set('Asia/Manila');

function getRentEaseDb() {
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
            return new PDO("mysql:host=localhost;dbname={$dbName};charset=utf8mb4", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (Exception $e2) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e2->getMessage()]);
            exit;
        }
    }
}

$db = getRentEaseDb();

$inputRaw = file_get_contents('php://input');
$data = json_decode($inputRaw, true) ?: $_REQUEST;

$action = trim((string)($data['action'] ?? $_GET['action'] ?? 'get_inventory'));

// ----------------------------------------------------------
// 1. GET INVENTORY & CATALOG (Screen 1 & Screen 2)
// ----------------------------------------------------------
if ($action === 'get_inventory') {
    $category = trim((string)($data['category'] ?? 'All'));
    $materialTag = trim((string)($data['tag'] ?? 'All'));
    $search = trim((string)($data['search'] ?? ''));

    $sql = "SELECT * FROM `rental_inventory` WHERE 1=1";
    $params = [];

    if ($category !== '' && $category !== 'All') {
        $sql .= " AND `category` = ?";
        $params[] = $category;
    }

    if ($materialTag !== '' && $materialTag !== 'All') {
        $sql .= " AND `material_tag` = ?";
        $params[] = $materialTag;
    }

    if ($search !== '') {
        $sql .= " AND (`name` LIKE ? OR `description` LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }

    $sql .= " ORDER BY `is_featured` DESC, `id` ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'count' => count($items),
        'items' => $items
    ]);
    exit;
}

// ----------------------------------------------------------
// 2. GET PRODUCT DETAIL (Screen 3)
// ----------------------------------------------------------
if ($action === 'get_product_detail') {
    $id = (int)($data['id'] ?? 0);
    $stmt = $db->prepare("SELECT * FROM `rental_inventory` WHERE `id` = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if (!$item) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Equipment item not found.']);
        exit;
    }

    echo json_encode([
        'success' => true,
        'item' => $item
    ]);
    exit;
}

// ----------------------------------------------------------
// 3. GET PACKAGES (Marketing Strategy - 10%)
// ----------------------------------------------------------
if ($action === 'get_packages') {
    $stmt = $db->query("SELECT * FROM `rental_packages` ORDER BY `id` ASC");
    $packages = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'packages' => $packages
    ]);
    exit;
}

// ----------------------------------------------------------
// 4. COMPUTATION MODULE (Screen 4 & Screen 6)
// Rental Subtotal + Service Charge + Delivery Fee - Discount = Total
// ----------------------------------------------------------
if ($action === 'calculate_charges') {
    $items = $data['items'] ?? [];
    $deliveryOption = strtoupper(trim((string)($data['delivery_option'] ?? 'DELIVERY')));
    $discountCode = trim((string)($data['discount_code'] ?? ''));

    $subtotal = 0.00;
    foreach ($items as $it) {
        $price = (float)($it['price_per_day'] ?? $it['price'] ?? 0);
        $qty = max(1, (int)($it['quantity'] ?? $it['qty'] ?? 1));
        $days = max(1, (int)($it['rental_days'] ?? $it['days'] ?? 1));
        $subtotal += ($price * $qty * $days);
    }

    $serviceCharge = $subtotal > 0 ? 100.00 : 0.00;
    $deliveryFee = ($deliveryOption === 'DELIVERY' && $subtotal > 0) ? 150.00 : 0.00;
    
    // Auto discount threshold or promo code
    $discount = 0.00;
    if ($discountCode === 'RENTEASE50' || $subtotal >= 1000) {
        $discount = 50.00;
    }
    if ($discountCode === 'EVENT200' || $subtotal >= 1500) {
        $discount = 200.00;
    }

    $total = max(0.00, ($subtotal + $serviceCharge + $deliveryFee - $discount));

    echo json_encode([
        'success' => true,
        'computation' => [
            'subtotal' => round($subtotal, 2),
            'service_charge' => round($serviceCharge, 2),
            'delivery_fee' => round($deliveryFee, 2),
            'discount' => round($discount, 2),
            'total' => round($total, 2),
            'delivery_option' => $deliveryOption,
            'breakdown_label' => "Rental Subtotal (₱" . number_format($subtotal, 2) . ") + Service Charge (₱" . number_format($serviceCharge, 2) . ") + Delivery Fee (₱" . number_format($deliveryFee, 2) . ") - Discount (₱" . number_format($discount, 2) . ") = ₱" . number_format($total, 2)
        ]
    ]);
    exit;
}

// ----------------------------------------------------------
// 5. CREATE ORDER & CHECKOUT (Screen 5 & Screen 6)
// ----------------------------------------------------------
if ($action === 'create_order') {
    $customerName = trim((string)($data['customer_name'] ?? 'Bea Solis'));
    $customerEmail = trim((string)($data['customer_email'] ?? 'bea@gmail.com'));
    $customerPhone = trim((string)($data['customer_phone'] ?? '09171234567'));
    $deliveryOption = strtoupper(trim((string)($data['delivery_option'] ?? 'DELIVERY')));
    $deliveryAddress = trim((string)($data['delivery_address'] ?? 'San Pablo, Laguna'));
    $rentalStartDate = trim((string)($data['rental_start_date'] ?? date('Y-m-d', strtotime('+7 days'))));
    $paymentMethod = strtoupper(trim((string)($data['payment_method'] ?? 'GCASH')));
    $items = $data['items'] ?? [];

    if (empty($items)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Your cart is empty. Please add equipment items.']);
        exit;
    }

    // Compute verified totals
    $subtotal = 0.00;
    foreach ($items as $it) {
        $price = (float)($it['price_per_day'] ?? $it['price'] ?? 0);
        $qty = max(1, (int)($it['quantity'] ?? $it['qty'] ?? 1));
        $subtotal += ($price * $qty);
    }
    $serviceCharge = 100.00;
    $deliveryFee = ($deliveryOption === 'DELIVERY') ? 150.00 : 0.00;
    $discount = $subtotal >= 1500 ? 200.00 : ($subtotal >= 1000 ? 50.00 : 0.00);
    $total = max(0.00, $subtotal + $serviceCharge + $deliveryFee - $discount);

    // Generate Order Code
    $randomCode = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
    $orderCode = "#RE-" . (10000 + rand(100, 999));

    $db->beginTransaction();
    try {
        $stmt = $db->prepare("INSERT INTO `rental_orders` 
            (`order_code`, `customer_name`, `customer_email`, `customer_phone`, `delivery_option`, `delivery_address`, `rental_start_date`, `subtotal`, `service_charge`, `delivery_fee`, `discount`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `estimated_arrival`, `assigned_rider_name`, `assigned_rider_phone`, `rider_current_lat`, `rider_current_lng`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'PAID', 'CONFIRMED', '4:30 PM', 'Juan Dela Cruz', '09187654321', 14.65150000, 121.06920000)");
        $stmt->execute([
            $orderCode, $customerName, $customerEmail, $customerPhone, $deliveryOption,
            $deliveryAddress, $rentalStartDate, $subtotal, $serviceCharge, $deliveryFee,
            $discount, $total, $paymentMethod
        ]);
        $orderId = $db->lastInsertId();

        $itemStmt = $db->prepare("INSERT INTO `rental_order_items` (`order_id`, `product_id`, `product_name`, `price_per_day`, `quantity`, `subtotal`) VALUES (?, ?, ?, ?, ?, ?)");
        $updStockStmt = $db->prepare("UPDATE `rental_inventory` SET `qty_available` = GREATEST(0, `qty_available` - ?), `qty_rented` = `qty_rented` + ? WHERE `id` = ?");

        foreach ($items as $it) {
            $productId = (int)($it['id'] ?? 0);
            $pName = (string)($it['title'] ?? $it['name'] ?? 'Rental Item');
            $pPrice = (float)($it['price_per_day'] ?? $it['price'] ?? 0);
            $pQty = (int)($it['quantity'] ?? $it['qty'] ?? 1);
            $pSub = $pPrice * $pQty;

            $itemStmt->execute([$orderId, $productId, $pName, $pPrice, $pQty, $pSub]);
            if ($productId > 0) {
                $updStockStmt->execute([$pQty, $pQty, $productId]);
            }
        }

        $db->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Order successfully booked & confirmed!',
            'order_id' => $orderId,
            'order_code' => $orderCode,
            'total_amount' => $total,
            'payment_method' => $paymentMethod
        ]);
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Order booking failed: ' . $e->getMessage()]);
        exit;
    }
}

// ----------------------------------------------------------
// 6. ORDER TRACKING & LIVE GPS MAP (Screen 7 - Standout Feature)
// ----------------------------------------------------------
if ($action === 'get_order_tracking') {
    $orderCode = trim((string)($data['order_code'] ?? '#RE-10245'));

    $stmt = $db->prepare("SELECT * FROM `rental_orders` WHERE `order_code` = ? LIMIT 1");
    $stmt->execute([$orderCode]);
    $order = $stmt->fetch();

    if (!$order) {
        // Fallback to latest order
        $stmt2 = $db->query("SELECT * FROM `rental_orders` ORDER BY `id` DESC LIMIT 1");
        $order = $stmt2->fetch();
    }

    if (!$order) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No active order found for tracking.']);
        exit;
    }

    $orderItemsStmt = $db->prepare("SELECT * FROM `rental_order_items` WHERE `order_id` = ?");
    $orderItemsStmt->execute([$order['id']]);
    $items = $orderItemsStmt->fetchAll();

    // Route coordinates for Leaflet map polyline
    $warehouseCoords = [14.64880, 121.06870]; // RentEase Hub
    $riderCoords = [(float)$order['rider_current_lat'], (float)$order['rider_current_lng']];
    $destinationCoords = [14.65400, 121.07450]; // San Pablo, Laguna dropoff

    echo json_encode([
        'success' => true,
        'order' => $order,
        'items' => $items,
        'tracking' => [
            'order_code' => $order['order_code'],
            'order_status' => $order['order_status'],
            'estimated_arrival' => $order['estimated_arrival'],
            'rider' => [
                'name' => $order['assigned_rider_name'],
                'phone' => $order['assigned_rider_phone'],
                'role' => 'Delivery Rider',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80',
                'vehicle' => 'Honda Click 125i (MC-8888-JY)',
                'lat' => (float)$order['rider_current_lat'],
                'lng' => (float)$order['rider_current_lng']
            ],
            'locations' => [
                'warehouse' => $warehouseCoords,
                'rider' => $riderCoords,
                'destination' => $destinationCoords
            ],
            'stages' => [
                ['key' => 'CONFIRMED', 'title' => 'Order Confirmed', 'time' => 'May 25, 2026 • 10:30 AM', 'completed' => true],
                ['key' => 'PREPARING', 'title' => 'Preparing Equipment', 'time' => 'May 25, 2026 • 12:00 PM', 'completed' => in_array($order['order_status'], ['PREPARING', 'PICKUP', 'ON_THE_WAY', 'DELIVERED'])],
                ['key' => 'PICKUP', 'title' => 'Pickup', 'time' => 'May 25, 2026 • 2:00 PM', 'completed' => in_array($order['order_status'], ['PICKUP', 'ON_THE_WAY', 'DELIVERED'])],
                ['key' => 'ON_THE_WAY', 'title' => 'On the Way', 'time' => 'Estimated Arrival: ' . $order['estimated_arrival'], 'completed' => in_array($order['order_status'], ['ON_THE_WAY', 'DELIVERED']), 'current' => ($order['order_status'] === 'ON_THE_WAY')],
                ['key' => 'DELIVERED', 'title' => 'Delivered', 'time' => 'Pending dropoff verification', 'completed' => ($order['order_status'] === 'DELIVERED')]
            ]
        ]
    ]);
    exit;
}

// ----------------------------------------------------------
// 7. ISSUE MONITORING & CUSTOMER SUPPORT (Customer Support - 10%)
// ----------------------------------------------------------
if ($action === 'get_issues') {
    $stmt = $db->query("SELECT * FROM `rental_issues` ORDER BY `id` ASC");
    $issues = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'issues' => $issues
    ]);
    exit;
}

if ($action === 'create_issue') {
    $orderCode = trim((string)($data['order_code'] ?? '#RE-10245'));
    $customerName = trim((string)($data['customer_name'] ?? 'Customer'));
    $issueTitle = trim((string)($data['issue_title'] ?? 'Equipment Inquiry'));
    $description = trim((string)($data['description'] ?? ''));

    $ticketNumber = "#" . (10000 + rand(200, 999));
    $stmt = $db->prepare("INSERT INTO `rental_issues` (`ticket_number`, `order_code`, `customer_name`, `issue_title`, `description`, `status`, `status_display`) VALUES (?, ?, ?, ?, ?, 'REPORTED', 'Reported')");
    $stmt->execute([$ticketNumber, $orderCode, $customerName, $issueTitle, $description]);

    echo json_encode([
        'success' => true,
        'message' => 'Issue ticket successfully filed and queued for review.',
        'ticket_number' => $ticketNumber
    ]);
    exit;
}

if ($action === 'update_issue_status') {
    $ticketNumber = trim((string)($data['ticket_number'] ?? ''));
    $status = strtoupper(trim((string)($data['status'] ?? 'REVIEWING')));

    $statusMap = [
        'REPORTED' => 'Reported',
        'REVIEWING' => 'Under Review',
        'IN_PROGRESS' => 'Solving',
        'RESOLVED' => 'Resolved'
    ];
    $display = $statusMap[$status] ?? 'Under Review';

    $stmt = $db->prepare("UPDATE `rental_issues` SET `status` = ?, `status_display` = ? WHERE `ticket_number` = ?");
    $stmt->execute([$status, $display, $ticketNumber]);

    echo json_encode([
        'success' => true,
        'message' => "Ticket {$ticketNumber} updated to {$display}."
    ]);
    exit;
}

// ----------------------------------------------------------
// 8. ADMIN MANAGEMENT DASHBOARD & ANALYTICS (Pages 5-12 of RentEase.pdf)
// ----------------------------------------------------------
if ($action === 'get_admin_dashboard') {
    // Inventory Module breakdown
    $invStmt = $db->query("SELECT `id`, `name`, `category`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `price_per_day` FROM `rental_inventory` ORDER BY `id` ASC");
    $inventory = $invStmt->fetchAll();

    // Orders summary
    $ordersStmt = $db->query("SELECT * FROM `rental_orders` ORDER BY `id` DESC LIMIT 10");
    $recentOrders = $ordersStmt->fetchAll();

    // Issues summary
    $issuesStmt = $db->query("SELECT * FROM `rental_issues` ORDER BY `id` ASC");
    $issues = $issuesStmt->fetchAll();

    // Packages
    $packagesStmt = $db->query("SELECT * FROM `rental_packages` ORDER BY `id` ASC");
    $packages = $packagesStmt->fetchAll();

    echo json_encode([
        'success' => true,
        'kpis' => [
            'sales_overview' => 125450.00,
            'total_orders' => 184,
            'total_customers' => 96,
            'active_deliveries' => 8,
            'pending_issues' => 2
        ],
        'targets' => [
            'ideal_clients_per_month' => '100–150 customers',
            'target_transactions_per_month' => '150–200 transactions',
            'online_orders_ratio' => '75% online orders',
            'assisted_orders_ratio' => '25% assisted orders'
        ],
        'inventory' => $inventory,
        'recent_orders' => $recentOrders,
        'issues' => $issues,
        'packages' => $packages
    ]);
    exit;
}

// ----------------------------------------------------------
// 9. ADMIN STOCK & EQUIPMENT OPERATIONS
// ----------------------------------------------------------
if ($action === 'admin_update_stock') {
    $id = (int)($data['id'] ?? 0);
    $qtyTotal = (int)($data['qty_total'] ?? 0);
    $qtyAvail = (int)($data['qty_available'] ?? 0);
    $qtyRented = (int)($data['qty_rented'] ?? 0);
    $qtyMaint = (int)($data['qty_maintenance'] ?? 0);
    $price = (float)($data['price_per_day'] ?? 0);

    $stmt = $db->prepare("UPDATE `rental_inventory` SET `qty_total` = ?, `qty_available` = ?, `qty_rented` = ?, `qty_maintenance` = ?, `price_per_day` = ? WHERE `id` = ?");
    $stmt->execute([$qtyTotal, $qtyAvail, $qtyRented, $qtyMaint, $price, $id]);

    echo json_encode(['success' => true, 'message' => "Inventory item #{$id} stock updated successfully."]);
    exit;
}

if ($action === 'admin_add_equipment') {
    $name = trim((string)($data['name'] ?? ''));
    $category = trim((string)($data['category'] ?? 'Chairs'));
    $materialTag = trim((string)($data['material_tag'] ?? 'Plastic'));
    $price = (float)($data['price_per_day'] ?? 50.00);
    $qtyTotal = (int)($data['qty_total'] ?? 50);
    $imgUrl = trim((string)($data['image_url'] ?? 'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=500&q=80'));
    $desc = trim((string)($data['description'] ?? 'Quality event equipment for rent.'));

    if (!$name) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Equipment name is required.']);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO `rental_inventory` (`name`, `category`, `material_tag`, `price_per_day`, `qty_total`, `qty_available`, `qty_rented`, `qty_maintenance`, `image_url`, `description`, `rating`, `reviews_count`, `min_rental_days`, `is_featured`) VALUES (?, ?, ?, ?, ?, ?, 0, 0, ?, ?, 5.0, 1, 1, 0)");
    $stmt->execute([$name, $category, $materialTag, $price, $qtyTotal, $qtyTotal, $imgUrl, $desc]);

    echo json_encode(['success' => true, 'message' => "New equipment item '{$name}' added to inventory.", 'id' => $db->lastInsertId()]);
    exit;
}

if ($action === 'admin_assign_rider' || $action === 'admin_update_order_status') {
    $orderNumber = trim((string)($data['order_number'] ?? ''));
    $riderName = trim((string)($data['rider_name'] ?? 'Juan Dela Cruz'));
    $riderPhone = trim((string)($data['rider_phone'] ?? '0917-888-9999'));
    $status = strtoupper(trim((string)($data['status'] ?? 'ON_THE_WAY')));

    $stmt = $db->prepare("UPDATE `rental_orders` SET `driver_name` = ?, `driver_phone` = ?, `order_status` = ?, `status_display` = ? WHERE `order_number` = ?");
    $displayMap = [
        'CONFIRMED' => 'Order Confirmed',
        'PREPARING' => 'Preparing Equipment',
        'PICKUP' => 'Equipment Dispatched',
        'ON_THE_WAY' => 'Out for Delivery',
        'DELIVERED' => 'Delivered'
    ];
    $display = $displayMap[$status] ?? 'Out for Delivery';
    $stmt->execute([$riderName, $riderPhone, $status, $display, $orderNumber]);

    echo json_encode(['success' => true, 'message' => "Order #{$orderNumber} updated to {$display} with rider {$riderName}."]);
    exit;
}

// ----------------------------------------------------------
// 10. RIDER FLEET DISPATCH & LIVE STAGES
// ----------------------------------------------------------
if ($action === 'rider_get_jobs') {
    $stmt = $db->query("SELECT * FROM `rental_orders` ORDER BY `id` DESC LIMIT 10");
    $orders = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'active_order' => $orders[0] ?? null,
        'broadcast_jobs' => $orders
    ]);
    exit;
}

if ($action === 'rider_update_stage') {
    $orderNumber = trim((string)($data['order_number'] ?? '#RE-10245'));
    $stage = strtoupper(trim((string)($data['stage'] ?? 'ON_THE_WAY')));
    $lat = (float)($data['lat'] ?? 14.1870);
    $lng = (float)($data['lng'] ?? 121.2650);

    $displayMap = [
        'CONFIRMED' => 'Order Confirmed',
        'PREPARING' => 'Preparing Equipment',
        'PICKUP' => 'Equipment Dispatched',
        'ON_THE_WAY' => 'Out for Delivery',
        'DELIVERED' => 'Delivered'
    ];
    $display = $displayMap[$stage] ?? 'Out for Delivery';

    $stmt = $db->prepare("UPDATE `rental_orders` SET `order_status` = ?, `status_display` = ?, `rider_current_lat` = ?, `rider_current_lng` = ? WHERE `order_number` = ?");
    $stmt->execute([$stage, $display, $lat, $lng, $orderNumber]);

    echo json_encode([
        'success' => true,
        'message' => "Order {$orderNumber} stage updated to {$display}.",
        'stage' => $stage,
        'display' => $display
    ]);
    exit;
}

// Fallback
echo json_encode(['success' => false, 'message' => "Unknown action '{$action}'."]);
exit;
