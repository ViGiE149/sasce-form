<?php
// Database connection
//sascezdvme_db1
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference_db";
// / Your database name

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally set the charset to UTF-8
$conn->set_charset("utf8");

// Make the connection available to other scripts
?>
