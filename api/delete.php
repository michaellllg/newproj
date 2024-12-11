<?php
// Include database connection
include 'login.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID from the query string
if (isset($_GET['id'])) {
    $attendanceId = (int) $_GET['id'];  // Convert the ID to an integer

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM attendance WHERE atten_id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $attendanceId);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo 'success';  // Send success response
    } else {
        echo 'error';  // Send error response if deletion failed
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo 'error';  // Send error if no ID is provided
}
?>
