<?php
/**
 * RentEase Central Mailer & Automated Step-by-Step Notification Engine
 * Sends beautifully designed HTML emails to BOTH Renter and Stock Owner at every lifecycle step:
 * Step 1: Order Confirmed
 * Step 2: Preparing Equipment
 * Step 3: Looking for Rider (Broadcast)
 * Step 4: Rider Accepted (Driver En Route to Hub)
 * Step 5: Package Picked Up (Verified Proof of Pickup Photo)
 * Step 6: Delivered & Verified (Verified Proof of Delivery Photo)
 */

if (!function_exists('send_rentease_email')) {
    function send_rentease_email($toEmail, $toName, $subject, $htmlBody) {
        if (empty($toEmail)) return false;
        
        $mailerDir = __DIR__;
        if (!file_exists($mailerDir . '/class.phpmailer.php')) {
            $mailerDir = dirname(__DIR__);
        }
        
        if (file_exists($mailerDir . '/class.phpmailer.php') && file_exists($mailerDir . '/class.smtp.php')) {
            require_once $mailerDir . '/class.phpmailer.php';
            require_once $mailerDir . '/class.smtp.php';
            try {
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'] ?? 'smtp.hostinger.com';
                $mail->Port = (int)($_ENV['SMTP_PORT'] ?? 587);
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = $_ENV['SMTP_SECURE'] ?? 'tls';
                $mail->SMTPAutoTLS = true;
                $mail->Timeout = 10;

                $mail->Username = $_ENV['SMTP_USER'] ?? 'PASABUY@pasabuy.site';
                $mail->Password = $_ENV['SMTP_PASS'] ?? 'Vanossgaming@10';

                $mail->setFrom($mail->Username, 'RentEase Fleet Logistics');
                $mail->addAddress($toEmail, $toName ?: 'Valued Customer');
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $htmlBody;

                return $mail->send();
            } catch (Exception $e) {
                // continue to fallback
            }
        }

        // Native mail() fallback
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: RentEase Fleet Logistics <PASABUY@pasabuy.site>\r\n";
        return @mail($toEmail, $subject, $htmlBody, $headers);
    }
}

if (!function_exists('get_step_email_html')) {
    function get_step_email_html($stepBadge, $title, $recipientName, $message, $order, $nextStepText, $proofPhoto = '', $proofNote = '') {
        $orderCode = htmlspecialchars($order['order_code'] ?? 'Order');
        $customerName = htmlspecialchars($order['customer_name'] ?? 'Renter');
        $ownerName = htmlspecialchars($order['owner_name'] ?? 'Equipment Owner');
        $dest = htmlspecialchars($order['delivery_address'] ?? 'San Pablo City, Laguna');
        $startDate = htmlspecialchars($order['rental_start_date'] ?? 'Upcoming');
        $days = (int)($order['rental_days'] ?? 1);
        $total = number_format((float)($order['total_amount'] ?? 0), 2);
        $year = date('Y');

        $photoHtml = '';
        if (!empty($proofPhoto)) {
            $photoHtml = "
            <div style='margin: 18px 0;'>
                <div style='font-size: 13px; font-weight: 700; color: #CBD5E1; margin-bottom: 8px;'>📸 Handover Verification Photo:</div>
                <div style='text-align: center; background: #0F172A; border-radius: 12px; overflow: hidden; border: 1px solid #334155; padding: 6px;'>
                    <img src='" . htmlspecialchars($proofPhoto) . "' alt='Verification Photo' style='max-width: 100%; height: auto; border-radius: 8px; max-height: 240px; object-fit: cover;'>
                </div>
                " . (!empty($proofNote) ? "<p style='font-size: 12px; color: #94A3B8; font-style: italic; margin-top: 6px;'>Verification Note: " . htmlspecialchars($proofNote) . "</p>" : "") . "
            </div>";
        }

        return "
        <div style='font-family: Arial, sans-serif; background-color: #0F172A; padding: 25px; color: #F8FAFC;'>
            <div style='max-width: 540px; margin: 0 auto; background: #1E293B; border-radius: 16px; border: 1px solid #334155; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);'>
                <div style='background: linear-gradient(135deg, #5B3FA8, #341F97); padding: 22px 20px; text-align: center;'>
                    <h2 style='color: #ffffff; margin: 0; font-size: 21px; font-weight: 800;'>🚚 RentEase Campus Logistics</h2>
                    <p style='color: #E2E8F0; font-size: 13px; margin: 5px 0 0 0;'>Live Order Workflow Notification</p>
                </div>
                <div style='padding: 24px 20px;'>
                    <div style='display:inline-block; background:rgba(91,63,168,0.25); border:1px solid #7C3AED; color:#DDD6FE; font-size:11px; font-weight:800; padding:4px 10px; border-radius:20px; text-transform:uppercase; margin-bottom:12px;'>
                        {$stepBadge}
                    </div>
                    <h3 style='color: #F8FAFC; margin-top: 0; font-size: 18px; margin-bottom:12px;'>{$title}</h3>
                    <p style='font-size: 15px; color: #F8FAFC; margin-top: 0;'>Hello <strong>" . htmlspecialchars($recipientName) . "</strong>,</p>
                    <p style='font-size: 14px; color: #CBD5E1; line-height: 1.6;'>{$message}</p>

                    <div style='background: #0F172A; border-radius: 12px; border: 1px solid #334155; padding: 14px; margin: 18px 0;'>
                        <div style='font-size: 12px; font-weight: 700; color: #A78BFA; text-transform: uppercase; margin-bottom: 8px;'>📋 Order Details:</div>
                        <div style='font-size: 13px; color: #CBD5E1; margin-bottom: 4px;'><strong>Order Number:</strong> {$orderCode}</div>
                        <div style='font-size: 13px; color: #CBD5E1; margin-bottom: 4px;'><strong>Renter:</strong> {$customerName}</div>
                        <div style='font-size: 13px; color: #CBD5E1; margin-bottom: 4px;'><strong>Equipment Stock Owner:</strong> {$ownerName}</div>
                        <div style='font-size: 13px; color: #CBD5E1; margin-bottom: 4px;'><strong>Event Date:</strong> {$startDate} ({$days} day)</div>
                        <div style='font-size: 13px; color: #CBD5E1; margin-bottom: 4px;'><strong>Delivery Address:</strong> {$dest}</div>
                        <div style='font-size: 13px; color: #CBD5E1;'><strong>Total Amount:</strong> ₱{$total}</div>
                    </div>

                    {$photoHtml}

                    <div style='background: rgba(91, 63, 168, 0.15); border: 1px solid #5B3FA8; border-radius: 12px; padding: 12px; margin: 18px 0;'>
                        <div style='font-size: 12px; color: #E2E8F0;'><strong>Next Step in Workflow:</strong> {$nextStepText}</div>
                    </div>

                    <p style='font-size: 12px; color: #94A3B8; line-height: 1.5;'>You can view live status, driver location, and photo evidence on your RentEase tracking screen anytime.</p>
                    <hr style='border: 0; border-top: 1px solid #334155; margin: 20px 0;'>
                    <p style='font-size: 11px; color: #64748B; text-align: center; margin: 0;'>&copy; {$year} RentEase Logistics &bull; Campus Equipment Marketplace</p>
                </div>
            </div>
        </div>";
    }
}

if (!function_exists('send_rental_step_emails')) {
    function send_rental_step_emails($order, $stepName, $extraData = []) {
        if (!$order || empty($order['order_code'])) return;

        $orderCode = $order['order_code'];
        $renterName = $order['customer_name'] ?: 'Valued Student';
        $renterEmail = $order['customer_email'] ?: 'pogilameg@gmail.com';
        $ownerName = $order['owner_name'] ?: 'Romeo Paolo Tolentino';
        $ownerEmail = $order['owner_email'] ?: 'romeopaolotolentino@gmail.com';
        $deliveryAddress = $order['delivery_address'] ?: 'San Pablo City, Laguna';
        $riderName = $extraData['rider_name'] ?? ($order['assigned_rider_name'] ?: ($order['rider_name'] ?: ''));
        $riderPhone = $extraData['rider_phone'] ?? ($order['assigned_rider_phone'] ?: ($order['rider_phone'] ?: ''));
        $riderVehicle = $extraData['rider_vehicle'] ?? ($order['rider_vehicle'] ?: ($order['delivery_vehicle_type'] ?: 'Honda Click 125i (MC-8888-JY)'));
        $proofPhoto = $extraData['proof_photo'] ?? ($order['pickup_proof_photo'] ?? ($order['delivery_proof_photo'] ?? ''));
        $proofNote = $extraData['proof_note'] ?? ($order['pickup_proof_note'] ?? ($order['delivery_proof_note'] ?? ''));

        switch ($stepName) {
            case 'STEP_1_ORDER_CONFIRMED':
                // Renter Email
                $subRenter = "🎉 Rental Order Confirmed: {$orderCode} (Step 1/6)";
                $bodyRenter = get_step_email_html(
                    "Step 1 of 6: Order Confirmed",
                    "Your Rental Booking Has Been Confirmed",
                    $renterName,
                    "Your rental booking for <strong>Order {$orderCode}</strong> has been successfully placed and confirmed! We have alerted stock owner <strong>{$ownerName}</strong> to accept your order and begin preparing the equipment.",
                    $order,
                    "Step 2: Preparing Equipment (Stock owner inspection & packaging)"
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "🔔 New Rental Order Booking: {$orderCode} (Step 1/6)";
                $bodyOwner = get_step_email_html(
                    "Step 1 of 6: New Booking Alert",
                    "New Equipment Rental Request Received",
                    $ownerName,
                    "Student renter <strong>{$renterName}</strong> has placed an order (<strong>{$orderCode}</strong>) for your listed equipment. Please log in to your RentEase dashboard to accept the booking and begin equipment inspection & packaging.",
                    $order,
                    "Step 2: Accept Booking in Dashboard & Begin Packaging"
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;

            case 'STEP_2_PREPARING':
                // Renter Email
                $subRenter = "🛠️ Order in Process: Equipment Being Prepared for Order {$orderCode} (Step 2/6)";
                $bodyRenter = get_step_email_html(
                    "Step 2 of 6: Preparing Equipment",
                    "Equipment Quality Inspection & Packing Underway",
                    $renterName,
                    "Great news! Stock owner <strong>{$ownerName}</strong> has accepted your rental request. Your equipment is currently undergoing quality inspection, cleaning, testing, and packaging.",
                    $order,
                    "Step 3: Stock owner requests courier dispatch"
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "✅ Preparation Active: Order {$orderCode} (Step 2/6)";
                $bodyOwner = get_step_email_html(
                    "Step 2 of 6: Equipment Preparation",
                    "Equipment Packaging in Progress",
                    $ownerName,
                    "You have accepted rental order <strong>{$orderCode}</strong> for <strong>{$renterName}</strong>. Please ensure all accessories and cabling are included and safely packed. Once packed, click 'Notify Delivery Rider'.",
                    $order,
                    "Step 3: Broadcast Delivery Dispatch to Fleet"
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;

            case 'STEP_3_LOOKING_FOR_RIDER':
                // Renter Email
                $subRenter = "📢 Courier Broadcast: Order {$orderCode} Ready for Pickup (Step 3/6)";
                $bodyRenter = get_step_email_html(
                    "Step 3 of 6: Looking for Courier",
                    "Equipment Packaged & Dispatching to Drivers",
                    $renterName,
                    "Your equipment for <strong>Order {$orderCode}</strong> has been safely packaged and sealed by stock owner <strong>{$ownerName}</strong>. A pickup dispatch broadcast has been sent to nearby fleet riders.",
                    $order,
                    "Step 4: Driver accepts job and heads to hub"
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "📡 Driver Broadcast Active: Order {$orderCode} (Step 3/6)";
                $bodyOwner = get_step_email_html(
                    "Step 3 of 6: Courier Broadcast",
                    "Searching for Nearby Fleet Courier",
                    $ownerName,
                    "You have marked <strong>Order {$orderCode}</strong> ready for pickup. Nearby fleet delivery drivers are receiving the dispatch request to collect from your hub location.",
                    $order,
                    "Step 4: Rider acceptance and transit to your hub"
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;

            case 'STEP_4_RIDER_ACCEPTED':
                // Renter Email
                $subRenter = "🏍️ Driver Assigned: Rider En Route for Order {$orderCode} (Step 4/6)";
                $bodyRenter = get_step_email_html(
                    "Step 4 of 6: Driver Assigned",
                    "Courier Heading to Hub for Collection",
                    $renterName,
                    "Fleet courier <strong>{$riderName}</strong> ({$riderPhone} &bull; {$riderVehicle}) has accepted the delivery assignment for <strong>Order {$orderCode}</strong> and is currently en route to the hub for pickup.",
                    $order,
                    "Step 5: Package pickup with photo proof"
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "🏍️ Courier Arriving for Pickup: Order {$orderCode} (Step 4/6)";
                $bodyOwner = get_step_email_html(
                    "Step 4 of 6: Driver En Route",
                    "Courier On The Way to Your Hub",
                    $ownerName,
                    "Fleet courier <strong>{$riderName}</strong> ({$riderPhone} &bull; {$riderVehicle}) has accepted order <strong>{$orderCode}</strong> and is driving to your hub location. Please prepare to hand over the package and conduct physical verification.",
                    $order,
                    "Step 5: Driver takes Proof of Pickup photo"
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;

            case 'STEP_5_PICKUP_COMPLETE':
                // Renter Email
                $subRenter = "🚚 Package Picked Up: Order {$orderCode} Out for Delivery (Step 5/6)";
                $bodyRenter = get_step_email_html(
                    "Step 5 of 6: Package Picked Up",
                    "Equipment Inspected & En Route to You",
                    $renterName,
                    "Fleet courier <strong>{$riderName}</strong> has completed physical inspection and collected your equipment package from stock owner <strong>{$ownerName}</strong>. Live GPS route tracking is now active!",
                    $order,
                    "Step 6: Handover at destination and Proof of Delivery verification",
                    $proofPhoto,
                    $proofNote
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "📦 Handover Complete: Package Collected for Order {$orderCode} (Step 5/6)";
                $bodyOwner = get_step_email_html(
                    "Step 5 of 6: Equipment Collected",
                    "Package Successfully Handed Over to Courier",
                    $ownerName,
                    "Fleet courier <strong>{$riderName}</strong> has safely collected the equipment for order <strong>{$orderCode}</strong> with verified Proof of Pickup photo. The order is now en route to renter <strong>{$renterName}</strong>.",
                    $order,
                    "Step 6: Safe delivery and renter receipt confirmation",
                    $proofPhoto,
                    $proofNote
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;

            case 'STEP_6_DELIVERED':
                // Renter Email
                $subRenter = "🎉 Equipment Delivered! Order {$orderCode} Complete (Step 6/6)";
                $bodyRenter = get_step_email_html(
                    "Step 6 of 6: Delivered & Verified",
                    "Rental Equipment Successfully Delivered",
                    $renterName,
                    "Your rental equipment for <strong>Order {$orderCode}</strong> has been successfully delivered by <strong>{$riderName}</strong> to your delivery address: <em>{$deliveryAddress}</em>. Verified Proof of Delivery has been recorded.",
                    $order,
                    "Rental Active &bull; Return scheduled at end of rental period",
                    $proofPhoto,
                    $proofNote
                );
                send_rentease_email($renterEmail, $renterName, $subRenter, $bodyRenter);

                // Stock Owner Email
                $subOwner = "🎉 Equipment Successfully Delivered: Order {$orderCode} (Step 6/6)";
                $bodyOwner = get_step_email_html(
                    "Step 6 of 6: Delivered & Verified",
                    "Equipment Safely Received by Renter",
                    $ownerName,
                    "Great news! Your rental equipment for <strong>Order {$orderCode}</strong> has been safely delivered to <strong>{$renterName}</strong> by courier <strong>{$riderName}</strong> with verified photo proof.",
                    $order,
                    "Rental Active &bull; Return scheduled at end of rental period",
                    $proofPhoto,
                    $proofNote
                );
                send_rentease_email($ownerEmail, $ownerName, $subOwner, $bodyOwner);
                break;
        }
    }
}
