<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

$types = $pdo->query("SELECT * FROM leave_types ORDER BY id DESC")->fetchAll();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo htmlspecialchars($_SESSION['name']); ?> | Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="../../assets/css/admin.css">

        <!-- CDN LINK FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    </head>
    <body>

    <section class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 leftside-container">
                    <div class="pt-5 text-center">
                        <img src="../../assets/images/user.png" alt="">
                        <h5 class="mt-3"><?php echo htmlspecialchars($_SESSION['name']); ?></h5>
                        <p class="text-muted text-uppercase"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                    </div>
                    <?php include '../sidebar-inner.php'; ?>
                </div>
                <div class="col-sm-10 rightside-container">
                    <div class="card shadow card-height">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <h6 class="user-text text-end"><img src="../../assets/images/user.png" alt=""> Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h6>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <h2 class="employee-text">Leave Types</h2>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    <a href="leave_list.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> View Leave Requests</a>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <form id="leaveTypeForm" class="row mb-4">
                                    <div class="col-md-2">
                                        <label>Leave Name *</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Days/Year *</label>
                                        <input type="number" name="days" class="form-control" required>
                                    </div>

                                    <div class="col-md-2 align-self-end">
                                        <button class="btn btn-green"><i class="fa-solid fa-plus"></i> Add Leave Type</button>
                                    </div>
                                </form>
                                <div class="col-sm-12">
                                    <table id="employee-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Days/Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($types as $t): ?>
                                                <tr>
                                                    <td><?= $t['name'] ?></td>
                                                    <td><?= $t['days_per_year'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    new DataTable('#employee-table', {
        responsive: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100]
    });
</script>
</body>
</html>
<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Leave Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<div class="container mt-4">
    <h3>Leave Types</h3>
    <hr>

    <div id="alert-box"></div>

    <form id="leaveTypeForm" class="row g-3 mb-4">
        <div class="col-md-4">
            <label>Leave Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-2">
            <label>Days/Year *</label>
            <input type="number" name="days" class="form-control" required>
        </div>

        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary">Add Leave Type</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Days/Year</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($types as $t): ?>
                <tr>
                    <td><?= $t['name'] ?></td>
                    <td><?= $t['days_per_year'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
$("#leaveTypeForm").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/leave_type_add_ajax.php", $(this).serialize(), function(res){
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        if(res.status === "success"){
            setTimeout(()=> location.reload(), 1000);
        }
    }, "json");
});
</script>

</body>
</html> -->
