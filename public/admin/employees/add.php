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

        <style>
            .step-box { display: none; }
            .step-active { display: block; }
            .step-nav .nav-item { width: 30%; text-align: center; margin: 10px;}
        </style>
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
                                    <h2 class="employee-text">Employee Onboarding</h2>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-end">
                                    
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <ul class="nav nav-pills mb-4 step-nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-step1">Step 1: Personal Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="nav-step2">Step 2: Job Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="nav-step3">Step 3: Documents</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="step-box step-active" id="step1">
                                    <h4 class="mb-3">Personal Information</h4>

                                    <form id="step1Form">

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>First Name *</label>
                                                <input type="text" name="first_name" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Last Name *</label>
                                                <input type="text" name="last_name" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Email *</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Phone</label>
                                                <input type="text" name="phone" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option value="">Select</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control"></textarea>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>State</label>
                                                <input type="text" name="state" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Pincode</label>
                                                <input type="text" name="pincode" class="form-control">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-green">Save & Continue <i class="fa-solid fa-chevron-right"></i></button>
                                    </form>
                                </div>

                                <div class="step-box" id="step2">
                                    <h4 class="mb-3">Job Information</h4>

                                    <form id="step2Form">

                                        <input type="hidden" name="employee_id" id="employee_id">

                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <label>Department</label>
                                                <input type="text" name="department" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Designation</label>
                                                <input type="text" name="designation" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Reporting Manager</label>
                                                <select name="reporting_manager" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $mgr = $pdo->query("SELECT id, first_name, last_name FROM employees WHERE status='active'");
                                                    while($m = $mgr->fetch()):
                                                    ?>
                                                    <option value="<?= $m['id'] ?>"><?= $m['first_name'] . ' ' . $m['last_name'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Joining Date *</label>
                                                <input type="date" name="joining_date" class="form-control" required>
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-green">Save & Continue <i class="fa-solid fa-chevron-right"></i></button>

                                    </form>
                                </div>



                                <div class="step-box" id="step3">
                                    <h4 class="mb-3">Upload Documents</h4>

                                    <form id="step3Form" enctype="multipart/form-data">

                                        <input type="hidden" name="employee_id" id="employee_id_docs">

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Resume (PDF)</label>
                                                <input type="file" name="resume" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>Aadhar</label>
                                                <input type="file" name="aadhar" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>PAN</label>
                                                <input type="file" name="pan" class="form-control">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-green"><i class="fa-solid fa-plus"></i> Complete Onboarding</button>
                                    </form>
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


    <script>
    function goToStep(step){
        $(".step-box").removeClass("step-active");
        $(`#step${step}`).addClass("step-active");

        $(".nav-link").addClass("disabled");
        $(`#nav-step${step}`).removeClass("disabled").addClass("active");
    }



    // STEP 1 SUBMIT
    $("#step1Form").submit(function(e){
        e.preventDefault();

        $.post("../../ajax/employee_step1_ajax.php", $(this).serialize(), function(res){
            if(res.status === "success"){
                $("#employee_id").val(res.employee_id);
                $("#employee_id_docs").val(res.employee_id);

                goToStep(2);
            }
            $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        }, "json");
    });


    // STEP 2 SUBMIT
    $("#step2Form").submit(function(e){
        e.preventDefault();

        $.post("../../ajax/employee_step2_ajax.php", $(this).serialize(), function(res){
            if(res.status === "success"){
                goToStep(3);
            }
            $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        }, "json");
    });


    // STEP 3 SUBMIT
    $("#step3Form").submit(function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "../../ajax/employee_step3_ajax.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(res){
                if(res.status === "success"){
                    window.location.href = "list.php";
                }
                $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
            }
        });
    });
    </script>

</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Employee Onboarding - Step by Step</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        .step-box { display: none; }
        .step-active { display: block; }
        .step-nav .nav-item { width: 33.3%; text-align: center; }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Employee Onboarding</h2>
    <hr>

    <ul class="nav nav-pills mb-4 step-nav">
        <li class="nav-item">
            <a class="nav-link active" id="nav-step1">Step 1: Personal Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" id="nav-step2">Step 2: Job Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" id="nav-step3">Step 3: Documents</a>
        </li>
    </ul>

    <div id="alert-box"></div>

    
    <div class="step-box step-active" id="step1">
        <h4 class="mb-3">Personal Information</h4>

        <form id="step1Form">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>First Name *</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">Select</option>
                        <option>male</option>
                        <option>female</option>
                        <option>other</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save & Continue</button>
        </form>
    </div>



    
    <div class="step-box" id="step2">
        <h4 class="mb-3">Job Information</h4>

        <form id="step2Form">

            <input type="hidden" name="employee_id" id="employee_id">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Department</label>
                    <input type="text" name="department" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Designation</label>
                    <input type="text" name="designation" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Reporting Manager</label>
                    <select name="reporting_manager" class="form-control">
                        <option value="">Select</option>
                        <?php
                        $mgr = $pdo->query("SELECT id, first_name, last_name FROM employees WHERE status='active'");
                        while($m = $mgr->fetch()):
                        ?>
                        <option value="<?= $m['id'] ?>"><?= $m['first_name'] . ' ' . $m['last_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Joining Date *</label>
                    <input type="date" name="joining_date" class="form-control" required>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Save & Continue</button>

        </form>
    </div>



    <div class="step-box" id="step3">
        <h4 class="mb-3">Upload Documents</h4>

        <form id="step3Form" enctype="multipart/form-data">

            <input type="hidden" name="employee_id" id="employee_id_docs">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Resume (PDF)</label>
                    <input type="file" name="resume" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Aadhar</label>
                    <input type="file" name="aadhar" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>PAN</label>
                    <input type="file" name="pan" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Complete Onboarding</button>
        </form>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
function goToStep(step){
    $(".step-box").removeClass("step-active");
    $(`#step${step}`).addClass("step-active");

    $(".nav-link").addClass("disabled");
    $(`#nav-step${step}`).removeClass("disabled").addClass("active");
}



// STEP 1 SUBMIT
$("#step1Form").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/employee_step1_ajax.php", $(this).serialize(), function(res){
        if(res.status === "success"){
            $("#employee_id").val(res.employee_id);
            $("#employee_id_docs").val(res.employee_id);

            goToStep(2);
        }
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
    }, "json");
});


// STEP 2 SUBMIT
$("#step2Form").submit(function(e){
    e.preventDefault();

    $.post("../../ajax/employee_step2_ajax.php", $(this).serialize(), function(res){
        if(res.status === "success"){
            goToStep(3);
        }
        $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
    }, "json");
});


// STEP 3 SUBMIT
$("#step3Form").submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "../../ajax/employee_step3_ajax.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(res){
            if(res.status === "success"){
                window.location.href = "list.php";
            }
            $("#alert-box").html(`<div class="alert alert-${res.status}">${res.message}</div>`);
        }
    });
});
</script>

</body>
</html> -->
