<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$employees = $pdo->query("SELECT id, name FROM users WHERE role='employee' AND status='active'")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">

    <a href="list.php" class="btn btn-secondary btn-sm mb-3">← Back</a>

    <h3>Create Notification</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="notifyForm" class="row g-3">

        <div class="col-md-6">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label>Message *</label>
            <textarea name="message" class="form-control" required></textarea>
        </div>

        <div class="col-md-3">
            <label>Type *</label>
            <select name="type" class="form-control">
                <option value="info">Info</option>
                <option value="warning">Warning</option>
                <option value="alert">Alert</option>
                <option value="update">Update</option>
            </select>
        </div>

        <div class="col-md-12">
            <label>Select Employees (Optional)</label>
            <select name="employees[]" class="form-control" multiple>
                <?php foreach($employees as $emp): ?>
                    <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <small class="text-muted">Leave blank to send to ALL employees.</small>
        </div>

        <div class="col-md-3 mt-3">
            <button class="btn btn-success">Send Notification</button>
        </div>

    </form>

</div>

<script>
$("#notifyForm").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/notification_create_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.href="list.php", 1000);
        }
    }, "json");
});
</script>
</body>
</html>
