<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$employees = $pdo->query("SELECT * FROM employees WHERE status='active' ORDER BY first_name")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary Structure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>Set Salary Structure</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="salaryForm" class="row g-3">
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

        <h5 class="mt-4">Salary Components</h5>

        <div class="col-md-3">
            <label>Basic Salary *</label>
            <input type="number" name="basic" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label>HRA</label>
            <input type="number" name="hra" class="form-control">
        </div>

        <div class="col-md-3">
            <label>Allowances</label>
            <input type="number" name="allowances" class="form-control">
        </div>

        <div class="col-md-3">
            <label>Deductions</label>
            <input type="number" name="deductions" class="form-control">
        </div>

        <div class="col-md-3 mt-4">
            <button class="btn btn-primary">Save Structure</button>
        </div>
    </form>
</div>

<script>
$("#salaryForm").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/salary_structure_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
    }, "json");
});
</script>

</body>
</html>
