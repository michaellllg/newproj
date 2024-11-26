<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the file path for the XML data
$xmlFile = '../xml/post.xml';
$response = [];

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if postText is set and not empty
    if (isset($_POST['postText']) && !empty($_POST['postText'])) {
        // Load the existing XML file or create a new one
        if (!file_exists($xmlFile)) {
            $xml = new SimpleXMLElement('<posts></posts>');
        } else {
            $xml = simplexml_load_file($xmlFile);
        }

        // Add new post to the XML
        $post = $xml->addChild('post');
        $post->addChild('text', htmlspecialchars($_POST['postText']));
        $post->addChild('timestamp', time());

        // Handle file upload (if any)
        if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] === UPLOAD_ERR_OK) {
            $imageName = uniqid('post_') . '.' . pathinfo($_FILES['postImage']['name'], PATHINFO_EXTENSION);
            $targetPath = '../uploads/' . $imageName; // Ensure this path is correct

            // Attempt to move the uploaded file to the desired directory
            if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetPath)) {
                $post->addChild('image', $imageName);
            } else {
                $response = ['error' => 'Failed to upload image.'];
                echo json_encode($response); // Return the error as JSON
                exit;
            }
        }

        // Convert SimpleXMLElement to DOMDocument for formatting
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        // Load the SimpleXMLElement into DOMDocument
        $dom->loadXML($xml->asXML());

        // Save the formatted XML back to the file
        $dom->save($xmlFile);

        $response = ['success' => true];
    } else {
        // No postText provided
        $response = ['error' => 'No post text found.'];
    }

    // Always return a JSON response
    echo json_encode($response);
    exit; // Make sure nothing else is output
}
