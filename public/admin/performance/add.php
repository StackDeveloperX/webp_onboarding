<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$employees = $pdo->query("SELECT * FROM employees WHERE status='active' ORDER BY first_name")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Performance Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">

    <a href="list.php" class="btn btn-secondary btn-sm mb-3">← Back</a>

    <h3>Add Performance Review</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="reviewForm" class="row g-3">

        <div class="col-md-5">
            <label>Employee *</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Select</option>
                <?php foreach($employees as $e): ?>
                    <option value="<?= $e['id'] ?>"><?= $e['first_name'].' '.$e['last_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Review Period *</label>
            <select name="review_period" class="form-control" required>
                <option value="">Select</option>
                <option value="Q1">Q1</option>
                <option value="Q2">Q2</option>
                <option value="Q3">Q3</option>
                <option value="Q4">Q4</option>
                <option value="Yearly">Yearly</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Rating (1 - 10)</label>
            <input type="number" min="1" max="10" name="rating" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label>Comments</label>
            <textarea name="comments" class="form-control" required></textarea>
        </div>

        <div class="col-md-3 mt-3">
            <button class="btn btn-success">Save Review</button>
        </div>

    </form>

</div>

<script>
$("#reviewForm").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/performance_add_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);

        if(res.status === "success"){
            setTimeout(()=> location.href="list.php", 1000);
        }

    }, "json");
});
</script>

</body>
</html>
