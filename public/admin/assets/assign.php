<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$employees = $pdo->query("SELECT id, first_name, last_name, employee_code FROM employees WHERE status='active' ORDER BY first_name")->fetchAll();
$assets = $pdo->query("SELECT * FROM assets WHERE status='available' ORDER BY asset_name")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">

    <a href="list.php" class="btn btn-secondary btn-sm mb-3">← Back to Assets</a>

    <h3>Assign Asset to Employee</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="assignForm" class="row g-3">
        <div class="col-md-4">
            <label>Employee *</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Select</option>
                <?php foreach($employees as $e): ?>
                    <option value="<?= $e['id'] ?>">
                        <?= $e['first_name'].' '.$e['last_name'].' ('.$e['employee_code'].')' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Asset *</label>
            <select name="asset_id" class="form-control" required>
                <option value="">Select</option>
                <?php foreach($assets as $a): ?>
                    <option value="<?= $a['id'] ?>">
                        <?= $a['asset_name'].' ('.htmlspecialchars($a['serial_number']).')' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 align-self-end">
            <button class="btn btn-success">Assign</button>
        </div>
    </form>

</div>

<script>
$("#assignForm").on("submit", function(e){
    e.preventDefault();

    $.post("../../ajax/asset_assign_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
    }, 'json');
});
</script>
</body>
</html>
