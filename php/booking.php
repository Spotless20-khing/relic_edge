<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $details = htmlspecialchars(trim($_POST['details'] ?? ''));
    $date = htmlspecialchars(trim($_POST['date'] ?? ''));
    $time = htmlspecialchars(trim($_POST['time'] ?? ''));

    // Basic validation
    if (!$name || !$email || !$phone || !$service || !$details || !$date || !$time) {
        http_response_code(400);
        echo "Please complete all required fields.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration placeholder (update when credentials available)
        /*
        $mail->isSMTP();
        $mail->Host       = 'smtp.your-email-provider.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@domain.com';
        $mail->Password   = 'your-email-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        */

        $mail->setFrom('info@relicedge.com', 'Relic Edge Website');
        $mail->addAddress('info@relicedge.com');

        $mail->Subject = "New Consultation Booking Request";

        $mail->Body = "You have received a new booking request.\n\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Phone: $phone\n"
            . "Service Required: $service\n"
            . "Project Details: $details\n"
            . "Preferred Date: $date\n"
            . "Preferred Time: $time\n";

        $mail->send();

        echo "Thank you for your booking request. We will contact you soon.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Booking request could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
?>
