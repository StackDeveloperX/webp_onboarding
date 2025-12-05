<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$stmt = $pdo->query("
    SELECT ea.*, 
           a.asset_name, a.serial_number,
           e.first_name, e.last_name, e.employee_code
    FROM employee_assets ea
    JOIN assets a ON ea.asset_id = a.id
    JOIN employees e ON ea.employee_id = e.id
    WHERE ea.returned_at IS NULL
    ORDER BY ea.assigned_at DESC
");
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assigned Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">
    <a href="list.php" class="btn btn-secondary btn-sm mb-3">← Back to Assets</a>

    <h3>Currently Assigned Assets</h3>
    <hr>

    <div id="alert-box"></div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Employee Code</th>
                <th>Asset</th>
                <th>Serial</th>
                <th>Assigned At</th>
                <th>Return</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= $r['first_name'].' '.$r['last_name'] ?></td>
                <td><?= $r['employee_code'] ?></td>
                <td><?= $r['asset_name'] ?></td>
                <td><?= htmlspecialchars($r['serial_number']) ?></td>
                <td><?= $r['assigned_at'] ?></td>
                <td>
                    <button 
                        class="btn btn-sm btn-warning returnBtn" 
                        data-id="<?= $r['id'] ?>" 
                        data-asset="<?= $r['asset_id'] ?>">
                        Mark Returned
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
$(".returnBtn").on("click", function(){
    let id = $(this).data('id');
    let asset_id = $(this).data('asset');

    let condition = prompt("Enter condition on return (e.g., Good, Broken, Scratched):", "Good");
    if (condition === null) return;

    let damaged = confirm("Is the asset damaged? Click OK for Yes, Cancel for No.");

    $.post("../../ajax/asset_return_ajax.php", {
        employee_asset_id: id,
        asset_id: asset_id,
        condition_on_return: condition,
        damaged: damaged ? 1 : 0
    }, function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, 'json');
});
</script>
</body>
</html>
