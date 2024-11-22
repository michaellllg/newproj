<?php
// Define database connection parameters
$servername = "localhost";  // Adjust the server name as needed
$username = "root";         // Adjust the username as needed
$password = "";             // Adjust the password as needed
$dbname = "cjcrsg";         // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email and password match any record in the accountinfo table
    $sql = "SELECT memberID FROM accountinfo WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    // If a matching record is found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberID);
        $stmt->fetch();

        // Now, retrieve the roleID from the accountrole table
        $sqlRole = "SELECT roleID FROM accountrole WHERE memberID = ?";
        $stmtRole = $conn->prepare($sqlRole);
        $stmtRole->bind_param("i", $memberID);
        $stmtRole->execute();
        $stmtRole->store_result();

        // If a role record is found
        if ($stmtRole->num_rows > 0) {
            $stmtRole->bind_result($roleID);
            $stmtRole->fetch();

            // Now, retrieve the role type from the role table
            $sqlRoleType = "SELECT roletype FROM role WHERE roleID = ?";
            $stmtRoleType = $conn->prepare($sqlRoleType);
            $stmtRoleType->bind_param("i", $roleID);
            $stmtRoleType->execute();
            $stmtRoleType->store_result();

            // If a role type is found
            if ($stmtRoleType->num_rows > 0) {
                $stmtRoleType->bind_result($roleTypeName);
                $stmtRoleType->fetch();

                // Start session and store memberID
                session_start();
                $_SESSION['memberID'] = $memberID;

                // Redirect based on role type
                if ($roleTypeName === 'Admin') {
                    // Admin user, redirect to the dashboard
                    header('Location: ../dashboard.php?id=' . $memberID);
                } else {
                    // Regular user, redirect to the home page
                    header('Location: ../home.php?id=' . $memberID);
                }
                exit;
            }
        }
    }

    // If no match is found, display error
    echo "<script>alert('Invalid email or password. Please try again.'); window.location.href = '../index.php';</script>";
}

$conn->close();
?>
