<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

// Check if already requested exit
$stmt = $pdo->prepare("SELECT * FROM employee_exit WHERE employee_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$employee_id]);
$exit = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exit / Resignation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>Exit / Resignation</h3>
    <hr>

    <div id="alert-box"></div>

    <?php if ($exit): ?>
        <div class="alert alert-info">
            <strong>Exit Status:</strong> <?= ucfirst($exit['clearance_status']) ?><br>
            <strong>Resignation Date:</strong> <?= $exit['resignation_date'] ?><br>
            <strong>Last Working Day:</strong> <?= $exit['last_working_day'] ?><br>
            <strong>Reason:</strong><br>
            <?= nl2br(htmlspecialchars($exit['exit_reason'])) ?>
        </div>

        <?php if ($exit['clearance_status'] === 'pending'): ?>
            <p>Your resignation request is under review by HR/Admin.</p>
        <?php else: ?>
            <p>Your exit process has been completed.</p>
        <?php endif; ?>

    <?php else: ?>

        <p>If you wish to resign, please fill the form below.</p>

        <form id="exitForm" class="row g-3">
            <div class="col-md-4">
                <label>Resignation Date *</label>
                <input type="date" name="resignation_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Last Working Day (Proposed) *</label>
                <input type="date" name="last_working_day" class="form-control" required>
            </div>

            <div class="col-md-12">
                <label>Reason for Leaving *</label>
                <textarea name="exit_reason" class="form-control" rows="4" required></textarea>
            </div>

            <div class="col-md-3 mt-3">
                <button class="btn btn-danger">Submit Resignation</button>
            </div>
        </form>

    <?php endif; ?>

</div>

<script>
$("#exitForm").on("submit", function(e){
    e.preventDefault();

    $.post("../ajax/exit_request_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(() => location.reload(), 1000);
        }
    }, 'json');
});
</script>

</body>
</html>
