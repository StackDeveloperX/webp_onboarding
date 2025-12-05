<?php
header("Content-Type: application/json");
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$exit_id     = $_POST['exit_id'] ?? null;
$employee_id = $_POST['employee_id'] ?? null;

if (!$exit_id || !$employee_id) {
    echo json_encode([
        "status"  => "danger",
        "message" => "Invalid request."
    ]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Update exit clearance
    $stmt = $pdo->prepare("
        UPDATE employee_exit 
        SET clearance_status='completed' 
        WHERE id = :id
    ");
    $stmt->execute([':id' => $exit_id]);

    // Mark employee as exited
    $stmt2 = $pdo->prepare("
        UPDATE employees 
        SET status='exited' 
        WHERE id = :emp
    ");
    $stmt2->execute([':emp' => $employee_id]);

    // Deactivate user login
    $stmt3 = $pdo->prepare("
        UPDATE users 
        SET status='inactive' 
        WHERE employee_id = :emp
    ");
    $stmt3->execute([':emp' => $employee_id]);

    $pdo->commit();

    echo json_encode([
        "status"  => "success",
        "message" => "Exit clearance marked as completed and employee deactivated."
    ]);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        "status"  => "danger",
        "message" => "Error: ".$e->getMessage()
    ]);
    exit;
}
