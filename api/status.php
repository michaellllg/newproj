<?php
include 'api/login.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the counters for active and inactive members
$activeCount = 0;
$inactiveCount = 0;

// Query to get the count of active and inactive members
$sqlStatusCount = "SELECT status, COUNT(*) AS count FROM member GROUP BY status";
$resultStatusCount = $conn->query($sqlStatusCount);

// Check if there are results and assign counts
if ($resultStatusCount->num_rows > 0) {
    while ($row = $resultStatusCount->fetch_assoc()) {
        if ($row['status'] == 'Active') {
            $activeCount = $row['count'];
        } else if ($row['status'] == 'Inactive') {
            $inactiveCount = $row['count'];
        }
    }
}

// Calculate total count of members
$totalCount = $activeCount + $inactiveCount;

// Calculate percentages for active and inactive members
$activePercentage = ($totalCount > 0) ? ($activeCount / $totalCount) * 100 : 0;
$inactivePercentage = ($totalCount > 0) ? ($inactiveCount / $totalCount) * 100 : 0;

// Get the ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Default member name
$memberName = 'Admin';

// Query to find the member by ID and get their name
$sqlMemberName = "SELECT name FROM member WHERE memberID = ?";
$stmt = $conn->prepare($sqlMemberName);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

// If the member is found
if ($stmt->num_rows > 0) {
    $stmt->bind_result($fullName);
    $stmt->fetch();
    // Extract the first name from the full name
    $memberName = explode(' ', $fullName)[0];
}

// Close the database connection
$conn->close();
?>