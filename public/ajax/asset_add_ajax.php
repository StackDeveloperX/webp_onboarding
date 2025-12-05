<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$name = trim($_POST['asset_name'] ?? '');
$serial = trim($_POST['serial_number'] ?? '');

if ($name === '') {
    echo json_encode(["status" => "danger", "message" => "Asset name is required"]);
    exit;
}

// Check if serial number already exists (if serial is not empty)
if ($serial !== '') {
    $stmt = $pdo->prepare("SELECT id FROM assets WHERE serial_number = ?");
    $stmt->execute([$serial]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "danger", "message" => "Serial number already exists."]);
        exit;
    }
}

// Insert new asset
$stmt = $pdo->prepare("
    INSERT INTO assets (asset_name, serial_number, status, created_at)
    VALUES (?, ?, 'available', NOW())
");
$stmt->execute([$name, $serial]);

echo json_encode(["status" => "success", "message" => "Asset added successfully"]);
exit;
