<?php
// app/helpers/auth_helper.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEmployee(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'employee';
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header("Location: /emp_management/public/login.php");
        exit;
    }
}

function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        http_response_code(403);
        echo "Access denied.";
        exit;
    }
}

function requireEmployee(): void {
    requireLogin();
    if (!isEmployee()) {
        http_response_code(403);
        echo "Access denied.";
        exit;
    }
}
?>