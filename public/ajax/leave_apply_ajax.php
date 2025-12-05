<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

$type  = $_POST['leave_type'] ?? "";
$start = $_POST['start_date'] ?? "";
$end   = $_POST['end_date'] ?? "";
$reason = $_POST['reason'] ?? "";

if ($type=="" || $start=="" || $end=="" || $reason=="") {
    echo json_encode(["status"=>"danger","message"=>"All fields are required"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO employee_leaves 
(employee_id, leave_type_id, start_date, end_date, reason)
VALUES (?,?,?,?,?)");

$stmt->execute([$employee_id, $type, $start, $end, $reason]);

echo json_encode(["status"=>"success","message"=>"Leave applied successfully"]);
exit;
