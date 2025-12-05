<?php
header("Content-Type: application/json");

require_once '../../app/config/database.php';

$response = ["status" => "error"];

// Validate
if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])){
    $response['message'] = "Please fill all required fields.";
    echo json_encode($response);
    exit;
}

$first = $_POST['first_name'];
$last  = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dept  = $_POST['department'];
$desg  = $_POST['designation'];
$join  = $_POST['joining_date'];

// CHECK IF EMAIL EXISTS (both employees & users)
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if($check->rowCount() > 0){
    $response['message'] = "Email already exists!";
    echo json_encode($response);
    exit;
}

// GENERATE EMPLOYEE CODE: EMP0001, EMP0002...
$stmt = $pdo->query("SELECT COUNT(*) as total FROM employees");
$total = $stmt->fetch()['total'] + 1;

$employeeCode = "EMP" . str_pad($total, 4, "0", STR_PAD_LEFT);

try {
    $pdo->beginTransaction();

    // Insert employee
    $sql = "INSERT INTO employees 
            (employee_code, first_name, last_name, email, phone, department, designation, joining_date, status)
            VALUES 
            (:code, :f, :l, :e, :p, :d, :desg, :j, 'active')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":code" => $employeeCode,
        ":f"    => $first,
        ":l"    => $last,
        ":e"    => $email,
        ":p"    => $phone,
        ":d"    => $dept,
        ":desg" => $desg,
        ":j"    => $join
    ]);

    $employee_id = $pdo->lastInsertId();

    // Create user login
    $defaultPassword = password_hash("123456", PASSWORD_DEFAULT);

    $sql2 = "INSERT INTO users (employee_id, name, email, password, role, status)
             VALUES (:empid, :name, :email, :pass, 'employee', 'active')";

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([
        ":empid" => $employee_id,
        ":name"  => "$first $last",
        ":email" => $email,
        ":pass"  => $defaultPassword
    ]);

    $pdo->commit();

    $response['status'] = "success";
    $response['message'] = "Employee added successfully! Default password: 123456";

} catch(Exception $e){
    $pdo->rollBack();
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
