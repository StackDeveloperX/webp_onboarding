<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$employee_asset_id   = $_POST['employee_asset_id'] ?? '';
$asset_id            = $_POST['asset_id'] ?? '';
$condition_on_return = trim($_POST['condition_on_return'] ?? '');
$damaged             = isset($_POST['damaged']) && $_POST['damaged'] == 1;

if ($employee_asset_id === '' || $asset_id === '') {
    echo json_encode(["status"=>"danger","message"=>"Invalid request"]);
    exit;
}

// Update employee_assets
$upd = $pdo->prepare("
    UPDATE employee_assets 
    SET returned_at = NOW(), condition_on_return = :cond
    WHERE id = :id
");
$upd->execute([
    ':cond' => $condition_on_return,
    ':id'   => $employee_asset_id
]);

// Update asset status
$newStatus = $damaged ? 'damaged' : 'available';

$upd2 = $pdo->prepare("UPDATE assets SET status = :st WHERE id = :aid");
$upd2->execute([
    ':st'  => $newStatus,
    ':aid' => $asset_id
]);

echo json_encode(["status"=>"success","message"=>"Asset return recorded successfully"]);
exit;
?>