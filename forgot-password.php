<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the correct timezone
date_default_timezone_set('Asia/Manila');

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cjcrsg';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    try {
        // Check if the email exists
        $stmt = $conn->prepare("SELECT memberID FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate OTP and expiry
            $otp = rand(100000, 999999);
            $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Store OTP and expiry in the database
            $stmt = $conn->prepare("UPDATE accountinfo SET otp_code = ?, otp_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $otp, $expiry, $email);
            $stmt->execute();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'manlangitn07@gmail.com'; // Your Gmail address
                $mail->Password = 'tbtx uaum sssh vpjo'; // Your Gmail app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('manlangitn07@gmail.com', 'OTP Service');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is <strong>$otp</strong>. It expires in 10 minutes.";

                $mail->send();
                echo "OTP sent successfully!";
            } catch (Exception $e) {
                echo "Error sending OTP: {$mail->ErrorInfo}";
            }
        } else {
            echo "Email not found!";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Handle OTP validation
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['validate_otp'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    $input_otp = $_GET['otp'];

    try {
        // Fetch OTP and expiry from the database
        $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_otp = $row['otp_code'];
            $db_expiry = $row['otp_expiry'];
            $current_time = date('Y-m-d H:i:s');

            if ($db_otp == $input_otp && $current_time <= $db_expiry) {
                echo "OTP is valid!";
            } else {
                echo "OTP has expired or is invalid.";
            }
        } else {
            echo "No OTP record found for this email.";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="" method="POST">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send OTP</button>
    </form>

    <h1>Validate OTP</h1>
    <form action="" method="GET">
        <input type="hidden" name="validate_otp" value="1">
        <label for="otp_email">Email:</label>
        <input type="email" name="email" id="otp_email" required>
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
        <button type="submit">Validate OTP</button>
    </form>
</body>
</html>
