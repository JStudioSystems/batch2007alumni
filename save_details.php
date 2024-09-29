<?php
// Replace with your actual GitHub repository information
$repoOwner = 'JStudioSystems';
$repoName = 'batch2007alumni';
$filePath = 'details.json'; // Path to your details.json file in the repo
$accessToken = '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'; // Your GitHub token

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $data = [
        'fullName' => $_POST['fullName'],
        'section' => $_POST['section'],
        'contactNumber' => $_POST['contactNumber'],
        'decision' => $_POST['decision'],
    ];

    // Fetch existing data from GitHub
    $url = "https://api.github.com/repos/$repoOwner/$repoName/contents/$filePath";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $accessToken",
        "User-Agent: PHP Script"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);
    $fileSha = $responseData['sha']; // Get the SHA of the existing file

    // Get the existing content and append the new data
    $existingContent = json_decode(base64_decode($responseData['content']), true);
    $existingContent[] = $data;

    // Update the content on GitHub
    $newContent = base64_encode(json_encode($existingContent, JSON_PRETTY_PRINT));
    $updateData = json_encode([
        'message' => 'Update details.json with new registration data',
        'content' => $newContent,
        'sha' => $fileSha // Required to update an existing file
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $accessToken",
        "User-Agent: PHP Script",
        "Content-Type: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check for success
    if (json_decode($response)->commit) {
        echo "<script>alert('Data saved successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to save data.'); window.location.href='index.php';</script>";
    }
}
?>
