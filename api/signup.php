<?php
// Include PHPMailer classes
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href = '../index.php';</script>";
        exit;
    }

    // Ensure only Gmail addresses are allowed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@gmail.com') === false) {
        echo "<script>alert('Only Gmail addresses are allowed for signup.'); window.location.href = '../index.php';</script>";
        exit;
    }

    // Check if the email is already registered
    $checkEmailQuery = "SELECT * FROM accountinfo WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('This email is already registered. Please try logging in.'); window.location.href = '../index.php';</script>";
        exit;
    }

    // Generate an activation token
    $activation_token = bin2hex(random_bytes(16));

    // Insert into the `member` table
    $sqlMember = "INSERT INTO member (name, status) VALUES ('$fullname', 'Active')";
    if (mysqli_query($conn, $sqlMember)) {
        // Get the memberID of the newly inserted member
        $memberID = mysqli_insert_id($conn);

        // Insert into `accountinfo` table
        $sqlAccountInfo = "INSERT INTO accountinfo (memberID, email, password, is_active, activation_token) 
                           VALUES ('$memberID', '$email', '$password', 0, '$activation_token')";
        if (mysqli_query($conn, $sqlAccountInfo)) {
            // Insert into the accountrole table with default roleID=2 for "member"
            $roleID = 2; // 2 represents the "member" role
            $sqlAccountRole = "INSERT INTO accountrole (memberID, roleID, dateCreated) 
                                VALUES ('$memberID', '$roleID', NOW())";
            if (mysqli_query($conn, $sqlAccountRole)) {
                // Send the activation email using PHPMailer
                try {
                    $mail = new PHPMailer(true);

                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'cjcrsg.phils.inc@gmail.com';
                    $mail->Password = 'tgyc dnku dorf kfub';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('cjcrsg.phils.inc@gmail.com', 'Account activation');
                    $mail->addAddress($email, $fullname);

                    // Email content
                    $activation_link = "https://" . $_SERVER['HTTP_HOST'] . "/api/activate.php?token=" . urlencode($activation_token);

                    $mail->isHTML(true);
                    $mail->Subject = 'Account Activation';
                    $mail->Body = "<p>Hello $fullname,</p>
                                   <p>Please click the link below to activate your account:</p>
                                   <a href='$activation_link'>$activation_link</a>
                                   <p>Thank you!</p>";

                    $mail->send();
                    
                    // Success alert and redirect to index.php
                    echo "<script>alert('Registration successful! Please check your email to activate your account.'); window.location.href = '../index.php';</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Error sending activation email. Mailer Error: {$mail->ErrorInfo}'); window.location.href = '../index.php';</script>";
                }
            } else {
                echo "<script>alert('Error inserting into accountrole table.'); window.location.href = '../index.php';</script>";
            }
        } else {
            echo "<script>alert('Error inserting into accountinfo table.'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "<script>alert('Error inserting into member table.'); window.location.href = '../index.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}

if (!file_exists('../phpmailer/src/Exception.php')) {
    die('Error: PHPMailer files not found. Check the file paths.');
}
?>
