<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "cjcrsg";

// Create the database connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check for a successful database connection
if (!$con) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . mysqli_connect_error()]);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the data is received correctly
    if (!$data) {
        echo json_encode(["success" => false, "message" => "No data received"]);
        exit;
    }

    // Ensure memberID is provided
    if (isset($data['memberID'])) {
        $memberID = $data['memberID'];

        // Check if memberID exists in the member table
        $sql_check_member = "SELECT * FROM member WHERE memberID = ?";
        $stmt_check_member = $con->prepare($sql_check_member);

        if ($stmt_check_member) {
            // Bind and execute the statement
            $stmt_check_member->bind_param("i", $memberID);
            $stmt_check_member->execute();
            $result_check_member = $stmt_check_member->get_result();

            // If memberID doesn't exist, return an error
            if ($result_check_member->num_rows == 0) {
                echo json_encode(["success" => false, "message" => "Invalid member ID"]);
                exit;
            }

            $stmt_check_member->close();
        } else {
            echo json_encode(["success" => false, "message" => "Error checking member ID"]);
            exit;
        }

        // Insert attendance into the database
        $sql_insert = "INSERT INTO attendance (memberID) VALUES (?)";
        $stmt_insert = $con->prepare($sql_insert);

        if ($stmt_insert) {
            // Bind the memberID and execute the statement
            $stmt_insert->bind_param("i", $memberID);
            $stmt_insert->execute();

            // Check if the insert was successful
            if ($stmt_insert->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Attendance recorded successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => "Insert failed, no rows affected"]);
            }

            $stmt_insert->close();
        } else {
            echo json_encode(["success" => false, "message" => "Error preparing insert statement"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Member ID missing"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

// Close the database connection
$con->close();
?>
