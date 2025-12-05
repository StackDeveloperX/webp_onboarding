<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$assets = $pdo->query("SELECT * FROM assets ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">

    <a href="../dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <h3>Assets</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="assetForm" class="row g-3 mb-4">
        <div class="col-md-4">
            <label>Asset Name *</label>
            <input type="text" name="asset_name" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Serial Number</label>
            <input type="text" name="serial_number" class="form-control">
        </div>
        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary">Add Asset</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Asset Name</th>
                <th>Serial</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($assets as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['asset_name']) ?></td>
                <td><?= htmlspecialchars($a['serial_number']) ?></td>
                <td><?= ucfirst($a['status']) ?></td>
                <td><?= $a['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
$("#assetForm").on("submit", function(e){
    e.preventDefault();

    $.post("../../ajax/asset_add_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, 'json');
});
</script>
</body>
</html>
