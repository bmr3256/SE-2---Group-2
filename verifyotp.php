<?php
session_start();

// Make sure email and otp are provided
if (!isset($_POST['email']) || !isset($_POST['otp'])) {
    echo "ERROR";
    exit;
}

$email = $_POST['email'];
$otp_input = $_POST['otp'];

// Check if session has OTP and email stored
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    echo "EXPIRED"; // No OTP in session
    exit;
}

// Check if email matches
if ($email !== $_SESSION['otp_email']) {
    echo "ERROR"; // Email mismatch
    exit;
}

// Check if OTP matches
if ($otp_input == $_SESSION['otp']) {
    // Optionally, check expiration (5 minutes)
    if (isset($_SESSION['otp_time'])) {
        $otp_time = $_SESSION['otp_time'];
        if (time() - $otp_time > 300) { // 300 seconds = 5 minutes
            // OTP expired
            unset($_SESSION['otp']);
            unset($_SESSION['otp_email']);
            unset($_SESSION['otp_time']);
            echo "EXPIRED";
            exit;
        }
    }

    // OTP verified successfully
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_time']);
    echo "VERIFIED";
    exit;
} else {
    echo "INVALID"; // OTP does not match
    exit;
}
