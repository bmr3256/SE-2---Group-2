<?php
session_start();

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['authorized' => false]);
    exit;
}

// Check if user is logged in AND is an admin email
$adminEmails = [
    'barkertest462@gmail.com',
    'appbarkery@gmail.com'
];

if (
    isset($_SESSION['logged_in']) &&
    $_SESSION['logged_in'] === true &&
    isset($_SESSION['email']) &&
    in_array($_SESSION['email'], $adminEmails)
) {
    echo json_encode(['authorized' => true]);
} else {
    echo json_encode(['authorized' => false]);
}