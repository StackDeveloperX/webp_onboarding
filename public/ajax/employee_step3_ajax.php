<?php
header("Content-Type: application/json");
require_once '../../app/config/database.php';

$response = ["status" => "error"];

$employee_id = $_POST['employee_id'];

if(empty($employee_id)){
    $response['message'] = "Employee ID not found.";
    echo json_encode($response);
    exit;
}

$uploadDir = "../assets/uploads/employee_docs/$employee_id/";

// Create folder if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$saveData = [];

// Function to upload a file
function uploadFile($inputName, $uploadDir){
    if(isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0){
        $ext = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $filename = $inputName . "_" . time() . "." . $ext;
        $filePath = $uploadDir . $filename;

        move_uploaded_file($_FILES[$inputName]['tmp_name'], $filePath);
        return $filename;
    }
    return null;
}

$resume = uploadFile('resume', $uploadDir);
$aadhar = uploadFile('aadhar', $uploadDir);
$pan    = uploadFile('pan', $uploadDir);

// Update DB
$sql = "UPDATE employees SET 
        resume = :resume,
        aadhar = :aadhar,
        pan = :pan,
        status = 'active'
        WHERE id = :emp_id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":resume" => $resume,
    ":aadhar" => $aadhar,
    ":pan" => $pan,
    ":emp_id" => $employee_id
]);

// Create user login
$emp = $pdo->query("SELECT first_name, last_name, email FROM employees WHERE id=$employee_id")->fetch();

$defaultPassword = password_hash("123456", PASSWORD_DEFAULT);

$sql2 = "INSERT INTO users (employee_id, name, email, password, role, status)
         VALUES (:empid, :name, :email, :pass, 'employee', 'active')";

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([
    ":empid" => $employee_id,
    ":name" => $emp['first_name'] . " " . $emp['last_name'],
    ":email" => $emp['email'],
    ":pass" => $defaultPassword
]);

$response = [
    "status" => "success",
    "message" => "Onboarding completed successfully!"
];

echo json_encode($response);
exit;
