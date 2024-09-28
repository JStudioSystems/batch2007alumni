<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $section = $_POST['section'];
    $contactNumber = $_POST['contactNumber'];
    $decision = $_POST['decision'];

    // Prepare data to save
    $data = [
        'fullName' => $fullName,
        'section' => $section,
        'contactNumber' => $contactNumber,
        'decision' => $decision
    ];

    // Load existing data
    $filePath = 'details.json';
    $existingData = [];

    if (file_exists($filePath)) {
        $existingData = json_decode(file_get_contents($filePath), true);
    }

    // Add new data
    $existingData[] = $data;

    // Save updated data
    file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

    // Redirect back to the form
    header('Location: index.html');
    exit;
}
?>
