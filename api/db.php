<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "cjcrsg") or die("Couldn't connect");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if memberID is provided in the request
$memberID = isset($_GET['memberID']) ? $_GET['memberID'] : null;

// Initialize $data array
$data = array();

if ($memberID !== null) {
    $sql = "SELECT m.*, ai.email, ai.phone, ai.life_stage, ai.address, r.roletype
        FROM member m
        INNER JOIN accountinfo ai ON m.memberID = ai.memberID
        LEFT JOIN accountrole ar ON m.memberID = ar.memberID
        LEFT JOIN role r ON ar.roleID = r.roleID
        WHERE m.memberID = $memberID";

    $result = $con->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Fetch member details and store in $data array
            $row = $result->fetch_assoc();
            $data['member'] = $row;

            
        } else {
            // No member found with the provided memberID
            $data['member'] = null;
        }
    } else {
        // Error executing query
        $data['error'] = "Error: " . $con->error;
    }
} else {
    // Handle case when memberID is not provided
    $data['error'] = "Error: memberID parameter is missing.";
}

// Fetch member records
$sql_member = "SELECT * FROM member";
$result_member = $con->query($sql_member);

// Fetch attendance records
$sql_attendance = "SELECT * FROM attendance";
$result_attendance = $con->query($sql_attendance);

// Fetch accountinfo records
$sql_accountinfo = "SELECT * FROM accountinfo";
$result_accountinfo = $con->query($sql_accountinfo);

// Fetch accountrole records
$sql_accountrole = "SELECT * FROM accountrole";
$result_accountrole = $con->query($sql_accountrole);

// Fetch role records
$sql_role = "SELECT * FROM role";
$result_role = $con->query($sql_role);

// Check if there are member results
if ($result_member->num_rows > 0) {
    // Fetch member data and store in array
    while ($row_member = $result_member->fetch_assoc()) {
        $data['members'][] = $row_member;
    }
} else {
    // No members found
    $data['members'] = array();
}

// Check if there are attendance results
if ($result_attendance->num_rows > 0) {
    // Fetch attendance data and store in array
    while ($row_attendance = $result_attendance->fetch_assoc()) {
        $data['attendance'][] = $row_attendance;
    }
} else {
    // No attendance records found
    $data['attendance'] = array();
}

// Check if there are accountinfo results
if ($result_accountinfo->num_rows > 0) {
    // Fetch accountinfo data and store in array
    while ($row_accountinfo = $result_accountinfo->fetch_assoc()) {
        $data['accountinfo'][] = $row_accountinfo;
    }
} else {
    // No accountinfo records found
    $data['accountinfo'] = array();
}

// Check if there are accountrole results
if ($result_accountrole->num_rows > 0) {
    // Fetch accountrole data and store in array
    while ($row_accountrole = $result_accountrole->fetch_assoc()) {
        $data['accountrole'][] = $row_accountrole;
    }
} else {
    // No accountrole records found
    $data['accountrole'] = array();
}

// Check if there are role results
if ($result_role->num_rows > 0) {
    // Fetch role data and store in array
    while ($row_role = $result_role->fetch_assoc()) {
        $data['role'][] = $row_role;
    }
} else {
    // No role records found
    $data['role'] = array();
}



// Encode data to JSON
$json_data = json_encode($data);

// Set headers to return JSON response
header('Content-Type: application/json');
echo $json_data;

// Close connection
$con->close();
?>
