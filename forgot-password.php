<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Database connection
    $host = 'localhost';
    $username = 'root';
    $password = ''; 
    $database = 'cjcrsg';

    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Check if the email exists and retrieve memberID
        $stmt = $conn->prepare("SELECT memberID FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(100000, 999999); // Generate a random OTP
            $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Set expiry

            // Store OTP in the database
            $stmt = $conn->prepare("UPDATE accountinfo SET otp_code = ?, otp_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $otp, $expiry, $email);
            $stmt->execute();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'manlangitn07@gmail.com';
                $mail->Password = 'tbtx uaum sssh vpjo';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('manlangitn07@gmail.com', 'otp');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is <strong>$otp</strong>. It expires in 10 minutes.";

                $mail->send();
                header("Location: verify_otp.php?email=$email");
                exit();
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
?>
<!DOCTYPE html>
<html>
<head><title>Forgot Password</title></head>
<body>
<form action="" method="POST">
    <input type="email" name="email" required placeholder="Enter your email">
    <button type="submit">Send OTP</button>
</form>
</body>
</html>
