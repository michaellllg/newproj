<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "cjcrsg") or die("Couldn't connect");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize $data array
$data = array();

// Check if form data for updating profile is provided
$memberID = isset($_POST['memberID']) ? $_POST['memberID'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;
$lifeStage = isset($_POST['lifeStage']) ? $_POST['lifeStage'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;

if ($memberID !== null && $name !== null && $status !== null && $lifeStage !== null && $email !== null && $phone !== null && $address !== null) {
    // Update member details
    $update_member_sql = "UPDATE member SET name='$name', status='$status' WHERE memberID = $memberID";
    if ($con->query($update_member_sql) === TRUE) {
        // Member update successful
        $data['member_updated'] = true;
    } else {
        $data['member_updated'] = false;
        $data['member_error'] = "Error updating member: " . $con->error;
    }

    // Update accountinfo
    $update_accountinfo_sql = "UPDATE accountinfo SET email='$email', phone='$phone', life_stage='$lifeStage', address='$address' WHERE memberID = $memberID";
    if ($con->query($update_accountinfo_sql) === TRUE) {
        // Accountinfo update successful
        $data['accountinfo_updated'] = true;
    } else {
        $data['accountinfo_updated'] = false;
        $data['accountinfo_error'] = "Error updating accountinfo: " . $con->error;
    }

    // Check if updates were successful
    if ($data['member_updated'] && $data['accountinfo_updated']) {
        $data['success'] = true;
    } else {
        $data['success'] = false;
        $data['error'] = "Error updating member information";
    }
} else {
    // Handle case when required data is not provided
    $data['success'] = false;
    $data['error'] = "Error: Required data is missing.";
}

// Encode data to JSON
$json_data = json_encode($data);

// Set headers to return JSON response
header('Content-Type: application/json');
echo $json_data;

// Close connection
$con->close();
?>
