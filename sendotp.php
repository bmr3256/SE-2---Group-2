<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

$email = $_POST['email'];

$otp = rand(100000, 999999);

$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_time'] = time();

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bryanmiguel.ramos.cics@ust.edu.ph';
    $mail->Password = 'jsjx dunr vjwu lpki';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

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
    echo "ERROR";
}
