<?php
header("Content-Type: application/json");
require_once '../../app/config/database.php';

$response = ["status" => "error"];

$employee_id = $_POST['employee_id'];

if(empty($employee_id)){
    $response['message'] = "Employee ID missing.";
    echo json_encode($response);
    exit;
}

$department = $_POST['department'];
$designation = $_POST['designation'];
$manager = $_POST['reporting_manager'];
$joining = $_POST['joining_date'];

$sql = "UPDATE employees SET 
        department = :dept,
        designation = :desg,
        reporting_manager = :mgr,
        joining_date = :join_date
        WHERE id = :emp_id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":dept" => $department,
    ":desg" => $designation,
    ":mgr" => $manager ?: null,
    ":join_date" => $joining,
    ":emp_id" => $employee_id
]);

$response = [
    "status" => "success",
    "message" => "Step 2 completed successfully!"
];

echo json_encode($response);
exit;
