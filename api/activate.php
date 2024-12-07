<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; 
$database = 'cjcrsg';

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
            // Success: Use JS alert and redirect
            echo "<script>
                alert('Account successfully activated.');
                window.location.href = 'index.php';
            </script>";
        } else {
            // Error during activation: Use plain echo
            echo "An error occurred while activating your account.";
        }
    } else {
        // Invalid token: Use plain echo
        echo "Invalid or expired activation token.";
    }
} else {
    // No token provided: Use plain echo
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
