<?php
include 'connection.php';

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
        $message = " Expired activation token.";
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
