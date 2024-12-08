<?php
$con = mysqli_connect("localhost", "ru627256117_cjcrsg", "thisWASNTmytrue#3", "u627256117_cjcrsg") or die("Couldn't connect");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $status = $_POST['status'];
    $life_stage = $_POST['life_stage'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role']; // Add role data

    // Prepare and bind parameters for inserting into member table
    $stmt_member = $con->prepare("INSERT INTO member (name, status) VALUES (?, ?)");
    $stmt_member->bind_param("ss", $name, $status);

    // Execute the statement to insert into the member table
    $member_success = $stmt_member->execute();

    if ($member_success) {
        // Retrieve the auto-generated memberID
        $memberID = $con->insert_id;

        // Check if the role exists in the role table
        $check_role = $con->prepare("SELECT roleID FROM role WHERE roletype = ?");
        $check_role->bind_param("s", $role);
        $check_role->execute();
        $result_role = $check_role->get_result();

        if ($result_role->num_rows > 0) {
            // Role exists, proceed to insert into accountinfo table
            $row_role = $result_role->fetch_assoc();
            $roleID = $row_role['roleID'];

            // Prepare and bind parameters for inserting into accountinfo table
            $stmt_accountinfo = $con->prepare("INSERT INTO accountinfo (email, password, phone, life_stage, address, memberID) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_accountinfo->bind_param("sssssi", $email, $password, $phone, $life_stage, $address, $memberID);

            // Execute the statement to insert into the accountinfo table
            $accountinfo_success = $stmt_accountinfo->execute();

            if ($accountinfo_success) {
                // Prepare and bind parameters for inserting into accountrole table
                $stmt_accountrole = $con->prepare("INSERT INTO accountrole (memberID, roleID) VALUES (?, ?)");
                $stmt_accountrole->bind_param("ii", $memberID, $roleID);

                // Execute the statement to insert into the accountrole table
                $accountrole_success = $stmt_accountrole->execute();

                if ($accountrole_success) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $stmt_accountrole->error;
                }

                // Close the accountrole statement
                $stmt_accountrole->close();
            } else {
                echo "Error: " . $stmt_accountinfo->error;
            }
            
            // Close the accountinfo statement
            $stmt_accountinfo->close();
        } else {
            // Role does not exist, handle error
            echo "Error: Role does not exist";
        }
        
        // Close the check_role statement
        $check_role->close();
    } else {
        echo "Error: " . $stmt_member->error;
    }

    // Close the member statement
    $stmt_member->close();
}

// Close database connection
$con->close();
?>