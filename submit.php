<?php
session_start(); // Start the session
// Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "conference_db";  


$servername = "sql57.jnb2.host-h.net";
$username = "sascezdvme_3";
$password = "NRcUUAZZmN4D5mCUsnS8";
$dbname = "sascezdvme_db3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : '';
    $title = isset($_POST['title']) ? $conn->real_escape_string(trim($_POST['title'])) : '';
    $institution = isset($_POST['institution']) ? $conn->real_escape_string(trim($_POST['institution'])) : '';
    $official_email = isset($_POST['official_email']) ? $conn->real_escape_string(trim($_POST['official_email'])) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string(trim($_POST['phone'])) : '';
    $membership = isset($_POST['membership']) ? $conn->real_escape_string(trim($_POST['membership'])) : '';
    $exhibitor = isset($_POST['exhibitor']) ? $conn->real_escape_string(trim($_POST['exhibitor'])) : '';
    $workshop = isset($_POST['workshop']) ? $conn->real_escape_string(trim($_POST['workshop'])) : '';
    $abstract = isset($_POST['abstract']) ? $conn->real_escape_string(trim($_POST['abstract'])) : '';
    $subtheme = isset($_POST['subtheme']) ? $conn->real_escape_string(trim($_POST['subtheme'])) : '';
    $motivation = isset($_POST['motivation']) ? $conn->real_escape_string(trim($_POST['motivation'])) : '';
    $topic = isset($_POST['topic']) ? $conn->real_escape_string(trim($_POST['topic'])) : '';
    $responsible_payment = isset($_POST['responsible_payment']) ? $conn->real_escape_string(trim($_POST['responsible_payment'])) : '';
    $invoice_contact = isset($_POST['invoice_contact']) ? $conn->real_escape_string(trim($_POST['invoice_contact'])) : '';
    $accommodation = isset($_POST['accommodation']) ? $conn->real_escape_string(trim($_POST['accommodation'])) : '';
    $poster_presenting = isset($_POST['poster_presenting']) ? $conn->real_escape_string(trim($_POST['poster_presenting'])) : '';
    $hotel_name = isset($_POST['hotel_name']) ? $conn->real_escape_string(trim($_POST['hotel_name'])) : '';
    $payment_reference = isset($_POST['payment_reference']) ? $conn->real_escape_string(trim($_POST['payment_reference'])) : '';
    $payment_date = isset($_POST['payment_date']) ? $conn->real_escape_string(trim($_POST['payment_date'])) : '';
    $wil_site_visit = isset($_POST['wil_site_visit']) ? $conn->real_escape_string(trim($_POST['wil_site_visit'])) : '';
    $delegate_official_address = isset($_POST['delegate_official_address']) ? $conn->real_escape_string(trim($_POST['delegate_official_address'])) : '';
    $hotel_arrival = isset($_POST['hotel_arrival']) ? $conn->real_escape_string(trim($_POST['hotel_arrival'])) : '';
    $registration_desk_arrival = isset($_POST['registration_desk_arrival']) ? $conn->real_escape_string(trim($_POST['registration_desk_arrival'])) : '';
    $office_number = isset($_POST['office_number']) ? $conn->real_escape_string(trim($_POST['office_number'])) : '';
    $do_you_have_payment_proof = isset($_POST['do_you_have_payment_proof']) ? $conn->real_escape_string(trim($_POST['do_you_have_payment_proof'])) : '';
    $submission_type = isset($_POST['submission_type']) ? $conn->real_escape_string(trim($_POST['submission_type'])) : '';
    $plenary_Breakaway_session = isset($_POST['plenary_Breakaway_session']) ? $conn->real_escape_string(trim($_POST['plenary_Breakaway_session'])) : '';
    $position = isset($_POST['position']) ? $conn->real_escape_string(trim($_POST['position'])) : '';
    $diet = isset($_POST['diet']) ? $conn->real_escape_string(trim($_POST['diet'])) : '';

    // Other fields
    $other_title = isset($_POST['other_title']) ? $conn->real_escape_string(trim($_POST['other_title'])) : '';
    $other_hotel = isset($_POST['other_hotel']) ? $conn->real_escape_string(trim($_POST['other_hotel'])) : '';
    $other_registration_time = isset($_POST['other_registration_time']) ? $conn->real_escape_string(trim($_POST['other_registration_time'])) : '';
    $other_accommodation = isset($_POST['other_accommodation']) ? $conn->real_escape_string(trim($_POST['other_accommodation'])) : '';
    $other_payment_proof = isset($_POST['other_payment_proof']) ? $conn->real_escape_string(trim($_POST['other_payment_proof'])) : '';

    // Handle "Other" fields
    if ($title === 'Other') {
        $title = $other_title; 
    }

    if ($hotel_name === 'Other') {
        $hotel_name = $other_hotel;
    }

    if ($registration_desk_arrival === 'Other') {
        $registration_desk_arrival = $other_registration_time; 
    }

    if ($accommodation === 'Other') {
        $accommodation = $other_accommodation; 
    }

    if ($do_you_have_payment_proof === 'Other') {
        $do_you_have_payment_proof = $other_payment_proof; 
    }


   
    // File upload logic
   // File upload logic
// File upload logic for a single file
$upload_pop = '';
if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
    $uploads_dir = 'uploads/payment_proof/';
    
    // Ensure the upload directory exists
    if (!file_exists($uploads_dir) && !mkdir($uploads_dir, 0755, true)) {
        die('Failed to create upload directory');
    }
    
    $tmp_name = $_FILES['upload']['tmp_name'];
    $original_name = $_FILES['upload']['name'];
    $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    
    // Validate file type
    $allowed_types = ['pdf', 'doc', 'docx', 'jpg', 'png', 'pptx', 'xlsx'];
    if (!in_array($file_extension, $allowed_types)) {
        die('Invalid file type. Allowed types are: ' . implode(', ', $allowed_types));
    }
    
    // Validate file size (100MB limit)
    if ($_FILES['upload']['size'] > 100 * 1024 * 1024) {
        die('File is too large. Maximum size is 100MB.');
    }
    
    // Generate a unique filename including the user's name
    $sanitized_name = preg_replace("/[^A-Za-z0-9]/", '_', $name);
    $file_name = $sanitized_name . '_' . uniqid() . '.' . $file_extension;
    $file_path = $uploads_dir . $file_name;
    
    if (move_uploaded_file($tmp_name, $file_path)) {
        $upload_pop = "https://sasce.net/form/$file_path";
    } else {
        die('Failed to move uploaded file');
    }
} else {
    // Handle upload errors
    if (isset($_FILES['upload']['error']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
            UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"
        ];
        $error_message = isset($upload_errors[$_FILES['upload']['error']]) 
            ? $upload_errors[$_FILES['upload']['error']] 
            : "Unknown upload error";
        die($error_message);
    }
    
    // If no file uploaded, check for upload_pop in POST data
    $upload_pop = isset($_POST['upload_pop']) ? trim($_POST['upload_pop']) : '';
}


// Count the number of rows in the users table before execution
$sql_count_before = "SELECT COUNT(*) AS row_count FROM users";
$result_before = $conn->query($sql_count_before);
$row_before = $result_before->fetch_assoc();
$row_count_before = $row_before['row_count'];


    // SQL query for insert or update
    $sql = "INSERT INTO users (
        email, `name`, title, institution, position, office_number, official_email, 
        phone,diet,workshop, abstract, 
        accommodation, 
        poster_presenting, plenary_Breakaway_session, hotel_name, payment_reference, 
        payment_date, wil_site_visit, delegate_official_address, hotel_arrival, 
        registration_desk_arrival, do_you_have_payment_proof, upload_pop
    ) VALUES (
        '$email', '$name', '$title', '$institution', '$position', '$office_number', 
        '$official_email', '$phone','$diet' ,'$workshop', 
        '$abstract', 
        '$accommodation', '$poster_presenting', 
        '$plenary_Breakaway_session', '$hotel_name', '$payment_reference', 
        '$payment_date', '$wil_site_visit', '$delegate_official_address', 
        '$hotel_arrival', '$registration_desk_arrival', '$do_you_have_payment_proof', 
        '$upload_pop'
    )
    ON DUPLICATE KEY UPDATE
        name = '$name', 
        title = '$title', 
        institution = '$institution', 
        position = '$position', 
        office_number = '$office_number', 
        official_email = '$official_email', 
        phone = '$phone', 
        diet = '$diet', 
        -- membership_type = '$membership', 
        -- exhibitor = '$exhibitor', 
        workshop = '$workshop', 
        abstract = '$abstract', 
        -- subtheme = '$subtheme', 
        -- motivation = '$motivation', 
        topic = '$topic', 
        -- responsible_payment = '$responsible_payment', 
        -- invoice_contact = '$invoice_contact', 
        accommodation = '$accommodation', 
        poster_presenting = '$poster_presenting', 
        plenary_Breakaway_session = '$plenary_Breakaway_session', 
        hotel_name = '$hotel_name', 
        payment_reference = '$payment_reference', 
        payment_date = '$payment_date', 
        wil_site_visit = '$wil_site_visit', 
        delegate_official_address = '$delegate_official_address', 
        hotel_arrival = '$hotel_arrival', 
        registration_desk_arrival = '$registration_desk_arrival', 
        do_you_have_payment_proof = '$do_you_have_payment_proof',
         upload_pop = '$upload_pop'";



 // Insert or update the data in the database
 $sql2 = "INSERT INTO track_submissions (email, name,submission_type) 
 VALUES ('$email', '$name' ,'$submission_type')";


 if ($conn->query($sql) === TRUE) {
    
    $sql_count_after = "SELECT COUNT(*) AS row_count FROM users";
    $result_after = $conn->query($sql_count_after);
    $row_after = $result_after->fetch_assoc();
    $row_count_after = $row_after['row_count'];

    // Determine the submission type
    if ($row_count_after > $row_count_before) {
        $submission_type = 'submit';


    } else {
        $submission_type = 'update';
    }

     // Store the data in session variables
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
$_SESSION['institution'] = $institution;
$_SESSION['official_email'] = $official_email;
$_SESSION['workshop'] = $workshop;
$_SESSION['diet'] = $diet;
$_SESSION['submission_type'] = $submission_type;
$_SESSION['POP'] = $upload_pop;
    // Insert into track_submissions with the determined submission_type
    $sql2 = "INSERT INTO track_submissions (email, name, submission_type) 
             VALUES ('$email', '$name', '$submission_type')";
    $conn->query($sql2);
     echo "
     <html>
     <head>
         <style>
             body {
                 font-family: Arial, sans-serif;
                 background-color: #f4f4f4;
                 display: flex;
                 justify-content: center;
                 align-items: center;
                 height: 100vh;
                 margin: 0;
             }
             .success-container {
                 background-color: #fff;
                 padding: 30px;
                 border-radius: 10px;
                 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                 text-align: center;
                 max-width: 400px;
                 width: 100%;
             }
             .success-container img {
                 width: 100px;
                 margin-bottom: 20px;
             }
             .success-container h1 {
                 font-size: 24px;
                 margin-bottom: 10px;
                 color: #4CAF50;
             }
             .success-container p {
                 font-size: 16px;
                 color: #555;
             }
             .success-container a {
                 display: inline-block;
                 margin-top: 20px;
                 padding: 10px 20px;
                 background-color: #4CAF50;
                 color: white;
                 text-decoration: none;
                 border-radius: 5px;
                 font-size: 14px;
             }
             .success-container a:hover {
                 background-color: #45a049;
             }
         </style>
     </head>
     <body>
         <div class='success-container'>
             <img src='Wil-africa.png' alt='Success'>
             <h1>Success!</h1>
             <p>Your form was submitted successfully.</p>
             <a href='index.html'>Go Back to Home</a>
         </div>
     </body>
     </html>";
    header("Location: send_email.php");
 } else {
     // Display error message with styled content
 echo "
 <html>
 <head>
     <style>
         body {
             font-family: Arial, sans-serif;
             background-color: #f4f4f4;
             display: flex;
             justify-content: center;
             align-items: center;
             height: 100vh;
             margin: 0;
         }
         .error-container {
             background-color: #fff;
             padding: 30px;
             border-radius: 10px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
             text-align: center;
             max-width: 400px;
             width: 100%;
         }
         .error-container img {
             width: 100px;
             margin-bottom: 20px;
         }
         .error-container h1 {
             font-size: 24px;
             margin-bottom: 10px;
             color: #f44336;
         }
         .error-container p {
             font-size: 16px;
             color: #555;
         }
         .error-container a {
             display: inline-block;
             margin-top: 20px;
             padding: 10px 20px;
             background-color: #f44336;
             color: white;
             text-decoration: none;
             border-radius: 5px;
             font-size: 14px;
         }
         .error-container a:hover {
             background-color: #e53935;
         }
     </style>
 </head>
 <body>
     <div class='error-container'>
         <img src='https://i.imgur.com/oCkEbrS.png' alt='Error'>
         <h1>Error</h1>
         <p>There was an error submitting your form. Please try again later.</p>
         <p><strong>Error Details:</strong> " . $conn->error . "</p>
         <a href='index.html'>Go Back to Form</a>
     </div>
 </body>
 </html>";
 }
}

// Close connection
$conn->close();
?>
