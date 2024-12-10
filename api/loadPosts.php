<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the path to the XML file
$xmlFile = '../xml/post.xml';

// Check if the XML file exists
if (!file_exists($xmlFile)) {
    // Return an empty array if the file doesn't exist
    echo json_encode([]);
    exit;
}

// Load the XML file
$xml = simplexml_load_file($xmlFile);

// Create an array to hold the posts
$posts = [];

// Loop through each post in the XML and extract the relevant data
foreach ($xml->post as $post) {
    $posts[] = [
        'text' => (string)$post->text,
        'timestamp' => (int)$post->timestamp,
        'image' => isset($post->image) ? (string)$post->image : null
    ];
}

// Return the posts as a JSON response
echo json_encode($posts);
?>