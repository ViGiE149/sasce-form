<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); // Turn this to '0' in production

// Set content-type header to JSON
header('Content-Type: application/json');

//Database connection parameters
$servername = "sql57.jnb2.host-h.net";
$username = "sascezdvme_3";
$password = "NRcUUAZZmN4D5mCUsnS8";
$dbname = "sascezdvme_db3";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "conference_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get pagination and search parameters from GET request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$rowsPerPage = 1000;
$offset = ($page - 1) * $rowsPerPage;

// SQL query for fetching submissions
 // SQL query for fetching submissions
$sql = "SELECT   email, `name`, title, institution, position, office_number, official_email, 
phone,diet,workshop, abstract,  exhibitor, upload_request_invoice, upload_filled_in_form,
accommodation, motivation, membership_type,subtheme,responsible_payment,invoice_contact,
poster_presenting, plenary_Breakaway_session, hotel_name, payment_reference, 
payment_date, wil_site_visit, delegate_official_address, hotel_arrival, upload_your_abstract ,
registration_desk_arrival, do_you_have_payment_proof, upload_pop ,Timestamp,created_at,updated_at FROM users WHERE name LIKE ? OR email LIKE ? LIMIT ?, ?";  


$stmt = $conn->prepare($sql);

// Check for errors in query preparation
if ($stmt === false) {
    echo json_encode(['error' => 'SQL Prepare failed: ' . $conn->error]);
    exit();
}

$searchTerm = "%{$search}%";
$stmt->bind_param('ssii', $searchTerm, $searchTerm, $offset, $rowsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data into an array
$submissions = [];
while ($row = $result->fetch_assoc()) {
    $submissions[] = $row;
}

// SQL query for counting all rows in the users table
$sqlCount = "SELECT COUNT(*) as totalCount FROM users";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute();
$countResult = $stmtCount->get_result();
$totalCount = $countResult->fetch_assoc()['totalCount'];





// Return JSON response
echo json_encode([
    'data' => $submissions,
    'totalCount' => $totalCount
]);

// Close the connection
$conn->close();
?>
