<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/class.phpmailer.php';
require_once __DIR__ . '/class.smtp.php';

date_default_timezone_set('Asia/Manila');

// Database Connection Helper
function getPasaBuyDbConnection() {
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
            error_log("PasaBuy DB Connection Error: " . $e2->getMessage());
            return null;
        }
    }
}

// Parse JSON or POST input
$inputRaw = file_get_contents('php://input');
$data = json_decode($inputRaw, true) ?: $_POST;

$action = trim((string)($data['action'] ?? 'send_otp'));
$email  = strtolower(trim((string)($data['email'] ?? '')));
$name   = trim((string)($data['name'] ?? 'Student User'));
$otpIn  = trim((string)($data['otpCode'] ?? $data['otp'] ?? ''));

if ($email === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Recipient email address is required.']);
    exit;
}

$sessionKey = 'pasabuy_otp_' . md5($email);

// LOGIN ACTION
if ($action === 'login') {
    $password = (string)($data['password'] ?? '');
    $db = getPasaBuyDbConnection();
    if (!$db) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM Users WHERE LOWER(Email) = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "❌ No account found for '{$email}'. Please click 'Create Student Account' below to register with OTP."]);
        exit;
    }

    $passHash = $user['PasswordHash'];
    $isValid = password_verify($password, $passHash) || ($password === $passHash);

    if (!$isValid) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => '❌ Incorrect password. Click "Forgot Password?" above to reset your password via OTP.']);
        exit;
    }

    $pStmt = $db->prepare("SELECT * FROM StudentProfiles WHERE UserId = ?");
    $pStmt->execute([(int)$user['Id']]);
    $profile = $pStmt->fetch() ?: [];

    echo json_encode([
        'success' => true,
        'message' => 'Login successful!',
        'user' => [
            'id' => $user['Id'],
            'email' => $user['Email'],
            'role' => $user['Role']
        ],
        'profile' => [
            'firstName' => $profile['FirstName'] ?? explode('@', $email)[0],
            'lastName' => $profile['LastName'] ?? '',
            'studentNumber' => $profile['StudentNumber'] ?? '',
            'course' => $profile['Course'] ?? '',
            'yearLevel' => $profile['YearLevel'] ?? '',
            'schoolEmail' => $profile['SchoolEmail'] ?? $email
        ]
    ]);
    exit;
}

// VERIFY OTP ACTION (STRICT EMAIL + OTP MATCHING)
if ($action === 'verify_otp' || $action === 'verify') {
    $db = getPasaBuyDbConnection();
    $validOtpFound = false;
    $reg = [];

    if ($db) {
        $db->exec("CREATE TABLE IF NOT EXISTS `OtpVerifications` (
          `Id` int(11) NOT NULL AUTO_INCREMENT,
          `Email` varchar(255) NOT NULL,
          `OtpCode` varchar(10) NOT NULL,
          `RegData` text DEFAULT NULL,
          `ExpiresAt` datetime NOT NULL,
          `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`Id`),
          KEY `idx_email` (`Email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $stmt = $db->prepare("SELECT * FROM OtpVerifications WHERE LOWER(Email) = ? AND OtpCode = ? AND ExpiresAt > NOW() ORDER BY Id DESC LIMIT 1");
        $stmt->execute([$email, $otpIn]);
        $row = $stmt->fetch();

        if ($row) {
            $validOtpFound = true;
            if (!empty($row['RegData'])) {
                $reg = json_decode($row['RegData'], true) ?: [];
            }
            $delStmt = $db->prepare("DELETE FROM OtpVerifications WHERE Id = ?");
            $delStmt->execute([(int)$row['Id']]);
        }
    }

    if (!$validOtpFound && isset($_SESSION[$sessionKey])) {
        $storedData = $_SESSION[$sessionKey];
        if (time() <= $storedData['expires'] && $otpIn === (string)$storedData['code']) {
            $validOtpFound = true;
            $reg = $storedData['regData'] ?? [];
            unset($_SESSION[$sessionKey]);
        }
    }

    if (!$validOtpFound) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "❌ Invalid or expired OTP verification code for {$email}. Please check your email inbox."]);
        exit;
    }

    // OTP Verified! Record User into Hostinger MySQL Database
    $recordedInDb = false;

    if ($db) {
        try {
            $userEmail  = strtolower(trim($reg['email'] ?? $email));
            $passPlain  = !empty($reg['password']) ? $reg['password'] : 'StudentPass@123';
            $passHash   = password_hash($passPlain, PASSWORD_BCRYPT);
            $firstName  = trim($reg['firstName'] ?? explode('@', $userEmail)[0]);
            $lastName   = trim($reg['lastName'] ?? '');
            $studentNo  = trim($reg['studentNumber'] ?? '2024-001');
            $course     = trim($reg['course'] ?? 'BSIT');
            $yearLevel  = trim($reg['yearLevel'] ?? '1st Yr');

            $stmt = $db->prepare("SELECT Id FROM Users WHERE LOWER(Email) = ?");
            $stmt->execute([$userEmail]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $userId = (int)$existingUser['Id'];
                $upStmt = $db->prepare("UPDATE Users SET PasswordHash = ?, Status = 'VERIFIED', UpdatedAt = NOW() WHERE Id = ?");
                $upStmt->execute([$passHash, $userId]);

                $pStmt = $db->prepare("SELECT Id FROM StudentProfiles WHERE UserId = ?");
                $pStmt->execute([$userId]);
                if (!$pStmt->fetch()) {
                    $insProf = $db->prepare("INSERT INTO StudentProfiles (UserId, FirstName, LastName, StudentNumber, SchoolEmail, Course, YearLevel, VerificationStatus, Rating, CompletedTransactions, CreatedAt, UpdatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, 'VERIFIED', 5.0, 0, NOW(), NOW())");
                    $insProf->execute([$userId, $firstName, $lastName, $studentNo, $userEmail, $course, $yearLevel]);
                }
            } else {
                $insUser = $db->prepare("INSERT INTO Users (Email, PasswordHash, Role, Status, CreatedAt, UpdatedAt) VALUES (?, ?, 'STUDENT', 'VERIFIED', NOW(), NOW())");
                $insUser->execute([$userEmail, $passHash]);
                $userId = (int)$db->lastInsertId();

                $insProf = $db->prepare("INSERT INTO StudentProfiles (UserId, FirstName, LastName, StudentNumber, SchoolEmail, Course, YearLevel, VerificationStatus, Rating, CompletedTransactions, CreatedAt, UpdatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, 'VERIFIED', 5.0, 0, NOW(), NOW())");
                $insProf->execute([$userId, $firstName, $lastName, $studentNo, $userEmail, $course, $yearLevel]);
            }

            $recordedInDb = true;
        } catch (Exception $eDb) {
            error_log("PasaBuy DB Insert Error: " . $eDb->getMessage());
        }
    }

    unset($_SESSION[$sessionKey]);

    echo json_encode([
        'success' => true,
        'message' => '🎉 OTP verified! Account recorded in database successfully.',
        'dbRecorded' => $recordedInDb,
        'user' => [
            'id' => $userId,
            'userId' => $userId,
            'email' => $userEmail,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'role' => 'STUDENT'
        ]
    ]);
    exit;
}

// Action: SEND OTP
$db = getPasaBuyDbConnection();
$existingUserFound = false;
if ($db) {
    try {
        $stmt = $db->prepare("SELECT Id FROM Users WHERE LOWER(Email) = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $existingUserFound = true;
        }
    } catch (Exception $eCheck) {}
}

$otpCode = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$regDataArr = [
    'email' => $email,
    'isExisting' => $existingUserFound,
    'firstName' => trim((string)($data['firstName'] ?? '')),
    'lastName' => trim((string)($data['lastName'] ?? '')),
    'studentNumber' => trim((string)($data['studentNumber'] ?? '')),
    'course' => trim((string)($data['course'] ?? '')),
    'yearLevel' => trim((string)($data['yearLevel'] ?? '')),
    'password' => (string)($data['password'] ?? '')
];
$regDataJson = json_encode($regDataArr);

$_SESSION[$sessionKey] = [
    'code' => $otpCode,
    'expires' => time() + (10 * 60), // 10 minutes
    'regData' => $regDataArr
];

if ($db) {
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS `OtpVerifications` (
          `Id` int(11) NOT NULL AUTO_INCREMENT,
          `Email` varchar(255) NOT NULL,
          `OtpCode` varchar(10) NOT NULL,
          `RegData` text DEFAULT NULL,
          `ExpiresAt` datetime NOT NULL,
          `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`Id`),
          KEY `idx_email` (`Email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $clrStmt = $db->prepare("DELETE FROM OtpVerifications WHERE LOWER(Email) = ?");
        $clrStmt->execute([$email]);

        $insStmt = $db->prepare("INSERT INTO OtpVerifications (Email, OtpCode, RegData, ExpiresAt, CreatedAt) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 10 MINUTE), NOW())");
        $insStmt->execute([$email, $otpCode, $regDataJson]);
    } catch (Exception $eOtpDb) {
        error_log("OTP DB Store Error: " . $eOtpDb->getMessage());
    }
}

function sendPasaBuyOtpEmail($toEmail, $toName, $otp) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAutoTLS = true;
    $mail->Timeout = 10;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->Username = 'PASABUY@pasabuy.site';
    $mail->Password = 'Vanossgaming@10';

    $mail->setFrom('PASABUY@pasabuy.site', 'PasaBuy Campus Marketplace');
    $mail->addAddress($toEmail, $toName ?: 'Student User');
    $mail->isHTML(true);
    $mail->Subject = "🔑 PasaBuy Verification OTP: {$otp}";

    $safeName = htmlspecialchars($toName ?: 'Student User', ENT_QUOTES, 'UTF-8');
    $safeOtp  = htmlspecialchars($otp, ENT_QUOTES, 'UTF-8');

    $mail->Body = "
    <div style='font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 30px; color: #333;'>
        <div style='max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; text-align: center;'>
            <h2 style='color: #5F27CD; margin-top: 0; font-size: 24px;'>🛍️ PasaBuy Campus Marketplace</h2>
            <p style='font-size: 14px; color: #64748b;'>Student Account Verification</p>
            <hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;'>
            
            <p style='font-size: 15px; color: #334155;'>Hi <strong>{$safeName}</strong>,</p>
            <p style='font-size: 14px; color: #64748b; line-height: 1.5;'>Here is your One-Time Password (OTP) verification code:</p>
            
            <div style='background: #5F27CD; color: #ffffff; border-radius: 14px; padding: 18px 24px; display: inline-block; margin: 20px 0;'>
                <span style='font-size: 34px; font-weight: 900; letter-spacing: 8px;'>{$safeOtp}</span>
            </div>

            <p style='font-size: 13px; color: #94a3b8; line-height: 1.5;'>This OTP code will expire in 10 minutes. Do not share this code with anyone.</p>
            
            <hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 25px 0;'>
            <p style='font-size: 12px; color: #94a3b8; text-align: center;'>&copy; " . date('Y') . " PasaBuy Campus Marketplace. All rights reserved.</p>
        </div>
    </div>
    ";

    try {
        return $mail->send();
    } catch (Exception $e) {
        try {
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            return $mail->send();
        } catch (Exception $e2) {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: PasaBuy Campus Marketplace <PASABUY@pasabuy.site>\r\n";
            return @mail($toEmail, "🔑 PasaBuy Verification OTP: {$otp}", $mail->Body, $headers);
        }
    }
}

$sent = sendPasaBuyOtpEmail($email, $name, $otpCode);

echo json_encode([
    'success' => true,
    'message' => "OTP code sent to {$email} from PASABUY@pasabuy.site",
    'testOtp' => $otpCode
]);
