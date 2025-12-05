<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

$stmt = $pdo->prepare("
    SELECT ea.*, a.asset_name, a.serial_number
    FROM employee_assets ea
    JOIN assets a ON ea.asset_id = a.id
    WHERE ea.employee_id = ?
    ORDER BY ea.assigned_at DESC
");
$stmt->execute([$employee_id]);
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>My Assigned Assets</h3>
    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Asset</th>
                <th>Serial</th>
                <th>Assigned At</th>
                <th>Returned At</th>
                <th>Condition on Return</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= $r['asset_name'] ?></td>
                <td><?= htmlspecialchars($r['serial_number']) ?></td>
                <td><?= $r['assigned_at'] ?></td>
                <td><?= $r['returned_at'] ?: 'Not Returned' ?></td>
                <td><?= $r['condition_on_return'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
