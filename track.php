<?php
header('Content-Type: application/json');

// Database credentials
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "conference_db";

$servername = "sql57.jnb2.host-h.net";
$username = "sascezdvme_3";
$password = "NRcUUAZZmN4D5mCUsnS8";
$dbname = "sascezdvme_db3";
// 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Query to fetch submissions
$sql = "SELECT id, email, name, submission_type, created_at FROM track_submissions ORDER BY created_at DESC";
$result = $conn->query($sql);

$submissions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }
}

// Get total row count
$totalCount = count($submissions);

// Get unique email count
$emails = array_column($submissions, 'email');
$uniqueEmails = count(array_unique($emails));

// Return data as JSON
$response = array(
    'totalCount' => $totalCount,
    'uniqueEmailCount' => $uniqueEmails,
    'submissions' => $submissions
);

echo json_encode($response);

$conn->close();
?>