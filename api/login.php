<?php
// Login logic: process form submission and check credentials
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Load the XML file containing account data with error handling
    $xml = simplexml_load_file('xml/accountinfo.xml');

    // Check if XML loading failed
    if ($xml === false) {
        die('Error: Unable to load XML file');
    }
    
    // Get user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Initialize a flag to track if login is successful
    $loginSuccessful = false;

    // Loop through each account in the XML to check if email and password match
    foreach ($xml->account as $account) {
        if ((string)$account->email == $email && (string)$account->password == $password) {
            $loginSuccessful = true;
            break;
        }
    }

    // Check the result of login
    if ($loginSuccessful) {
        echo "<script>alert('Login successful!');</script>";
        // Redirect or start a session, depending on your implementation
         header('Location: dashboard.html');  // Redirect to a dashboard page
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
    }
}
?>