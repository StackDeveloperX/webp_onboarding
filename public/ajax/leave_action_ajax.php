<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$leave_id = $_POST['leave_id'];
$action = $_POST['action'];
$admin_id = $_SESSION['user_id'];

if(!in_array($action, ['approved','rejected'])) {
    echo json_encode(["status"=>"danger","message"=>"Invalid action"]);
    exit;
}

$stmt = $pdo->prepare("
UPDATE employee_leaves 
SET status=?, approved_by=?
WHERE id=?");
$stmt->execute([$action, $admin_id, $leave_id]);

echo json_encode(["status"=>"success","message"=>"Leave ".ucfirst($action)]);
exit;
