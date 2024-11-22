<?php
// Database connection details
$servername = "localhost"; // Usually localhost
$username = "root"; // Your database username (e.g., root)
$password = ""; // Your database password (empty for default local setup)
$database = "cjcrsg"; // Your database name

// Create a connection
$con = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
