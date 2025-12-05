<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$emp = $_POST['employee_id'];
$basic = $_POST['basic'];
$hra = $_POST['hra'] ?? 0;
$allowances = $_POST['allowances'] ?? 0;
$deductions = $_POST['deductions'] ?? 0;

if (!$emp || $basic <= 0) {
    echo json_encode(["status"=>"danger","message"=>"Invalid input"]);
    exit;
}

// Remove older structures
$pdo->prepare("DELETE FROM salary_structure WHERE employee_id=?")->execute([$emp]);

// Insert new structure
$stmt = $pdo->prepare("
INSERT INTO salary_structure 
(employee_id, basic, hra, allowances, deductions, effective_from)
VALUES (?,?,?,?,?,NOW())
");
$stmt->execute([$emp, $basic, $hra, $allowances, $deductions]);

echo json_encode(["status"=>"success","message"=>"Salary structure updated"]);
exit;
