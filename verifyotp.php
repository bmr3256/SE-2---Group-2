<?php
session_start();

// Make sure email and otp are provided
if (!isset($_POST['email']) || !isset($_POST['otp'])) {
    echo "ERROR";
    exit;
}

$email = $_POST['email'];
$otp_input = $_POST['otp'];
$uid = isset($_POST['uid']) ? $_POST['uid'] : null; // ✅ NEW

// Check if session has OTP and email stored
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    echo "EXPIRED";
    exit;
}

// Check if email matches
if ($email !== $_SESSION['otp_email']) {
    echo "ERROR";
    exit;
}

// Check if OTP matches
if ($otp_input == $_SESSION['otp']) {

    // Check expiration (5 minutes)
    if (isset($_SESSION['otp_time'])) {
        $otp_time = $_SESSION['otp_time'];
        if (time() - $otp_time > 300) {
            unset($_SESSION['otp']);
            unset($_SESSION['otp_email']);
            unset($_SESSION['otp_time']);
            echo "EXPIRED";
            exit;
        }
    }

    // ✅ LOG USER IN (UPDATED)
    $_SESSION['user_id'] = $uid ? $uid : $email;
    $_SESSION['email'] = $email;
    $_SESSION['logged_in'] = true;

    // Clear OTP session
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_time']);

    echo "VERIFIED";
    exit;
} else {
    echo "INVALID";
    exit;
}
