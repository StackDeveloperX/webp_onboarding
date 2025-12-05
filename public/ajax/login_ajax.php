<?php
// public/ajax/login_ajax.php

header('Content-Type: application/json');

session_start();

require_once '../../app/config/database.php';
require_once '../../app/helpers/auth_helper.php';

$response = [
    'status'  => 'error',
    'message' => 'Invalid request',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode($response);
    exit;
}

// Get & validate input
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($email === '' || $password === '') {
    $response['message'] = 'Email and Password are required.';
    echo json_encode($response);
    exit;
}

try {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        $response['message'] = 'Invalid email or password.';
        echo json_encode($response);
        exit;
    }

    if ($user['status'] !== 'active') {
        $response['message'] = 'Your account is inactive. Please contact admin.';
        echo json_encode($response);
        exit;
    }

    // If you haven't hashed passwords yet, use simple comparison TEMPORARILY:
    // if ($password !== $user['password']) { ... }
    // But recommended: password_hash + password_verify
    if (!password_verify($password, $user['password'])) {
        $response['message'] = 'Invalid email or password.';
        echo json_encode($response);
        exit;
    }

    // Set session
    $_SESSION['user_id']     = $user['id'];
    $_SESSION['employee_id'] = $user['employee_id'];
    $_SESSION['name']        = $user['name'];
    $_SESSION['role']        = $user['role'];

    // Determine redirect URL based on role
    if ($user['role'] === 'admin') {
        $redirect = 'admin/dashboard.php';
    } else {
        $redirect = 'user/dashboard.php';
    }

    $response['status']   = 'success';
    $response['message']  = 'Login successful! Redirecting...';
    $response['redirect'] = $redirect;

    echo json_encode($response);
    exit;

} catch (Exception $e) {
    $response['message'] = 'Server error: ' . $e->getMessage();
    echo json_encode($response);
    exit;
}
