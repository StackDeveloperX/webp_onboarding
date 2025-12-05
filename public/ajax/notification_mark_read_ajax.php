<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$id = $_POST['id'];

$stmt = $pdo->prepare("UPDATE notification_users SET is_read=1, read_at=NOW() WHERE id=?");
$stmt->execute([$id]);

echo json_encode(["status"=>"success"]);
exit;
?>