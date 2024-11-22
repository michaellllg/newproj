<?php
$servername = "localhost";
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "cjcrsg"; // your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get year and month from query parameters
$year = isset($_GET['year']) ? $_GET['year'] : '2023';  // Default to 2023
$month = isset($_GET['month']) ? $_GET['month'] : 'jan';  // Default to January

// Query to get weekly attendance count for the selected year and month
$sql = "
SELECT 
    WEEK(date) AS week, 
    COUNT(*) AS attendance_count
FROM attendance
WHERE YEAR(date) = ? AND MONTHNAME(date) = ?
GROUP BY week
ORDER BY week ASC
";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $year, $month);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Initialize an array to store the attendance data
$attendanceData = [];
while ($row = $result->fetch_assoc()) {
    $attendanceData[] = [
        'week' => "Week" . $row['week'],
        'attendance' => $row['attendance_count']
    ] ;
}

$stmt->close();
$conn->close();

// Return the attendance data as JSON
echo json_encode($attendanceData);
?>
