<?php
header("Content-Type: application/json");

require_once '../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../app/config/database.php';

$emp_id = $_POST['employee_id'];
$period = $_POST['review_period'];
$rating = $_POST['rating'];
$comments = $_POST['comments'];
$reviewed_by = $_SESSION['user_id'];

if (!$emp_id || !$period || !$rating) {
    echo json_encode([
        "status" => "danger",
        "message" => "All fields are required"
    ]);
    exit;
}

$stmt = $pdo->prepare("
INSERT INTO performance_reviews 
(employee_id, review_period, rating, comments, reviewed_by)
VALUES (?,?,?,?,?)
");

$stmt->execute([$emp_id, $period, $rating, $comments, $reviewed_by]);

echo json_encode([
    "status" => "success",
    "message" => "Performance review added successfully"
]);
exit;
