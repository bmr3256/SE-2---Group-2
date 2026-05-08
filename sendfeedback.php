<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'METHOD_NOT_ALLOWED';
    exit;
}

$name    = htmlspecialchars(trim($_POST['name'] ?? ''));
$email   = htmlspecialchars(trim($_POST['email'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));
$rating  = intval($_POST['rating'] ?? 0);

if (!$name || !$email || !$message || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo 'INVALID_INPUT';
    exit;
}

// Build star display
$stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->Host     = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'barkertest462@gmail.com';
    $mail->Password = 'ftkb jzjo lelo xtdf';

    $mail->setFrom('barkertest462@gmail.com', 'The Barkery Feedback');
    $mail->addAddress('barkertest462@gmail.com', 'The Barkery Owner');
    $mail->addReplyTo($email, $name); // owner can reply directly to customer

    $mail->isHTML(true);
    $mail->Subject = "New Feedback from $name — $stars";
    $mail->Body    = "
        <h2>New Customer Feedback</h2>
        <table style='font-family:sans-serif; font-size:15px; border-collapse:collapse;'>
            <tr><td style='padding:8px; font-weight:bold;'>Name</td><td style='padding:8px;'>$name</td></tr>
            <tr><td style='padding:8px; font-weight:bold;'>Email</td><td style='padding:8px;'>$email</td></tr>
            <tr><td style='padding:8px; font-weight:bold;'>Rating</td><td style='padding:8px; font-size:20px;'>$stars ($rating/5)</td></tr>
            <tr><td style='padding:8px; font-weight:bold; vertical-align:top;'>Message</td><td style='padding:8px;'>$message</td></tr>
        </table>
        <p style='color:#888; font-size:12px; margin-top:16px;'>Sent via The Barkery feedback form.</p>
    ";

    $mail->send();
    echo 'FEEDBACK_SENT';

} catch (Exception $e) {
    http_response_code(500);
    echo 'ERROR: ' . $mail->ErrorInfo;
}