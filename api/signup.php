<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = ''; // Change this if you have a password for your MySQL database
$database = 'cjcrsg';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input (basic example)
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Insert into member table
    $sqlMember = "INSERT INTO member (name, status) VALUES ('$fullname', 'Active')";
    if (mysqli_query($conn, $sqlMember)) {
        // Get the memberID of the newly inserted member
        $memberID = mysqli_insert_id($conn);

        // Insert into accountinfo table (without password hashing)
        $sqlAccountInfo = "INSERT INTO accountinfo (memberID, email, password) VALUES ('$memberID', '$email', '$password')";
        if (mysqli_query($conn, $sqlAccountInfo)) {
            // Insert into accountrole table
            $roleID = 2; // Member role
            $sqlAccountRole = "INSERT INTO accountrole (memberID, roleID) VALUES ('$memberID', '$roleID')";
            if (mysqli_query($conn, $sqlAccountRole)) {
                // Successful signup, redirect to index.php
                header("Location: ../index.php");
                exit(); // Don't forget to call exit() after header() to stop further script execution
            } else {
                echo "Error inserting into accountrole table.";
            }
        } else {
            echo "Error inserting into accountinfo table.";
        }
    } else {
        echo "Error inserting into member table.";
    }

    // Close the connection
    mysqli_close($conn);
}
?>