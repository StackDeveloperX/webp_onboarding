<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

// Fetch today's attendance
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
$stmt->execute([$employee_id, $today]);
$today_att = $stmt->fetch();

// Fetch history (last 30 days)
$historyStmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? ORDER BY date DESC LIMIT 30");
$historyStmt->execute([$employee_id]);
$history = $historyStmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-brand">Employee Panel</span>
        <div class="d-flex">
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm me-2">Dashboard</a>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3>My Attendance</h3>
    <p><strong>Today:</strong> <?= $today ?></p>

    <div id="alert-box"></div>

    <div class="mb-3">
        <?php if(!$today_att): ?>
            <!-- No record -> allow Check In -->
            <button id="btnCheckIn" class="btn btn-success">Check In</button>
        <?php elseif($today_att && !$today_att['check_out']): ?>
            <!-- Checked in but not out -->
            <p><strong>Checked in at:</strong> <?= $today_att['check_in'] ?></p>
            <button id="btnCheckOut" class="btn btn-danger">Check Out</button>
        <?php else: ?>
            <!-- Both done -->
            <p>
                <strong>Checked in at:</strong> <?= $today_att['check_in'] ?><br>
                <strong>Checked out at:</strong> <?= $today_att['check_out'] ?><br>
                <strong>Hours worked:</strong> <?= $today_att['working_hours'] ?>
            </p>
        <?php endif; ?>
    </div>

    <hr>

    <h4>Last 30 Days</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if($history): ?>
            <?php foreach($history as $row): ?>
                <tr>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['check_in'] ?></td>
                    <td><?= $row['check_out'] ?></td>
                    <td><?= $row['working_hours'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No attendance records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(function(){

    $("#btnCheckIn").on("click", function(){
        $.post("../ajax/attendance_ajax.php", { action: "check_in" }, function(res){
            $("#alert-box").html(`<div class="alert alert-${res.status === 'success' ? 'success' : 'danger'}">${res.message}</div>`);
            if(res.status === 'success'){
                setTimeout(() => location.reload(), 1000);
            }
        }, 'json');
    });

    $("#btnCheckOut").on("click", function(){
        $.post("../ajax/attendance_ajax.php", { action: "check_out" }, function(res){
            $("#alert-box").html(`<div class="alert alert-${res.status === 'success' ? 'success' : 'danger'}">${res.message}</div>`);
            if(res.status === 'success'){
                setTimeout(() => location.reload(), 1000);
            }
        }, 'json');
    });

});
</script>

</body>
</html>
