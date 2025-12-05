<?php
header("Content-Type: application/json");
require_once '../../app/config/database.php';

$response = ["status" => "error"];

$employee_id = $_POST['employee_id'];

if (!$employee_id) {
    $response['message'] = "Employee ID missing.";
    echo json_encode($response);
    exit;
}

$uploadDir = "../assets/uploads/employee_docs/$employee_id/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Upload function
function uploadFile($inputName, $uploadDir){
    if (!empty($_FILES[$inputName]['name'])) {
        $ext = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $filename = $inputName . "_" . time() . "." . $ext;
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir.$filename);
        return $filename;
    }
    return null;
}

// Upload docs
$resume = uploadFile("resume", $uploadDir);
$aadhar = uploadFile("aadhar", $uploadDir);
$pan    = uploadFile("pan", $uploadDir);

// Update fields
$sql = "UPDATE employees SET
        first_name = :first,
        last_name = :last,
        email = :email,
        phone = :phone,
        dob = :dob,
        gender = :gender,
        address = :address,
        city = :city,
        state = :state,
        pincode = :pincode,
        department = :dept,
        designation = :desg,
        reporting_manager = :mgr,
        joining_date = :join_date
        WHERE id = :empid";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":first" => $_POST['first_name'],
    ":last" => $_POST['last_name'],
    ":email" => $_POST['email'],
    ":phone" => $_POST['phone'],
    ":dob" => $_POST['dob'],
    ":gender" => $_POST['gender'],
    ":address" => $_POST['address'],
    ":city" => $_POST['city'],
    ":state" => $_POST['state'],
    ":pincode" => $_POST['pincode'],
    ":dept" => $_POST['department'],
    ":desg" => $_POST['designation'],
    ":mgr" => $_POST['reporting_manager'] ?: null,
    ":join_date" => $_POST['joining_date'],
    ":empid" => $employee_id
]);

// Update docs if uploaded
if ($resume) {
    $pdo->query("UPDATE employees SET resume='$resume' WHERE id=$employee_id");
}
if ($aadhar) {
    $pdo->query("UPDATE employees SET aadhar='$aadhar' WHERE id=$employee_id");
}
if ($pan) {
    $pdo->query("UPDATE employees SET pan='$pan' WHERE id=$employee_id");
}

$response = [
    "status" => "success",
    "message" => "Employee updated successfully!"
];

echo json_encode($response);
exit;
