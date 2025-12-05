<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

$stmt = $pdo->prepare("SELECT * FROM payroll WHERE employee_id=? ORDER BY id DESC");
$stmt->execute([$employee_id]);
$data = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Salary Slips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">

    <h3>My Salary Slips</h3>
    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Month</th>
                <th>Earnings</th>
                <th>Deductions</th>
                <th>Net Pay</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $r): ?>
                <tr>
                    <td><?= $r['salary_month'] ?></td>
                    <td><?= $r['total_earnings'] ?></td>
                    <td><?= $r['total_deductions'] ?></td>
                    <td><strong><?= $r['net_pay'] ?></strong></td>
                    <td><a href="../admin/payroll/payslip.php?id=<?= $r['id'] ?>" class="btn btn-outline-primary btn-sm">Download</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
