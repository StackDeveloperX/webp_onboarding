<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
SELECT n.*, nu.is_read, nu.id AS nu_id
FROM notification_users nu
JOIN notifications n ON nu.notification_id = n.id
WHERE nu.user_id = ?
ORDER BY n.id DESC
");
$stmt->execute([$user_id]);
$notifs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container mt-4">

    <h3>Notifications</h3>
    <hr>

    <div id="alert-box"></div>

    <?php foreach($notifs as $n): ?>
        <div class="alert alert-<?= $n['type'] ?> <?= $n['is_read']==0 ? 'border border-dark' : '' ?>">
            <strong><?= $n['title'] ?></strong><br>
            <?= nl2br($n['message']) ?><br>
            <small><?= $n['created_at'] ?></small>

            <?php if($n['is_read']==0): ?>
            <button class="btn btn-sm btn-primary markReadBtn" data-id="<?= $n['nu_id'] ?>">Mark as Read</button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>

<script>
$(".markReadBtn").click(function(){
    let id = $(this).data("id");

    $.post("../ajax/notification_mark_read_ajax.php", {id:id}, function(res){
        if(res.status === "success"){
            location.reload();
        }
    }, "json");
});
</script>

</body>
</html>
