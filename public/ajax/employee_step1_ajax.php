<?php
header("Content-Type: application/json");
require_once '../../app/config/database.php';

$response = ["status" => "error"];

// Validation
if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])){
    $response['message'] = "Required fields missing.";
    echo json_encode($response);
    exit;
}

$first = $_POST['first_name'];
$last  = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob   = $_POST['dob'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$pincode = $_POST['pincode'];

// Check email duplicate
$check = $pdo->prepare("SELECT id FROM employees WHERE email = ?");
$check->execute([$email]);

if($check->rowCount() > 0){
    $response['message'] = "Email already exists!";
    echo json_encode($response);
    exit;
}

// Generate employee code EMP0001
$total = $pdo->query("SELECT COUNT(*) as c FROM employees")->fetch()['c'] + 1;
$employee_code = "EMP" . str_pad($total, 4, "0", STR_PAD_LEFT);

// INSERT employee basic info
$sql = "INSERT INTO employees 
(employee_code, first_name, last_name, email, phone, dob, gender, address, city, state, pincode, status)
VALUES
(:code, :fn, :ln, :em, :ph, :dob, :gender, :addr, :city, :state, :pin, 'onboarding')";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":code" => $employee_code,
    ":fn" => $first,
    ":ln" => $last,
    ":em" => $email,
    ":ph" => $phone,
    ":dob" => $dob,
    ":gender" => $gender,
    ":addr" => $address,
    ":city" => $city,
    ":state" => $state,
    ":pin" => $pincode
]);

$employee_id = $pdo->lastInsertId();

// Create employee folder
$folder = "../../assets/uploads/employee_docs/$employee_id/";
if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}

$response = [
    "status" => "success",
    "message" => "Step 1 completed successfully!",
    "employee_id" => $employee_id
];

echo json_encode($response);
exit;
?>