<?php
header("Content-Type: application/json");
require_once '../../app/config/database.php';

$name = $_POST['name'] ?? "";
$days = $_POST['days'] ?? 0;

if ($name == "" || $days <= 0) {
    echo json_encode(["status" => "danger", "message" => "Invalid input"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO leave_types (name, days_per_year) VALUES (?, ?)");
$stmt->execute([$name, $days]);

echo json_encode(["status" => "success", "message" => "Leave type added"]);
exit;
?>