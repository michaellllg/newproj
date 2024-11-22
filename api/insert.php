<?php

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow the POST method
header("Access-Control-Allow-Methods: POST");

// Allow content-type header
header("Access-Control-Allow-Headers: Content-Type");

// Establish database connection
$con = mysqli_connect("localhost", "root", "", "cjcrsg") or die("Couldn't connect");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get memberID from POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check if memberID is present in the request data
    if (isset($data['memberID'])) {
        $memberID = $data['memberID'];

        // Check if attendance record already exists for the member on the current date
        $sql_check = "SELECT * FROM attendance WHERE memberID = ? AND DATE(date) = CURDATE()";
        $stmt_check = $con->prepare($sql_check);
        
        if ($stmt_check) {
            // Bind parameter and execute the statement
            $stmt_check->bind_param("i", $memberID);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            // If attendance record already exists, respond with error message
            if ($result_check->num_rows > 0) {
                echo json_encode(["success" => false, "message" => "Attendance already recorded for today"]);
                exit; // Stop further execution
            }

            // Close statement
            $stmt_check->close();
        } else {
            // Respond with error message if statement preparation fails
            echo json_encode(["success" => false, "message" => "Error preparing statement"]);
            exit; // Stop further execution
        }

        // Check if the memberID exists in the database
        $sql_check_member = "SELECT * FROM member WHERE memberID = ?";
        $stmt_check_member = $con->prepare($sql_check_member);

        if ($stmt_check_member) {
            // Bind parameter and execute the statement
            $stmt_check_member->bind_param("i", $memberID);
            $stmt_check_member->execute();
            $result_check_member = $stmt_check_member->get_result();

            // If memberID doesn't exist, respond with error message
            if ($result_check_member->num_rows == 0) {
                echo json_encode(["success" => false, "message" => "Invalid member ID"]);
                exit; // Stop further execution
            }

            // Close statement
            $stmt_check_member->close();
        } else {
            // Respond with error message if statement preparation fails
            echo json_encode(["success" => false, "message" => "Error preparing statement"]);
            exit; // Stop further execution
        }

        // If no attendance record exists, proceed with insertion
        // Prepare the INSERT statement
        $sql_insert = "INSERT INTO attendance (memberID) VALUES (?)";
        $stmt_insert = $con->prepare($sql_insert);

        if ($stmt_insert) {
            // Bind parameter and execute the statement
            $stmt_insert->bind_param("i", $memberID);
            $stmt_insert->execute();

            // Check if insertion was successful
            if ($stmt_insert->affected_rows > 0) {
                // Respond with success message
                echo json_encode(["success" => true]);
            } else {
                // Respond with error message if insertion fails
                echo json_encode(["success" => false, "message" => "Error recording attendance"]);
            }

            // Close statement
            $stmt_insert->close();
        } else {
            // Respond with error message if statement preparation fails
            echo json_encode(["success" => false, "message" => "Error preparing statement"]);
        }
    } else {
        // Respond with error message if memberID is not provided
        echo json_encode(["success" => false, "message" => "Member ID is missing"]);
    }
} 

// Close connection
$con->close();
?>
