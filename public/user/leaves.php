<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

$types = $pdo->query("SELECT * FROM leave_types")->fetchAll();

// Fetch history
$stmt = $pdo->prepare("SELECT l.*, t.name AS type_name 
                       FROM employee_leaves l 
                       JOIN leave_types t ON l.leave_type_id = t.id
                       WHERE employee_id = ?
                       ORDER BY id DESC");
$stmt->execute([$employee_id]);
$history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">

    <h3>Apply for Leave</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="leaveApplyForm" class="row g-3">
        <div class="col-md-4">
            <label>Leave Type *</label>
            <select name="leave_type" class="form-control" required>
                <option value="">Select</option>
                <?php foreach($types as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label>Start Date *</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label>End Date *</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label>Reason *</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>

        <div class="col-md-3">
            <button class="btn btn-success">Apply Leave</button>
        </div>
    </form>

    <hr>

    <h4>My Leave History</h4>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Applied On</th>
                <th>Cancel</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($history as $row): ?>
                <tr>
                    <td><?= $row['type_name'] ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td><?= $row['applied_at'] ?></td>
                    <td>
                        <?php if($row['status'] === 'pending'): ?>
                            <button class="btn btn-danger btn-sm cancelBtn" data-id="<?= $row['id'] ?>">Cancel</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$("#leaveApplyForm").submit(function(e){
    e.preventDefault();

    $.post("../ajax/leave_apply_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, "json");
});

$(".cancelBtn").on("click", function(){
    let id = $(this).data("id");

    $.post("../ajax/leave_cancel_ajax.php", {leave_id:id}, function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, "json");
});
</script>

</body>
</html>
