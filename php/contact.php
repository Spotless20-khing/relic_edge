<?php
// Load PHPMailer classes via Composer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic input validation
    if (!$name || !$email || !$subject || !$message) {
        http_response_code(400); // Bad request
        echo "Please fill in all required fields with valid information.";
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration - to be updated with real credentials later
        /*
        $mail->isSMTP();
        $mail->Host       = 'smtp.your-email-provider.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@domain.com';
        $mail->Password   = 'your-email-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        */

        // For now, use mail() function or skip sending
        $mail->setFrom('info@relicedge.com', 'Relic Edge Website');
        $mail->addAddress('info@relicedge.com'); // Recipient address

        $mail->Subject = "Contact Form Submission: " . $subject;
        $mail->Body = "You have received a new message from the contact form on your website.\n\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Subject: $subject\n\n"
            . "Message:\n$message";

        // Send the email (currently might fail without SMTP configured)
        $mail->send();

        // Success response
        echo "Thank you for contacting us. Your message has been sent.";
    } catch (Exception $e) {
        http_response_code(500); // Internal server error
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
