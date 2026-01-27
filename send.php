<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/src/Exception.php';
require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';
require __DIR__ . '/smtp_config.php';

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

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = SMTP_PORT;

    // Sender and recipient
    $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
    $mail->addAddress(SMTP_FROM); // Send to self
    $mail->addReplyTo($email, $name);

    // Email content
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = "New Contact Form Submission\n\n"
                   . "Name: $name\n"
                   . "Email: $email\n"
                   . "Phone: $phone\n"
                   . "Subject: $subject\n\n"
                   . "Message:\n$message\n";

    $mail->send();
    header('Location: /contact-us?sent=1');
    exit;
} catch (Exception $e) {
    header('Location: /contact-us?error=1');
    exit;
}
