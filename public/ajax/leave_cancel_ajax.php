<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$leave_id = $_POST['leave_id'];

$stmt = $pdo->prepare("UPDATE employee_leaves SET status='cancelled' WHERE id=? AND status='pending'");
$stmt->execute([$leave_id]);

echo json_encode(["status"=>"success","message"=>"Leave cancelled"]);
exit;
?>