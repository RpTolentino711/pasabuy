<?php
$pdoOpts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_TIMEOUT => 2
];
$db = null;
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=u321173822_pasabuy;charset=utf8mb4", "u321173822_Pogilameg", "Pogilameg@10", $pdoOpts);
} catch (Exception $e) {
    try {
        $db = new PDO("mysql:host=127.0.0.1;dbname=pasabuy;charset=utf8mb4", "root", "", $pdoOpts);
    } catch (Exception $e2) {
        die("Connection failed: " . $e2->getMessage());
    }
}

$stmt = $db->query("SELECT id, order_code, item_name, order_status, handed_over, timer_status, rental_timer_start, rental_timer_end, has_rated, rating, owner_agreed, prep_confirmed_by_renter, meetup_location, renter_id, owner_id FROM rental_orders WHERE order_code LIKE '%23940%'");
print_r($stmt->fetchAll());
