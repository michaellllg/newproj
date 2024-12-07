<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);

    try {
        // Retrieve OTP and expiry for the email
        $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_otp = $row['otp_code'];
            $expiry = $row['otp_expiry'];

            // Check if OTP matches and is not expired
            if ($otp === $stored_otp && strtotime($expiry) >= time()) {
                // OTP is valid
                header("Location: reset_password.php?email=$email");
                exit();
            } else {
                echo "Invalid or expired OTP!";
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
<head><title>Verify OTP</title></head>
<body>
<h2>Verify OTP</h2>
<form action="" method="POST">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
    <input type="text" name="otp" required placeholder="Enter OTP">
    <button type="submit">Verify</button>
</form>
</body>
</html>
