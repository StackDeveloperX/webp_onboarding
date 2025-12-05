<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';
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
                                    <h2 class="employee-text">Employees</h2>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    <a href="add.php" class="btn btn-green"><i class="fa-solid fa-plus"></i> Add New Employee</a>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <table id="employee-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Emp Code</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Joining Date</th>
                                                <th style="width:150px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $stmt = $pdo->query("SELECT * FROM employees ORDER BY id DESC");
                                        while ($row = $stmt->fetch()):
                                        ?>
                                            <tr>
                                                <td><?= $row['employee_code'] ?></td>
                                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?= $row['department'] ?></td>
                                                <td><?= ucfirst($row['status']) ?></td>
                                                <td><?= $row['joining_date'] ?></td>
                                                <td>
                                                    <a href="view.php?id=<?= $row['id'] ?>" 
                                                    class="btn btn-green-sm btn-sm"><i class="fa-solid fa-eye"></i> View</a>

                                                    <?php if ($row['status'] == 'active') : ?>
                                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-green-outline btn-sm">
                                                        <i class="fa-solid fa-pencil"></i> Edit</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
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
