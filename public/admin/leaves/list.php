<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$stmt = $pdo->query("
SELECT l.*, t.name AS type_name, e.first_name, e.last_name
FROM employee_leaves l
JOIN leave_types t ON l.leave_type_id = t.id
JOIN employees e ON l.employee_id = e.id
ORDER BY l.id DESC
");
$requests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Leave Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>Leave Requests</h3>
    <hr>

    <div id="alert-box"></div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Applied On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requests as $r): ?>
                <tr>
                    <td><?= $r['first_name'].' '.$r['last_name'] ?></td>
                    <td><?= $r['type_name'] ?></td>
                    <td><?= $r['start_date'] ?></td>
                    <td><?= $r['end_date'] ?></td>
                    <td><?= ucfirst($r['status']) ?></td>
                    <td><?= $r['applied_at'] ?></td>
                    <td>
                        <?php if($r['status']=='pending'): ?>
                            <button class="btn btn-success btn-sm actionBtn" data-id="<?= $r['id'] ?>" data-action="approved">Approve</button>
                            <button class="btn btn-danger btn-sm actionBtn" data-id="<?= $r['id'] ?>" data-action="rejected">Reject</button>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
$(".actionBtn").click(function(){
    let id = $(this).data("id");
    let action = $(this).data("action");

    $.post("../../ajax/leave_action_ajax.php", {leave_id:id, action:action}, function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status == "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, 'json');
});
</script>

</body>
</html>
