<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$month = date('Y-m');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate Payroll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>Generate Monthly Payroll</h3>
    <hr>

    <form id="generateForm" class="row g-3">
        <div class="col-md-3">
            <label>Select Month *</label>
            <input type="month" name="salary_month" class="form-control" value="<?= $month ?>" required>
        </div>
        <div class="col-md-3 mt-4">
            <button class="btn btn-success">Generate Payroll</button>
        </div>
    </form>

    <div id="alert-box" class="mt-3"></div>

</div>

<script>
$("#generateForm").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/payroll_generate_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
    }, "json");
});
</script>

</body>
</html>
