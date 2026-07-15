<?php

// Define recipient details
define("RECIPIENT_NAME", "HSE Prosystems Solutions & Logistics");
define("PRIMARY_RECIPIENT_EMAIL", "tommy.umukoro@hseprosystem.com");
define("SECONDARY_RECIPIENT_EMAIL", "info@hseprosystem.com");

// Read and sanitize form values
$success = false;
$name = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
$fname = isset($_POST['fname']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['fname']) : "";
$lname = isset($_POST['lname']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['lname']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$phone = isset($_POST['phone']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
$services = isset($_POST['services']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['services']) : "";
$date = isset($_POST['date']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['date']) : "";
$time = isset($_POST['time']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['time']) : "";
$subject = isset($_POST['subject']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
$website = isset($_POST['website']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['website']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

// Combine name fields if full name not provided
$name = (!empty($name)) ? $name : $fname . ' ' . $lname;

// Prepare email content
$mail_subject = 'hseprosystem.com - Contact request from ' . $name;

$body = 'Name: ' . $name . "\r\n";
$body .= 'Email: ' . $senderEmail . "\r\n";

// Add optional fields if they exist
if ($phone) { $body .= 'Phone: ' . $phone . "\r\n"; }
if ($services) { $body .= 'Services: ' . $services . "\r\n"; }
if ($date) { $body .= 'Date: ' . $date . "\r\n"; }
if ($time) { $body .= 'Time: ' . $time . "\r\n"; }
if ($subject) { $body .= 'Subject: ' . $subject . "\r\n"; }
if ($website) { $body .= 'Website: ' . $website . "\r\n"; }

$body .= 'Message: ' . "\r\n" . $message;

// If all required values exist, send the email
if ($name && $senderEmail && $message) {
    $headers = "From: " . $name . " <" . $senderEmail . ">\r\n";
    $headers .= "Reply-To: " . $senderEmail . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send to both recipients
    $recipient1 = RECIPIENT_NAME . " <" . PRIMARY_RECIPIENT_EMAIL . ">";
    $recipient2 = RECIPIENT_NAME . " <" . SECONDARY_RECIPIENT_EMAIL . ">";
    
    // Send first email
    $success1 = mail($recipient1, $mail_subject, $body, $headers);
    
    // Send second email
    $success2 = mail($recipient2, $mail_subject, $body, $headers);
    
    if ($success1 || $success2) {
        echo "<div class='inner success'><p class='success'>Thanks for contacting us. We will contact you ASAP!</p></div>";
    } else {
        echo "<div class='inner error'><p class='error'>Message could not be sent. Please try again later.</p></div>";
    }
} else {
    echo "<div class='inner error'><p class='error'>Please fill all required fields (Name, Email, and Message).</p></div>";
}
?>