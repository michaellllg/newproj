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
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        try {
            // Update the password in the database
            $stmt = $conn->prepare("UPDATE accountinfo SET password = ?, otp_code = NULL, otp_expiry = NULL WHERE email = ?");
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();

            // Success message and redirection
            echo "<script>
                alert('Password successfully changed!');
                window.location.href = 'index.php';
            </script>";
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
<h2>Reset Password</h2>
<form action="" method="POST">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
    <input type="password" name="new_password" required placeholder="Enter new password">
    <input type="password" name="confirm_password" required placeholder="Confirm new password">
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
