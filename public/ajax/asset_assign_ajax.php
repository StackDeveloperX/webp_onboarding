<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$employee_id = $_POST['employee_id'] ?? '';
$asset_id    = $_POST['asset_id'] ?? '';

if ($employee_id === '' || $asset_id === '') {
    echo json_encode(["status" => "danger", "message" => "Employee and Asset are required"]);
    exit;
}

// Check asset is available
$stmt = $pdo->prepare("SELECT status FROM assets WHERE id = ?");
$stmt->execute([$asset_id]);
$asset = $stmt->fetch();

if (!$asset) {
    echo json_encode(["status" => "danger", "message" => "Asset not found"]);
    exit;
}

if ($asset['status'] !== 'available') {
    echo json_encode(["status" => "danger", "message" => "Asset is not available"]);
    exit;
}

// Insert into employee_assets
$ins = $pdo->prepare("
    INSERT INTO employee_assets (asset_id, employee_id, assigned_at)
    VALUES (?, ?, NOW())
");
$ins->execute([$asset_id, $employee_id]);

// Update asset status
$upd = $pdo->prepare("UPDATE assets SET status='assigned' WHERE id=?");
$upd->execute([$asset_id]);

echo json_encode(["status" => "success", "message" => "Asset assigned successfully"]);
exit;
?>