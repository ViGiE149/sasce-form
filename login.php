<?php
// login_process.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference_db";  


// $servername = "sql57.jnb2.host-h.net";
// $username = "sascezdvme_3";
// $password = "NRcUUAZZmN4D5mCUsnS8";
// $dbname = "sascezdvme_db3";
// Create connection
$conn = new mysqli($servername , $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct, start a new session
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            
            // Redirect to a welcome page or dashboard
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }
    
    $stmt->close();
}

$conn->close();
?>