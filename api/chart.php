<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the year and month parameters
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");
$month = isset($_GET['month']) ? $_GET['month'] : date("m");

// Database connection
$servername = "localhost";
$username = "u627256117_cjcrsg";
$password = "thisWASNTmytrue#3";
$dbname = "u627256117_cjcrsg";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Query the database
$sql = "SELECT * FROM attendance WHERE YEAR(date) = ? AND MONTH(date) = ? ORDER BY date";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ii", $year, $month);
$stmt->execute();
$result = $stmt->get_result();

// Initialize attendance data
$attendanceData = [
    ['week' => 1, 'attendance' => 0],
    ['week' => 2, 'attendance' => 0],
    ['week' => 3, 'attendance' => 0],
    ['week' => 4, 'attendance' => 0],
];

// Function to calculate the week number
function getWeekNumber($date) {
    $currentDate = new DateTime($date);
    $firstDayOfMonth = new DateTime($currentDate->format("Y-m-01"));
    $firstSunday = clone $firstDayOfMonth;

    if ($firstSunday->format("w") != 0) {
        $firstSunday->modify("next sunday");
    }

    $daysDiff = (int)$firstSunday->diff($currentDate)->format("%a");
    $weekNumber = floor($daysDiff / 7) + 1;

    return min($weekNumber, 4);
}

// Process the results
while ($row = $result->fetch_assoc()) {
    $attendanceDate = $row['date'];
    $weekNumber = getWeekNumber($attendanceDate);
    if ($weekNumber >= 1 && $weekNumber <= 4) {
        $attendanceData[$weekNumber - 1]['attendance']++;
    }
}

// Close the connection
$conn->close();

// Return JSON response
echo json_encode($attendanceData, JSON_PRETTY_PRINT);
