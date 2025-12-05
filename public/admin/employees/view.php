<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

if (!isset($_GET['id'])) {
    die("Employee ID missing.");
}

$employee_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$employee_id]);
$emp = $stmt->fetch();

if (!$emp) {
    die("Employee not found.");
}
?>

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
                                    <h2 class="employee-text"><?php echo htmlspecialchars($emp['first_name'] . " " . $emp['last_name']); ?> | Details</h2>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    
                                </div>
                            </div>

                            <a href="list.php" class="btn btn-green-sm"><i class="fa-solid fa-chevron-left"></i> Back To List</a>
                            
                            <div class="row mt-4">
                                <div class="col-sm-6">
                                    <h4 class="details-title">Personal Information</h4>
                                    <table class="table table-bordered">
                                        <tr><th>Employee Code</th><td><?= $emp['employee_code'] ?></td></tr>
                                        <tr><th>Name</th><td><?= $emp['first_name'] . " " . $emp['last_name'] ?></td></tr>
                                        <tr><th>Email</th><td><?= $emp['email'] ?></td></tr>
                                        <tr><th>Phone</th><td><?= $emp['phone'] ?></td></tr>
                                        <tr><th>DOB</th><td><?= $emp['dob'] ?></td></tr>
                                        <tr><th>Gender</th><td><?= ucfirst($emp['gender']) ?></td></tr>
                                        <tr><th>Address</th><td><?= $emp['address'] ?></td></tr>
                                        <tr><th>City</th><td><?= $emp['city'] ?></td></tr>
                                        <tr><th>State</th><td><?= $emp['state'] ?></td></tr>
                                        <tr><th>Pincode</th><td><?= $emp['pincode'] ?></td></tr>
                                    </table>

                                    

                                    <?php if ($emp['status'] == 'active') : ?>
                                        <a href="edit.php?id=<?= $employee_id ?>" class="btn btn-green"><i class="fa-solid fa-pencil"></i> Edit Employee</a>
                                    <?php endif; ?>
                                
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="details-title">Job Information</h4>
                                    <table class="table table-bordered">
                                        <tr><th>Department</th><td><?= $emp['department'] ?></td></tr>
                                        <tr><th>Designation</th><td><?= $emp['designation'] ?></td></tr>
                                        <tr><th>Reporting Manager</th>
                                            <td>
                                                <?php
                                                if ($emp['reporting_manager']) {
                                                    $mgr = $pdo->query("SELECT first_name, last_name FROM employees WHERE id={$emp['reporting_manager']}")->fetch();
                                                    echo $mgr['first_name'] . " " . $mgr['last_name'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr><th>Joining Date</th><td><?= $emp['joining_date'] ?></td></tr>
                                        <tr><th>Status</th><td><?= ucfirst($emp['status']) ?></td></tr>
                                    </table>

                                    <h4 class="details-title mt-3">Documents</h4>
                                    <table class="table table-bordered" style="max-width:500px;">
                                        <tr>
                                            <th>Resume</th>
                                            <td>
                                                <?php if ($emp['resume']) { ?>
                                                <a class="details-link" href="../../assets/uploads/employee_docs/<?= $employee_id ?>/<?= $emp['resume'] ?>" target="_blank"><i class="fa-solid fa-eye"></i> View</a>
                                                <?php } else { echo "Not Uploaded"; } ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Aadhar</th>
                                            <td>
                                                <?php if ($emp['aadhar']) { ?>
                                                <a class="details-link" href="../../assets/uploads/employee_docs/<?= $employee_id ?>/<?= $emp['aadhar'] ?>" target="_blank"><i class="fa-solid fa-eye"></i> View</a>
                                                <?php } else { echo "Not Uploaded"; } ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>PAN</th>
                                            <td>
                                                <?php if ($emp['pan']) { ?>
                                                <a class="details-link" href="../../assets/uploads/employee_docs/<?= $employee_id ?>/<?= $emp['pan'] ?>" target="_blank"><i class="fa-solid fa-eye"></i> View</a>
                                                <?php } else { echo "Not Uploaded"; } ?>
                                            </td>
                                        </tr>
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