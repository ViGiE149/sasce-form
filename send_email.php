<?php
session_start(); 

// Collect data from session variables
$email = $_SESSION['email'];  // Sending to the user who submitted the form
$name = $_SESSION['name'];
$institution = $_SESSION['institution'];
$official_email = $_SESSION['official_email'];
$workshop = $_SESSION['workshop'];
$diet = $_SESSION['diet'];
$submission_type = $_SESSION['submission_type'];
$POP = $_SESSION['POP'];
// List of recipient emails
$recipients = [
    'sascennexion@gmail.com',  // This can be the user’s official email
    'matseke@sasce.net', // Add other recipients
     'vgwala149@gmail.com',
    'jabula7@outlook.com', // Another email
];

// Email subject and body
$subject = "Conference Registration Confirmation";
$message = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>New Conference Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        ul li strong {
            color: #2c3e50;
        }
        .footer {
            margin-top: 30px;
            font-style: italic;
            color: #555;
        }
        .ad {
            text-align: center;
            margin-top: 20px;
        }
        .ad img {
            max-width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class='container'>
    <h2>New Conference Registration Alert</h2>
    <p>A new $submission_type has been received for the upcoming conference. Here are the details of the registrant:</p>
    <ul>
        <li><strong>Name:</strong> $name</li>
        <li><strong>Institution:</strong> $institution</li>
        <li><strong>Email:</strong> $official_email</li>
        <li><strong>Workshop:</strong> $workshop</li>
        <li><strong>Diet Preferences:</strong> $diet</li>
		 <li><strong>Proof of payment link:</strong>$POP</li>
    </ul>
    <p>Please review and take the necessary actions. We will keep you updated on additional registrations.</p>
    <div class='ad'>
        <h3>Sponsored by:</h3>
        <img src='https://sasce.net/form/Wil-africa.png' alt='Sponsor Ad'>
    </div>
    <p class='footer'>
        Regards,<br>
       Innovation Lab Team
    </p>
</div>
</body>
</html>
";




//Include required PHPMailer files
	require 'PHPMailer.php';
	require 'SMTP.php';
	require 'Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "vgwala149@gmail.com";
//Set gmail password
	$mail->Password = "augzihvfqsdvfpav";
//Email subject
	$mail->Subject = $subject;
//Set sender email
$mail->setFrom("vgwala149@gmail.com", "Innovation Lab Team"); // Use a fixed sender email
//Enable HTML
	$mail->isHTML(true);
//Attachment
//	$mail->addAttachment('img/attachment.png');
//Email body
$mail->Body = $message; 
//Add recipient
foreach ($recipients as $recipient) {
    $mail->addAddress($recipient);
}

//Finally send email
	if ( $mail->send() ) {
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
	}else{
		echo "data saved but notification Message could not be sent. Mailer Error: thank you for your submition"  . $mail->ErrorInfo;
	}
//Closing smtp connection
	$mail->smtpClose();
