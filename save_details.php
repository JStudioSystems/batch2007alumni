<?php
// save_details.php

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['fullName']) || !isset($input['section']) || !isset($input['contactNumber']) || !isset($input['decision'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

$data = [
    'fullName' => $input['fullName'],
    'section' => $input['section'],
    'contactNumber' => $input['contactNumber'],
    'decision' => $input['decision'], // Add decision to the data
    'timestamp' => date('Y-m-d H:i:s')
];

// Path to the JSON file
$jsonFilePath = 'details.json';

// Read existing data
if (file_exists($jsonFilePath)) {
    $existingData = json_decode(file_get_contents($jsonFilePath), true);
    if (!is_array($existingData)) {
        $existingData = [];
    }
} else {
    $existingData = [];
}

// Add new data
$existingData[] = $data;

// Save the updated data to the JSON file
if (file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving details']);
}
?>
