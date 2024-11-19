<?php
header('Content-Type: application/json');

// Load the XML file
$xml = simplexml_load_file('xml/cjcrsg.xml');

// Parse the relevant tables from the XML
$members = [];
foreach ($xml->tables->table as $table) {
    if ($table['name'] == 'member') {
        foreach ($table->data->row as $row) {
            $memberID = (int)$row['memberID'];
            $name = (string)$row['name'];
            $status = (string)$row['status'];

            // Match with accountinfo to get email
            $email = '';
            foreach ($xml->tables->table as $accountTable) {
                if ($accountTable['name'] == 'accountinfo') {
                    foreach ($accountTable->data->row as $accountRow) {
                        if ((int)$accountRow['memberID'] === $memberID) {
                            $email = (string)$accountRow['email'];
                            break;
                        }
                    }
                }
            }

            // Add member data to the result array
            $members[] = [
                'id' => $memberID,
                'name' => $name,
                'email' => $email,
                'status' => $status
            ];
        }
    }
}

// Output the data as JSON
echo json_encode($members);
?>
