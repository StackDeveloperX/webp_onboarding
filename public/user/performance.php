<?php
require_once '../../app/helpers/auth_helper.php';
requireEmployee();
require_once '../../app/config/database.php';

$employee_id = $_SESSION['employee_id'];

$stmt = $pdo->prepare("
SELECT r.*, u.name AS reviewer
FROM performance_reviews r
LEFT JOIN users u ON r.reviewed_by = u.id
WHERE r.employee_id = ?
ORDER BY r.id DESC
");

$stmt->execute([$employee_id]);
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Performance Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">

    <h3>My Performance Reviews</h3>
    <hr>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Review Period</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Reviewed By</th>
                <th>Reviewed At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reviews as $r): ?>
                <tr>
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
