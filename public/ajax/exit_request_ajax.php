<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id      = $_SESSION['employee_id'];
$resignation_date = $_POST['resignation_date'] ?? '';
$last_working_day = $_POST['last_working_day'] ?? '';
$exit_reason      = trim($_POST['exit_reason'] ?? '');

if ($resignation_date === '' || $last_working_day === '' || $exit_reason === '') {
    echo json_encode([
        "status"  => "danger",
        "message" => "All fields are required."
    ]);
    exit;
}

// Check if already has an exit record
$check = $pdo->prepare("SELECT id FROM employee_exit WHERE employee_id = ? LIMIT 1");
$check->execute([$employee_id]);

if ($check->fetch()) {
    echo json_encode([
        "status"  => "danger",
        "message" => "You have already submitted an exit request."
    ]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO employee_exit 
    (employee_id, resignation_date, last_working_day, exit_reason, clearance_status)
    VALUES (:emp, :resig, :lwd, :reason, 'pending')
");

$stmt->execute([
    ':emp'   => $employee_id,
    ':resig' => $resignation_date,
    ':lwd'   => $last_working_day,
    ':reason'=> $exit_reason
]);

echo json_encode([
    "status"  => "success",
    "message" => "Your resignation request has been submitted and is pending approval."
]);
exit;
