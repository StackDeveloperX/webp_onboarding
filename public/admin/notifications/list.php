<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$notifs = $pdo->query("
SELECT n.*, 
       (SELECT COUNT(*) FROM notification_users WHERE notification_id=n.id) AS sent_to
FROM notifications n
ORDER BY n.id DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">

    <a href="create.php" class="btn btn-primary btn-sm mb-3">+ Create Notification</a>

    <h3>All Notifications</h3>
    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Sent To</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($notifs as $n): ?>
            <tr>
                <td><?= $n['title'] ?></td>
                <td><?= ucfirst($n['type']) ?></td>
                <td><?= $n['sent_to'] ?> users</td>
                <td><?= $n['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
