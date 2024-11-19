<?php
// Load the XML file
$xml = simplexml_load_file('xml/cjcrsg.xml');

// Check if the XML file is loaded correctly
if ($xml === false) {
    die('Error loading XML file');
}

// Initialize the counters for active and inactive members
$activeCount = 0;
$inactiveCount = 0;

// Loop through the tables in the XML to find the "member" table
foreach ($xml->tables->table as $table) {
    // Check if the current table is the "member" table
    if ((string) $table['name'] == 'member') {
        // Iterate over each row in the "member" table
        foreach ($table->data->row as $row) {
            // Check if 'status' attribute exists in the row
            if (isset($row['status'])) {
                // Check the status and count active and inactive members
                if ((string) $row['status'] == 'Active') {
                    $activeCount++;
                } else if ((string) $row['status'] == 'Inactive') {
                    $inactiveCount++;
                }
            }
        }
    }
}

// Calculate total count of members
$totalCount = $activeCount + $inactiveCount;

// Calculate percentages for active and inactive members
$activePercentage = ($totalCount > 0) ? ($activeCount / $totalCount) * 100 : 0;
$inactivePercentage = ($totalCount > 0) ? ($inactiveCount / $totalCount) * 100 : 0;

// Display the results in HTML format








?>

