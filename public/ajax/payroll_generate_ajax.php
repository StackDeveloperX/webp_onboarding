<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$month = $_POST['salary_month'];

if (!$month) {
    echo json_encode(["status"=>"danger","message"=>"Month required"]);
    exit;
}

// Fetch all employees + salary structure
$stmt = $pdo->query("
SELECT e.id AS emp_id, e.first_name, e.last_name, 
       s.basic, s.hra, s.allowances, s.deductions
FROM employees e
LEFT JOIN salary_structure s ON e.id = s.employee_id
WHERE e.status='active'
");

$employees = $stmt->fetchAll();

foreach ($employees as $emp) {

    if (!$emp['basic']) continue; // skip employees without salary structure

    $total_earnings = $emp['basic'] + $emp['hra'] + $emp['allowances'];
    $total_deductions = $emp['deductions'];
    $net_pay = $total_earnings - $total_deductions;

    // Prevent duplicate payroll
    $check = $pdo->prepare("SELECT id FROM payroll WHERE employee_id=? AND salary_month=?");
    $check->execute([$emp['emp_id'], $month]);

    if ($check->rowCount() == 0) {
        $insert = $pdo->prepare("
        INSERT INTO payroll (employee_id, salary_month, total_earnings, total_deductions, net_pay)
        VALUES (?,?,?,?,?)
        ");
        $insert->execute([
            $emp['emp_id'], $month, $total_earnings, $total_deductions, $net_pay
        ]);
    }
}

echo json_encode(["status"=>"success","message"=>"Payroll generated for $month"]);
exit;
