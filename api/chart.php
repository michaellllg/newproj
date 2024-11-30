<?php


// Set content type to JSON for the response
header('Content-Type: application/json');

// Get the year and month parameters from the query string
$year = isset($_GET['year']) ? $_GET['year'] : date("Y");
$month = isset($_GET['month']) ? $_GET['month'] : date("m");


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cjcrsg";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch attendance data for the specific year and month
$sql = "SELECT * FROM attendance WHERE YEAR(date) = ? AND MONTH(date) = ? ORDER BY date";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $year, $month);
$stmt->execute();
$result = $stmt->get_result();

// Array to hold attendance counts per week (Week 1 to Week 4)
$attendanceData = [
    ['week' => 1, 'attendance' => 0],
    ['week' => 2, 'attendance' => 0],
    ['week' => 3, 'attendance' => 0],
    ['week' => 4, 'attendance' => 0],
];

// Function to calculate the week number (1 to 4) based on the date
function getWeekNumber($date) {
    $startOfMonth = new DateTime($date);
    $startOfMonth->modify('first day of this month');
    
    // Adjust to start the week on Sunday
    $startOfMonth->modify('last sunday');
    
    $currentDate = new DateTime($date);
    
    $diff = $startOfMonth->diff($currentDate);
    
    // Calculate week number (1-4)
    $daysDiff = $diff->days;
    $weekNumber = floor($daysDiff / 7) + 1;  // Week starts from 1
    
    return min($weekNumber, 4); // Ensure that week doesn't exceed 4
}

// Process the attendance records and count them per week
while ($row = $result->fetch_assoc()) {
    $attendanceDate = $row['date']; // Assuming the 'date' is in 'Y-m-d' format
    $weekNumber = getWeekNumber($attendanceDate); // Get the week number
    
    // Increment the attendance count for the corresponding week
    if ($weekNumber >= 1 && $weekNumber <= 4) {
        $attendanceData[$weekNumber - 1]['attendance']++;
    }
}

// Close the database connection
$conn->close();

// Return the attendance data as a JSON response
echo json_encode($attendanceData);
?>