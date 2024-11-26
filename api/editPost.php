<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the path to the XML file
$xmlFile = '../xml/post.xml';

// Capture JSON payload
$data = json_decode(file_get_contents('php://input'), true);

// Extract the timestamp and new text
$timestamp = isset($data['timestamp']) ? $data['timestamp'] : null;
$newText = isset($data['text']) ? $data['text'] : null;

// Log incoming data for debugging
error_log("Incoming timestamp: " . $timestamp);
error_log("New text: " . $newText);

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

// Initialize update flag
$updated = false;

// Iterate through posts to find the matching timestamp
foreach ($xml->post as $post) {
    error_log("Comparing with post timestamp: " . (string)$post->timestamp);

    if ((string)$post->timestamp === (string)$timestamp) {
        $post->text = htmlspecialchars($newText); // Update the post text
        $updated = true;
        break;
    }
}

// Save changes if the post was updated
if ($updated) {
    $xml->asXML($xmlFile);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Post not found.']);
}
exit;
?>

?>
