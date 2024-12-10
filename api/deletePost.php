<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the path to the XML file
$xmlFile = '../xml/post.xml';

// Capture JSON payload
$data = json_decode(file_get_contents('php://input'), true);

// Extract the timestamp
$timestamp = isset($data['timestamp']) ? $data['timestamp'] : null;

// Log incoming timestamp for debugging
error_log("Incoming timestamp: " . $timestamp);

// Check if the file exists
if (!file_exists($xmlFile)) {
    echo json_encode(['error' => 'XML file not found.']);
    exit;
}

// Load the XML file
$xml = simplexml_load_file($xmlFile);
if (!$xml) {
    echo json_encode(['error' => 'Failed to load XML.']);
    exit;
}

// Initialize delete flag and index
$found = false;
$index = 0;

// Iterate through posts to find the matching timestamp
foreach ($xml->post as $post) {
    error_log("Comparing with post timestamp: " . (string)$post->timestamp);

    if ((string)$post->timestamp === (string)$timestamp) {
        // Delete the image if it exists
        if (isset($post->image)) {
            $imagePath = '../uploads/' . $post->image;
            if (file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    error_log("Deleted image: " . $imagePath);
                } else {
                    error_log("Failed to delete image: " . $imagePath);
                }
            }
        }

        // Delete the post from the XML
        unset($xml->post[$index]);
        $found = true;
        break;
    }
    $index++;
}

// Save changes if the post was deleted
if ($found) {
    $xml->asXML($xmlFile);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Post not found.']);
}
exit;
?>
