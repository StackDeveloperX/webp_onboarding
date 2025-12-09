<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';

if (!isset($_GET['id'])) { die("Employee ID missing."); }

$employee_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$employee_id]);
$emp = $stmt->fetch();

if (!$emp) { die("Employee not found."); }
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

        <!-- SweetAlert JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body>

    <section class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 leftside-container">
                    <div class="close-sidebar d-lg-none" id="closeSidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </div>

                    <div class="pt-5 text-center">
                        <img src="../../assets/images/user.png" alt="">
                        <h5 class="mt-3"><?php echo htmlspecialchars($_SESSION['name']); ?></h5>
                        <p class="text-muted text-uppercase"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                    </div>
                    <?php include '../sidebar-inner.php'; ?>
                </div>
                <div class="mobile-menu-icon d-lg-none d-md-block" id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
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
                                    <h2 class="employee-text"><?php echo htmlspecialchars($emp['first_name'] . " " . $emp['last_name']); ?> | Edit Details</h2>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    
                                </div>
                            </div>

                            <a href="list.php" class="btn btn-green-sm"><i class="fa-solid fa-chevron-left"></i> Back To List</a>

                            <form id="editEmployeeForm" class="mt-4" enctype="multipart/form-data">
                                <input type="hidden" name="employee_id" class="form-control" value="<?= $employee_id ?>">
                                <h3 class="details-title">Personal Information</h3>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h4>First Name</h4>
                                        <input type="text" name="first_name" class="form-control" value="<?= $emp['first_name'] ?>">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <h4>Last Name</h4>
                                        <input type="text" name="last_name" class="form-control" value="<?= $emp['last_name'] ?>">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <h4>Email</h4>
                                        <input type="email" name="email" class="form-control" value="<?= $emp['email'] ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>Phone</h4>
                                        <input type="text" name="phone" class="form-control" value="<?= $emp['phone'] ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>DOB</h4>
                                        <input type="date" name="dob" class="form-control" value="<?= $emp['dob'] ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>Gender</h4>
                                        <select name="gender" class="form-control">
                                            <option <?= $emp['gender']=='male'?'selected':'' ?>>male</option>
                                            <option <?= $emp['gender']=='female'?'selected':'' ?>>female</option>
                                            <option <?= $emp['gender']=='other'?'selected':'' ?>>other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>City</h4>
                                        <input type="text" name="city" class="form-control" value="<?= $emp['city'] ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>State</h4>
                                        <input type="text" name="state" class="form-control" value="<?= $emp['state'] ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <h4>Pincode</h4>
                                        <input type="text" name="pincode" class="form-control" value="<?= $emp['pincode'] ?>">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <h4>Address</h4>
                                        <textarea name="address" class="form-control"><?= $emp['address'] ?></textarea>
                                    </div>
                                </div>

                                <h3 class="details-title mt-3">Job Information</h3>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <h4>Department</h4>
                                        <input type="text" name="department" class="form-control" value="<?= $emp['department'] ?>">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <h4>Designation</h4>
                                        <input type="text" name="designation" class="form-control" value="<?= $emp['designation'] ?>">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <h4>Reporting Manager</h4>
                                        <select name="reporting_manager" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            $mgr = $pdo->query("SELECT id, first_name, last_name FROM employees WHERE status='active'");
                                            while($m=$mgr->fetch()):
                                            ?>
                                            <option value="<?= $m['id'] ?>" <?= $emp['reporting_manager']==$m['id']?'selected':'' ?>>
                                                <?= $m['first_name'].' '.$m['last_name'] ?>
                                            </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <h4>Joining Date</h4>
                                        <input type="date" name="joining_date" class="form-control" value="<?= $emp['joining_date'] ?>">
                                    </div>
                                </div>

                                <h3 class="details-title mt-3">Documents</h3>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Resume</label>
                                        <input type="file" name="resume" class="form-control">
                                        <?php if($emp['resume']){ ?>
                                        <small>Current: <?= $emp['resume'] ?></small>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Aadhar</label>
                                        <input type="file" name="aadhar" class="form-control">
                                        <?php if($emp['aadhar']){ ?>
                                        <small>Current: <?= $emp['aadhar'] ?></small>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>PAN</label>
                                        <input type="file" name="pan" class="form-control">
                                        <?php if($emp['pan']){ ?>
                                        <small>Current: <?= $emp['pan'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>

                                <button type="submit" id="update_emp" class="btn btn-green">Update Employee</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $("#editEmployeeForm").on("submit", function(e){
            e.preventDefault();

            $('#update_emp').prop('disabled', true).text('Updating...');

            let formData = new FormData(this);

            $.ajax({
                url: "../../ajax/employee_edit_ajax.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: (res) => {

                    // SweetAlert2 Popup
                    Swal.fire({
                        title: res.status === "success" ? "Success!" : "Error!",
                        text: res.message,
                        icon: res.status === "success" ? "success" : "error",
                        confirmButtonText: "OK"
                    });

                    // If success → reload after 1.5 sec (optional)
                    if (res.status === "success") {
                        setTimeout(() => {
                            if (res.status === "success") {
                                window.location.href = "list.php"; 
                            }
                        }, 1500);
                    }
                },

                error: () => {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    </script>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.querySelector('.leftside-container').classList.add('active');
        });

        document.getElementById('closeSidebar').addEventListener('click', function () {
            document.querySelector('.leftside-container').classList.remove('active');
        });
    </script>
</body>
</html>