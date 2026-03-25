<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'METHOD_NOT_ALLOWED';
    exit;
}

$email = $_POST['email'];

$otp = rand(100000, 999999);

$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_time'] = time();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // remove debug output from response
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = 'tls'; // or 'ssl'
    $mail->Port = 587;        // or 465 for ssl

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bryanmiguel.ramos.cics@ust.edu.ph';
    $mail->Password = 'jsjx dunr vjwu lpki';

    $mail->setFrom('bryanmiguel.ramos.cics@ust.edu.ph', 'The Barkery');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your Barkery Login OTP';
    $mail->Body = "
<h2>The Barkery Login Verification</h2>
<p>Your OTP code is:</p>
<h1>$otp</h1>
<p>This code expires in 5 minutes.</p>
";

    $mail->send();

    echo "OTP_SENT";
} catch (Exception $e) {
    http_response_code(500);
    // Reveal the mailer error for debugging (remove or hide in production)
    echo "ERROR: " . $mail->ErrorInfo . " | " . $e->getMessage();
}
