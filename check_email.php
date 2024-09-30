<?php
header('Content-Type: application/json');

// Database connection 
//sascezdvme_db1
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference_db";

// $servername = "sql57.jnb2.host-h.net";
// $username = "sascezdvme_3";
// $password = "NRcUUAZZmN4D5mCUsnS8";
// $dbname = "sascezdvme_db3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email from the request
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';

// Initialize the response array
$response = array('exists' => false);

if (!empty($email)) {
    // Prepare the SQL query to check if the email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Debug: Check if the query runs correctly
    if (!$result) {
        $response['error'] = "SQL error: " . $conn->error;
        echo json_encode($response);
        exit;
    }

    // Check if the email exists
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo json_encode([
          'exists' => true,
          'name' => $row['name'],
          'title' => $row['title'],
          'institution' => $row['institution'],
          'position' => $row['position'],
          'officialEmail' => $row['official_email'],
          'phone' => $row['phone'],
          'diet' => $row['diet'],
          'office_number' => $row['office_number'],
          'membershipType' => $row['membership_type'],
          'exhibitor' => $row['exhibitor'],
          'workshop' => $row['workshop'],
          'abstract' => $row['abstract'],
          'subtheme' => $row['subtheme'],
          'motivation' => $row['motivation'],
          'topic' => $row['topic'],
          'responsible_payment' => $row['responsible_payment'],
          'invoice_contact' => $row['invoice_contact'],
          'accommodation' => $row['accommodation'],
          'poster_presenting' => $row['poster_presenting'],
          'plenary_Breakaway_session' => $row['plenary_Breakaway_session'],
          'hotel_arrival' => $row['hotel_arrival'],
          'hotel_name' => $row['hotel_name'],
          'registration_desk_arrival' => $row['registration_desk_arrival'],
          'payment_reference' => $row['payment_reference'],
          'payment_date' => $row['payment_date'],
          'wil_site_visit' => $row['wil_site_visit'],
          'do_you_have_payment_proof' => $row['do_you_have_payment_proof'],
          'delegate_official_address' => $row['delegate_official_address'],
          'upload_pop' => $row['upload_pop']
      ]);


    } else {
        // Debug: Let the user know no data was found
        $response['message'] = "No user found with email: $email";
    }
} else {
    $response['message'] = "Email parameter is missing or empty.";
   // echo json_encode(['exists' => false]);
    echo json_encode($response);
}

// Output the response in JSON format
//echo json_encode($response);

// Close the database connection
$conn->close();
?>
