<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cjcrsg";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the account is active
    $sql = "SELECT memberID FROM accountinfo WHERE email = ? AND password = ? AND is_active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberID);
        $stmt->fetch();

        // Retrieve role
        $sqlRole = "SELECT roleID FROM accountrole WHERE memberID = ?";
        $stmtRole = $conn->prepare($sqlRole);
        $stmtRole->bind_param("i", $memberID);
        $stmtRole->execute();
        $stmtRole->store_result();

        if ($stmtRole->num_rows > 0) {
            $stmtRole->bind_result($roleID);
            $stmtRole->fetch();

            $sqlRoleType = "SELECT roletype FROM role WHERE roleID = ?";
            $stmtRoleType = $conn->prepare($sqlRoleType);
            $stmtRoleType->bind_param("i", $roleID);
            $stmtRoleType->execute();
            $stmtRoleType->store_result();

            if ($stmtRoleType->num_rows > 0) {
                $stmtRoleType->bind_result($roleTypeName);
                $stmtRoleType->fetch();

                session_start();
                $_SESSION['memberID'] = $memberID;

                if ($roleTypeName === 'Admin') {
                    header('Location: ../dashboard.php?id=' . $memberID);
                } else {
                    header('Location: ../home.php?id=' . $memberID);
                }
                exit;
            }
        }
    } else {
        echo "<script>alert('Invalid email, password, or account not activated.'); window.location.href = '../index.php';</script>";
    }
}

$conn->close();
?>
