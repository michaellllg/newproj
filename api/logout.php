<?php
// Start the session to access session variables
session_start();

// Destroy all session data (logs the user out)
session_unset();
session_destroy();

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

header("Location: ../index.php"); // Redirect to login page
exit(); // Ensure no further code is executed after the redirect
?>
