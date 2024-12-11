<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the correct timezone
date_default_timezone_set('Asia/Manila');

include 'api/connection.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    try {
        $stmt = $conn->prepare("SELECT memberID FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(100000, 999999);
            $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $stmt = $conn->prepare("UPDATE accountinfo SET otp_code = ?, otp_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $otp, $expiry, $email);
            $stmt->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cjcrsg.phils.inc@gmail.com';
                $mail->Password = 'gvqg rzai htgt ykrp';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('cjcrsg.phils.inc@gmail.com', 'CJCRSG Otp code');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is <strong>$otp</strong>. It expires in 10 minutes.";

                $mail->send();

                // Redirect to verify_otp.php with the email in URL
                echo "<script>window.location.href = 'verify_otp.php?email=" . urlencode($email) . "';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Error sending OTP: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('Email not found!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
       
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to right, #e9eff1, #ffffff);
            color: #333;
        }

        .container {
            background: white;
            padding: 2rem 3rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        h1 {
            font-size: 1.8rem;
            color: #2E3E81;
            margin-bottom: 1rem;
        }

        form {
            margin-top: 1.2rem;
        }

        label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            display: block;
            text-align: left;
        }

        input[type="email"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border 0.2s ease;
        }

        button {
            font-size: 1rem;
            color: #fff;
            background: #2E3E81;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        button:hover {
            background: #1E2C5A;
        }
    </style>
    <script>
        // Input limit and validate @gmail.com
        function validateEmailInput(input) {
            const maxLength = 50;

            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength);
            }

            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (input.value && !emailPattern.test(input.value)) {
                input.setCustomValidity("Please enter a valid @gmail.com email address.");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
</head>
<body>

    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your email address to reset your password</p>
        <form action="" method="POST">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required oninput="validateEmailInput(this)">
            <button type="submit">Send OTP</button>
        </form>
    </div>
</body>
</html>
