<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$stmt = $pdo->query("
SELECT r.*, e.first_name, e.last_name, u.name AS reviewer
FROM performance_reviews r
JOIN employees e ON r.employee_id = e.id
LEFT JOIN users u ON r.reviewed_by = u.id
ORDER BY r.id DESC
");
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Performance Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">

    <a href="add.php" class="btn btn-primary btn-sm mb-3">+ Add Review</a>

    <h3>Performance Reviews</h3>
    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Reviewed By</th>
                <th>Reviewed At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reviews as $r): ?>
                <tr>
                    <td><?= $r['first_name'] . ' ' . $r['last_name'] ?></td>
                    <td><?= $r['review_period'] ?></td>
                    <td><strong><?= $r['rating'] ?></strong></td>
                    <td><?= $r['comments'] ?></td>
                    <td><?= $r['reviewer'] ?></td>
                    <td><?= $r['reviewed_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
