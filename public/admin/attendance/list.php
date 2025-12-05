<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$date = $_GET['date'] ?? date('Y-m-d');
$employee_id = $_GET['employee_id'] ?? '';

$employees = $pdo->query("SELECT id, first_name, last_name FROM employees ORDER BY first_name")->fetchAll();

// Build query
$sql = "SELECT a.*, e.employee_code, e.first_name, e.last_name
        FROM attendance a
        JOIN employees e ON a.employee_id = e.id
        WHERE a.date = :date";

$params = [':date' => $date];

if ($employee_id !== '') {
    $sql .= " AND a.employee_id = :emp_id";
    $params[':emp_id'] = $employee_id;
}

$sql .= " ORDER BY e.first_name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$attendance = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Attendance - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <a href="../dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <h3>Attendance - <?= $date ?></h3>

    <form method="get" class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="<?= $date ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Employee</label>
            <select name="employee_id" class="form-control">
                <option value="">All Employees</option>
                <?php foreach($employees as $emp): ?>
                    <option value="<?= $emp['id'] ?>" <?= $employee_id==$emp['id']?'selected':'' ?>>
                        <?= $emp['first_name']." ".$emp['last_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Employee Code</th>
                <th>Name</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if($attendance): ?>
            <?php foreach($attendance as $row): ?>
                <tr>
                    <td><?= $row['employee_code'] ?></td>
                    <td><?= $row['first_name'].' '.$row['last_name'] ?></td>
                    <td><?= $row['check_in'] ?></td>
                    <td><?= $row['check_out'] ?></td>
                    <td><?= $row['working_hours'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
