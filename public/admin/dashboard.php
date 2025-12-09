<?php
require_once '../../app/helpers/auth_helper.php';
requireAdmin();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo htmlspecialchars($_SESSION['name']); ?> | Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/css/admin.css">

        <!-- CDN LINK FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
    
    
    <section class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 leftside-container">
                    <div class="close-sidebar d-lg-none" id="closeSidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </div>

                    <div class="mob-margin">
                        <div class="pt-5 text-center">
                            <img src="../assets/images/user.png" alt="">
                            <h5 class="mt-3"><?php echo htmlspecialchars($_SESSION['name']); ?></h5>
                            <p class="text-muted text-uppercase"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                        </div>

                        <?php include 'sidebar.php'; ?>
                    </div>
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
                                <div class="col-sm-4 tab-mob-100wd">
                                    <h6 class="user-text text-end"><img src="../assets/images/user.png" alt=""> Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h6>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-4 tab-mob-50w mob">
                                    <div class="card shadow grey-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-8 icon-numbers">
                                                    <i class="fa-solid fa-users"></i>
                                                    <h3>Total Employee</h3>
                                                </div>
                                                <div class="col-sm-4 numbers-card">
                                                    <h1>0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 tab-mob-50w">
                                    <div class="card shadow green-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-8 icon-numbers">
                                                    <i class="fa-regular fa-calendar-days"></i>
                                                    <h3>Pending Leave Requests</h3>
                                                </div>
                                                <div class="col-sm-4 numbers-cards">
                                                    <h1>0</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
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
