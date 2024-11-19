<?php
// Define file path
$xmlFile = '../xml/cjcrsg.xml';  // Correct the path here

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Load XML database
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        // Search for matching email and password
        foreach ($xml->tables->table as $table) {
            if ((string)$table['name'] === 'accountinfo') {
                foreach ($table->data->row as $account) {
                    if ((string)$account['email'] === $email && (string)$account['password'] === $password) {
                        // Successful login
                        $memberID = (int)$account['memberID'];

                        // Get role from the `accountrole` table
                        foreach ($xml->tables->table as $roleTable) {
                            if ((string)$roleTable['name'] === 'accountrole') {
                                foreach ($roleTable->data->row as $role) {
                                    if ((int)$role['memberID'] === $memberID) {
                                        $roleID = (int)$role['roleID'];

                                        // Get role type from the `role` table
                                        foreach ($xml->tables->table as $roleTypeTable) {
                                            if ((string)$roleTypeTable['name'] === 'role') {
                                                foreach ($roleTypeTable->data->row as $roleType) {
                                                    if ((int)$roleType['roleID'] === $roleID) {
                                                        $roleTypeName = (string)$roleType['roletype'];

                                                        // Redirect based on role, include memberID in URL
                                                        if ($roleTypeName === 'Admin') {
                                                            header('Location: ../dashboard.php?id=' . $memberID);  // Add memberID to URL
                                                        } else {
                                                            header('Location: ../home.html?id=' . $memberID);  // Add memberID to URL
                                                        }
                                                        exit;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // If no match found, display error
    echo "<script>alert('Invalid email or password. Please try again.'); window.location.href = '../index.php';</script>";
}
?>
