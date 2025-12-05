<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

// fetch exit requests + employee details
$stmt = $pdo->query("
    SELECT ex.*, e.first_name, e.last_name, e.employee_code, e.department, e.designation
    FROM employee_exit ex
    JOIN employees e ON ex.employee_id = e.id
    ORDER BY ex.id DESC
");
$exits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exit Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <a href="../dashboard.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <h3>Employee Exit Requests</h3>
    <hr>

    <div id="alert-box"></div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Code</th>
                <th>Dept</th>
                <th>Designation</th>
                <th>Resignation Date</th>
                <th>Last Working Day</th>
                <th>Status</th>
                <th>Pending Assets</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($exits as $ex): ?>
                <?php
                // Count pending (not returned) assets
                $assetStmt = $pdo->prepare("
                    SELECT COUNT(*) FROM employee_assets 
                    WHERE employee_id = ? AND returned_at IS NULL
                ");
                $assetStmt->execute([$ex['employee_id']]);
                $pendingAssets = $assetStmt->fetchColumn();
                ?>
                <tr>
                    <td><?= $ex['first_name'].' '.$ex['last_name'] ?></td>
                    <td><?= $ex['employee_code'] ?></td>
                    <td><?= $ex['department'] ?></td>
                    <td><?= $ex['designation'] ?></td>
                    <td><?= $ex['resignation_date'] ?></td>
                    <td><?= $ex['last_working_day'] ?></td>
                    <td><?= ucfirst($ex['clearance_status']) ?></td>
                    <td>
                        <?php if ($pendingAssets > 0): ?>
                            <span class="badge bg-danger"><?= $pendingAssets ?> pending</span>
                        <?php else: ?>
                            <span class="badge bg-success">None</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($ex['clearance_status'] === 'pending'): ?>
                            <button 
                                class="btn btn-sm btn-success completeBtn" 
                                data-id="<?= $ex['id'] ?>" 
                                data-emp="<?= $ex['employee_id'] ?>" 
                                data-assets="<?= $pendingAssets ?>">
                                Mark Clearance Completed
                            </button>
                        <?php else: ?>
                            <a href="relieving_letter.php?id=<?= $ex['id'] ?>" class="btn btn-sm btn-outline-primary">
                                Relieving Letter
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
$(".completeBtn").on("click", function(){
    let exit_id = $(this).data("id");
    let emp_id  = $(this).data("emp");
    let pendingAssets = parseInt($(this).data("assets"));

    if (pendingAssets > 0) {
        if(!confirm("There are pending assets for this employee. Do you still want to complete clearance?")){
            return;
        }
    }

    $.post("../../ajax/exit_clearance_ajax.php", {
        exit_id: exit_id,
        employee_id: emp_id
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
