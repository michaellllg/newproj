<?php
// Database connection
$host = 'local';
$username = 'u627256117_cjcrsg';
$password = 'thisWASNTmytrue#3'; 
$database = 'u627256117_cjcrsg';


// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}