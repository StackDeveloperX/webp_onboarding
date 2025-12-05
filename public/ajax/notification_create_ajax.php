<?php
header("Content-Type: application/json");

require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$title = $_POST['title'];
$message = $_POST['message'];
$type = $_POST['type'];

if ($title == "" || $message == "") {
    echo json_encode(["status"=>"danger","message"=>"Title and message required"]);
    exit;
}

// Insert into notifications
$stmt = $pdo->prepare("
INSERT INTO notifications (title, message, type)
VALUES (?,?,?)
");
$stmt->execute([$title, $message, $type]);

$notification_id = $pdo->lastInsertId();

// Assign to employees
$selectedUsers = $_POST['employees'] ?? [];

if (empty($selectedUsers)) {
    // Send to ALL active users
    $users = $pdo->query("SELECT id FROM users WHERE status='active'")->fetchAll(PDO::FETCH_COLUMN);
} else {
    $users = $selectedUsers;
}

$assign = $pdo->prepare("INSERT INTO notification_users (notification_id, user_id) VALUES (?,?)");

foreach ($users as $u) {
    $assign->execute([$notification_id, $u]);
}

echo json_encode([
    "status"=>"success",
    "message"=>"Notification sent successfully!"
]);
exit;
