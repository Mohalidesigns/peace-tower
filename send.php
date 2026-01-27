<?php

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// Collect and sanitize form data
$name    = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$email   = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$phone   = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
$subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS));
$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS));

// Validate required fields
if (!$name || !$email || !$phone || !$subject || !$message) {
    echo "All fields are required. Please go back and try again.";
    exit;
}

// Validate email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address. Please go back and correct it.";
    exit;
}

// Recipient email
$to = "info@peace-tower.com";

// Email headers
$headers  = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Email body
$email_body  = "New Contact Form Submission\n\n";
$email_body .= "Name: $name\n";
$email_body .= "Email: $email\n";
$email_body .= "Phone: $phone\n";
$email_body .= "Subject: $subject\n\n";
$email_body .= "Message:\n$message\n";

// Send email
if (mail($to, $subject, $email_body, $headers)) {
    header('Location: thank-you.html');
    exit;
} else {
    echo "An error occurred while sending your message. Please try again later.";
}
