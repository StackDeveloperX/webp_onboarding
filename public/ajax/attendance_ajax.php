<?php
// public/ajax/attendance_ajax.php
header("Content-Type: application/json");

require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$response = ['status' => 'error', 'message' => 'Something went wrong'];

$employee_id = $_SESSION['employee_id'] ?? null;

if (!$employee_id) {
    $response['message'] = "Employee not linked to this user.";
    echo json_encode($response);
    exit;
}

// Ensure employee exists (avoid foreign key error)
$chkEmp = $pdo->prepare("SELECT id FROM employees WHERE id = ?");
$chkEmp->execute([$employee_id]);
if (!$chkEmp->fetch()) {
    $response['message'] = "Employee record not found for this user.";
    echo json_encode($response);
    exit;
}

$action = $_POST['action'] ?? '';
$today  = date('Y-m-d');

try {

    if ($action === 'check_in') {

        // Check if already checked in today
        $stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
        $stmt->execute([$employee_id, $today]);
        $row = $stmt->fetch();

        if ($row) {
            $response['message'] = "You have already marked attendance for today.";
            echo json_encode($response);
            exit;
        }

        // Insert attendance record
        $sql = "INSERT INTO attendance (employee_id, date, check_in, status)
                VALUES (:emp_id, :date, :check_in, 'present')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':emp_id'   => $employee_id,
            ':date'     => $today,
            ':check_in' => date('H:i:s')
        ]);

        $response['status']  = 'success';
        $response['message'] = 'Check-in recorded successfully.';

    } elseif ($action === 'check_out') {

        $stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
        $stmt->execute([$employee_id, $today]);
        $row = $stmt->fetch();

        if (!$row) {
            $response['message'] = "No check-in record found for today.";
            echo json_encode($response);
            exit;
        }

        if ($row['check_out']) {
            $response['message'] = "You have already checked out today.";
            echo json_encode($response);
            exit;
        }

        // Calculate working hours in decimal (e.g. 7.50)
        $sql = "UPDATE attendance 
                SET check_out = :check_out,
                    working_hours = (
                        TIMESTAMPDIFF(MINUTE, CONCAT(date, ' ', check_in), CONCAT(date, ' ', :check_out_time)) / 60
                    )
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $nowTime = date('H:i:s');

        $stmt->execute([
            ':check_out'      => $nowTime,
            ':check_out_time' => $nowTime,
            ':id'             => $row['id']
        ]);

        $response['status']  = 'success';
        $response['message'] = 'Check-out recorded successfully.';

    } else {
        $response['message'] = 'Invalid action.';
    }

} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
exit;
