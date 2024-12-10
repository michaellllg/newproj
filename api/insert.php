<?php

// Set timezone to Manila
date_default_timezone_set("Asia/Manila");

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow the POST method
header("Access-Control-Allow-Methods: POST");

// Allow content-type header
header("Access-Control-Allow-Headers: Content-Type");

include 'connection.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Allow preflight requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('HTTP/1.1 200 OK');
        exit();
    }

    // Get memberID from POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['memberID'])) {
        $memberID = $data['memberID'];

        $sql_check = "SELECT * FROM attendance WHERE memberID = ? AND DATE(date) = CURDATE()";
        $stmt_check = $conn->prepare($sql_check);

        if ($stmt_check) {
            $stmt_check->bind_param("i", $memberID);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo json_encode(["success" => false, "message" => "Attendance already recorded for today"]);
                exit;
            }

            $stmt_check->close();
        }

        $sql_check_member = "SELECT * FROM member WHERE memberID = ?";
        $stmt_check_member = $conn->prepare($sql_check_member);

        if ($stmt_check_member) {
            $stmt_check_member->bind_param("i", $memberID);
            $stmt_check_member->execute();
            $result_check_member = $stmt_check_member->get_result();

            if ($result_check_member->num_rows == 0) {
                echo json_encode(["success" => false, "message" => "Invalid member ID"]);
                exit;
            }

            $stmt_check_member->close();
        }

<<<<<<< HEAD
        // Generate PHP timezone-adjusted timestamp
        $currentDateTime = date('Y-m-d H:i:s');
        $sql_insert = "INSERT INTO attendance (memberID, date) VALUES (?, ?)";
        $stmt_insert = $con->prepare($sql_insert);
=======
        $sql_insert = "INSERT INTO attendance (memberID, date) VALUES (?, NOW())"; // Use NOW() for current timestamp
        $stmt_insert = $conn->prepare($sql_insert);
>>>>>>> 231f55401671f8569e150e0545fdb68f85ac0f56

        if ($stmt_insert) {
            $stmt_insert->bind_param("is", $memberID, $currentDateTime);
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Error recording attendance"]);
            }

            $stmt_insert->close();
        } else {
            echo json_encode(["success" => false, "message" => "Error preparing statement"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Member ID is missing"]);
    }
}

$conn->close();
?>
