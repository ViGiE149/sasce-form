<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "conference_db";

$servername = "sql57.jnb2.host-h.net";
$username = "sascezdvme_3";
$password = "NRcUUAZZmN4D5mCUsnS8";
$dbname = "sascezdvme_db3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    foreach ($data as $rowData) {
        // Extract values from the row
        $email = isset($rowData['Email Address']) ? $conn->real_escape_string($rowData['Email Address']) : '';
        $name = isset($rowData['Name and SURNAME']) ? $conn->real_escape_string($rowData['Name and SURNAME']) : '';
        $title = isset($rowData['Your Title']) ? $conn->real_escape_string($rowData['Your Title']) : '';
        $institution = isset($rowData['Your Institution/Organisation']) ? $conn->real_escape_string($rowData['Your Institution/Organisation']) : '';
        $official_email = isset($rowData['Official email address']) ? $conn->real_escape_string($rowData['Official email address']) : '';
        $phone = isset($rowData['Your primary cellphone contact number for duration of the Conference ']) ? $conn->real_escape_string($rowData['Your primary cellphone contact number for duration of the Conference ']) : '';
        $membership = isset($rowData['2024 SASCE Membership Type']) ? $conn->real_escape_string($rowData['2024 SASCE Membership Type']) : '';
        $exhibitor = isset($rowData['Will you be attending ONLY as... An EXHIBITOR?']) ? $conn->real_escape_string($rowData['Will you be attending ONLY as... An EXHIBITOR?']) : '';
        $workshop = isset($rowData['Will you be attending the Research Publishing Workshop from 9h30, 2nd Oct by the Editor of IJWIL? 
If yes, NB: Seats are limited, allocated on First-Paid-First Served and First-Come-First-Served basis (Registration at CPUT Hotel School, Granger Bay 9h00-9h30)']) ? $conn->real_escape_string($rowData['Will you be attending the Research Publishing Workshop from 9h30, 2nd Oct by the Editor of IJWIL? 
If yes, NB: Seats are limited, allocated on First-Paid-First Served and First-Come-First-Served basis (Registration at CPUT Hotel School, Granger Bay 9h00-9h30)']) : '';
        $abstract = isset($rowData['Will you be submitting an abstract? Poster Abstract Deadline is 31 August 2024']) ? $conn->real_escape_string($rowData['Will you be submitting an abstract? Poster Abstract Deadline is 31 August 2024']) : '';
        $subtheme = isset($rowData['If submitting an abstract: Sub-theme under which your Paper/Abstract falls']) ? $conn->real_escape_string($rowData['If submitting an abstract: Sub-theme under which your Paper/Abstract falls']) : '';
        $motivation = isset($rowData['If your abstract is NOT covered by the subthemes above, please provide Motivation for the Topic, in WIL Context ']) ? $conn->real_escape_string($rowData['If your abstract is NOT covered by the subthemes above, please provide Motivation for the Topic, in WIL Context ']) : '';
        $topic = isset($rowData['Topic of your Poster/Paper/Abstract']) ? $conn->real_escape_string($rowData['Topic of your Poster/Paper/Abstract']) : '';
        $responsible_payment = isset($rowData['
Are you personally responsible for payment, or you are part of a group/the Institution is responsible?']) ? $conn->real_escape_string($rowData['
Are you personally responsible for payment, or you are part of a group/the Institution is responsible?']) : '';
        $invoice_contact = isset($rowData['If YOU are not personally responsible for payment, who should statements be sent to? Please supply their email address and tel. number']) ? $conn->real_escape_string($rowData['If YOU are not personally responsible for payment, who should statements be sent to? Please supply their email address and tel. number']) : '';
        $payment_date = isset($rowData['Conference Payment Date (reflected from your Finance admin)']) ? excelDateToTimestamp($rowData['Conference Payment Date (reflected from your Finance admin)']) : ''; // Default to current date-time if not set
       // $Upload_your_Abstract = isset($rowData['Upload your Abstract']) ? $conn->real_escape_string($rowData['Upload your Abstract'])  // Default to current date-time if not set
      // Convert Timestamp from Excel serial to date (if applicable)
        $Timestamp = isset($rowData['Timestamp']) ? excelDateToTimestamp($rowData['Timestamp']) : null;
        $upload_your_Abstract = isset($rowData['Upload your Abstract']) ? $conn->real_escape_string($rowData['Upload your Abstract']) : '';

        $position = isset($rowData['Your Designation/Position']) ? $conn->real_escape_string($rowData['Your Designation/Position']) : '';

        $hotel_name = isset($rowData['Name of the Hotel YOU are Booked in']) ? $conn->real_escape_string($rowData['Name of the Hotel YOU are Booked in']) : '';
       
        $abstract= isset($rowData['Will you be presenting an abstract?  IF YES, Pls NOTIFY or register for your poster allocation/location via email: fishera@cput.ac.za; 
overmeyerp@cput.ac.za  and cc events@sasce.net']) ? $conn->real_escape_string($rowData['Will you be presenting an abstract?  IF YES, Pls NOTIFY or register for your poster allocation/location via email: fishera@cput.ac.za; 
overmeyerp@cput.ac.za  and cc events@sasce.net']) : '';
       
       
$hotel_arrival = isset($rowData['What is your Estimated Time of Arrival at your hotel?
NB: IF your arrival is BEFORE 2nd October, kindly make sure you have made appropriate arrangement for  additional night(s) AND Paid directly WITH your HOTEL']) ? $conn->real_escape_string($rowData['What is your Estimated Time of Arrival at your hotel?
NB: IF your arrival is BEFORE 2nd October, kindly make sure you have made appropriate arrangement for  additional night(s) AND Paid directly WITH your HOTEL']) : '';
$registration_desk_arrival = isset($rowData['Estimated time of Arrival at Conference Registration Desk']) ? $conn->real_escape_string($rowData['Estimated time of Arrival at Conference Registration Desk']) : '';
$payment_reference = isset($rowData['Verification - Conference Payment Reference no. details']) ? $conn->real_escape_string($rowData['Verification - Conference Payment Reference no. details']) : '';
       
$wil_site_visit = isset($rowData['Will you attend West Coast 4IR CoE WIL site visit? (Seats limited, First-Paid-First-Served, First-Come-First-Served)']) ? $conn->real_escape_string($rowData['Will you attend West Coast 4IR CoE WIL site visit? (Seats limited, First-Paid-First-Served, First-Come-First-Served)']) : '';
      
$upload_request_invoice = isset($rowData["Upload Request for Invoice for Registration 
(With Individuals' FULL details for each delegate to be billed to your cost centre)"]) ? $conn->real_escape_string($rowData["Upload Request for Invoice for Registration 
(With Individuals' FULL details for each delegate to be billed to your cost centre)"]) : '';
      


$do_you_have_payment_proof = isset($rowData['Do you HAVE YOUR payment confirmation from your Procurement/Finance department?']) ? $conn->real_escape_string($rowData['Do you HAVE YOUR payment confirmation from your Procurement/Finance department?']) : '';
$upload_your_abstract = isset($rowData["Upload your Presentation (If can't upload Audio/Large file, kindly liaise through: 
fishera@cput.ac.za; overmeyerp@cput.ac.za)"]) ? $conn->real_escape_string($rowData["Upload your Presentation (If can't upload Audio/Large file, kindly liaise through: 
fishera@cput.ac.za; overmeyerp@cput.ac.za)"]) : '';

 $plenary_Breakaway_session = isset($rowData['Will you be presenting at a Plenary/Breakaway Session?']) ? $conn->real_escape_string($rowData['Will you be presenting at a Plenary/Breakaway Session?']) : '';
 $upload_pop = isset($rowData["Please UPLOAD your Proof of Payment referenced above, if can't upload, pls your YOUR PoP to matseke@sasce.net"]) ? $conn->real_escape_string($rowData["Please UPLOAD your Proof of Payment referenced above, if can't upload, pls your YOUR PoP to matseke@sasce.net"]) : '';
 $office_number = isset($rowData['Office Telephone Number']) ? $conn->real_escape_string($rowData['Office Telephone Number']) : '';
 $upload_filled_in_form  = isset($rowData['Upload your Filled-in form']) ? $conn->real_escape_string($rowData['Upload your Filled-in form']) : '';

$accommodation= isset($rowData['How was YOUR hotel accommodation made?']) ? $conn->real_escape_string($rowData['How was YOUR hotel accommodation made?']) : '';;  // Placeholder for any file uploads
//$upload_POP= isset($rowData["Please UPLOAD your Proof of Payment referenced above, if can't upload, pls your YOUR PoP to: matseke@sasce.net"]) ? $conn->real_escape_string($rowData["Please UPLOAD your Proof of Payment referenced above, if can't upload, pls your YOUR PoP to: matseke@sasce.net"]) : ''; // Placeholder for accommodation details (if provided)
        $poster_presenting = '';  // Placeholder for poster sharing (if applicable)
       // $payment_reference = '';  // Placeholder for payment reference (if applicable)
       //   isset($rowData['Conference Payment Date (reflected from your Finance admin)']) ? $conn->real_escape_string($rowData['Conference Payment Date (reflected from your Finance admin)']) : '';;  // Placeholder for payment date (if applicable)
      // $wil_site_visit = '';  // Placeholder for site visit participation (if applicable)
        //$delegate_official_address = '';  // Placeholder for delegate official address (if applicable)
        $delegate_official_address = isset($rowData['Official Address']) ? $conn->real_escape_string($rowData['Official Address']) : '';
         // Placeholder for delegate official address (if applicable)
         //$payment_date ='';
        // Insert or update the data in the database
  // Insert or update the data in the database
  $sql = "INSERT INTO users (
    email, name, title, institution, official_email, phone, membership_type, exhibitor, workshop, abstract, subtheme, motivation, topic, responsible_payment, invoice_contact,  accommodation, poster_presenting, payment_reference, payment_date, wil_site_visit, delegate_official_address,Timestamp, upload_your_abstract,hotel_name,position,registration_desk_arrival ,hotel_arrival,plenary_Breakaway_session,do_you_have_payment_proof,office_number,upload_pop,upload_filled_in_form,upload_request_invoice
) VALUES (
    '$email', '$name', '$title', '$institution', '$official_email', '$phone', '$membership', '$exhibitor', '$workshop', '$abstract', '$subtheme', '$motivation', '$topic', '$responsible_payment', '$invoice_contact', '$accommodation', '$poster_presenting', '$payment_reference', '$payment_date', '$wil_site_visit', '$delegate_official_address', '$Timestamp' , '$upload_your_abstract','$hotel_name','$position','$registration_desk_arrival' ,'$hotel_arrival','$plenary_Breakaway_session','$do_you_have_payment_proof','$office_number','$upload_pop ','$upload_filled_in_form', '$upload_request_invoice'
) ON DUPLICATE KEY UPDATE 
    name='$name', title='$title', institution='$institution', official_email='$official_email', phone='$phone', membership_type='$membership', exhibitor='$exhibitor', workshop='$workshop', abstract='$abstract', subtheme='$subtheme', motivation='$motivation', topic='$topic', responsible_payment='$responsible_payment', invoice_contact='$invoice_contact', accommodation='$accommodation', poster_presenting='$poster_presenting', payment_reference='$payment_reference', payment_date='$payment_date', wil_site_visit='$wil_site_visit', delegate_official_address='$delegate_official_address', Timestamp='$Timestamp' , upload_your_abstract='$upload_your_abstract',hotel_name='$hotel_name',position='$position',registration_desk_arrival ='$registration_desk_arrival',hotel_arrival='$hotel_arrival',plenary_Breakaway_session='$plenary_Breakaway_session',do_you_have_payment_proof='$do_you_have_payment_proof',office_number='$office_number',upload_pop='$upload_pop ',upload_filled_in_form='$upload_filled_in_form',upload_request_invoice='$upload_request_invoice'";

if (!$conn->query($sql)) {
echo "SQL Error: " . $conn->error;
}

    }

    echo "Data imported successfully!";
} else {
    echo "No data received.";
}

// Close the database connection
$conn->close();

function excelDateToTimestamp($excelDate) {
    if (is_numeric($excelDate)) {
        $unixDate = ($excelDate - 25569) * 86400; // Convert Excel serial date to Unix timestamp
        return gmdate("Y-m-d H:i:s", $unixDate);
    } else {
        // Return the date as is if it's already a valid string format
        return $excelDate;
    }

}
?>
