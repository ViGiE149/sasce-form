<?php
header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email from query parameters
$email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';

if ($email) {
    // Query to fetch user details based on email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user details
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        // No user found
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}

$conn->close();
?>
