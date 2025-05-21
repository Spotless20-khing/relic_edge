<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload dependencies from Composer
require '../vendor/autoload.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    // Retrieve form data
    $name        = $_POST['name'] ?? '';
    $position    = $_POST['position'] ?? '';
    $company     = $_POST['company'] ?? '';
    $testimonial = $_POST['testimonial'] ?? '';
    $photoPath   = '';

    // Validate required fields
    if (empty($name) || empty($position) || empty($testimonial)) {
        throw new Exception("Required fields are missing.");
    }

    // Handle photo upload if provided
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = '../uploads/';
        $fileName  = basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $photoPath = $targetPath;
        } else {
            throw new Exception("Failed to upload photo.");
        }
    }

    // SMTP server configuration (fill these in once available)
    $mail->isSMTP();
    $mail->Host       = 'smtp.your-mail-provider.com'; // Replace with your SMTP host
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@relicedge.com';           // Your SMTP username
    $mail->Password   = 'your-password';                // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
    $mail->Port       = 587;                            // Default TLS port

    // Email headers
    $mail->setFrom('info@relicedge.com', 'Relic Edge Website');
    $mail->addAddress('info@relicedge.com'); // You can forward to a different address if needed
    $mail->Subject = "New Testimonial Submission from $name";

    // Email content
    $body = "
        <h2>New Testimonial Submitted</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Position:</strong> {$position}</p>
        <p><strong>Company:</strong> {$company}</p>
        <p><strong>Testimonial:</strong><br>{$testimonial}</p>
    ";

    $mail->isHTML(true);
    $mail->Body = $body;

    // Attach uploaded photo if exists
    if (!empty($photoPath)) {
        $mail->addAttachment($photoPath);
    }

    $mail->send();

    // Optional: Redirect or return success
    echo "Thank you! Your testimonial has been submitted.";
} catch (Exception $e) {
    // Handle error
    echo "Message could not be sent. Error: {$mail->ErrorInfo}";
}
?>
