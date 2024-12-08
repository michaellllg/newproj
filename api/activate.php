<?php
// Database connection
$host = 'localhost';
$username = 'u627256117_cjcrsg';
$password = 'thisWASNTmytrue#3'; 
$database = 'u627256117_cjcrsg';


// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if token is passed
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $stmt = $conn->prepare("SELECT * FROM accountinfo WHERE activation_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, activate account
        $updateStmt = $conn->prepare("UPDATE accountinfo SET is_active = 1, activation_token = NULL WHERE activation_token = ?");
        $updateStmt->bind_param("s", $token);
        if ($updateStmt->execute()) {
            $message = "Account successfully activated.";
        } else {
            $message = "An error occurred while activating your account.";
        }
    } else {
        $message = "Invalid or expired activation token.";
    }
} else {
    $message = "Invalid request.";
}

// Display message as JS alert and redirect
echo "<script>
    alert('$message');
    window.location.href = '../index.php';
</script>";

// Close connection
mysqli_close($conn);
?>
