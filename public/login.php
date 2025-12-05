<?php
// public/login.php
session_start();

// If already logged in, redirect
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] === 'employee') {
        header("Location: user/dashboard.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Employee Management Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <link rel="stylesheet" href="assets/css/style.css">
        </head>
    <body>

    <section class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 leftside-column">
                    <h3 class="main-title text-center mb-3">Employee Login</h3>

                    <div id="alert-box" class="alert d-none"></div>
                    <form id="loginForm">
                        <div class="mb-4">
                            <input type="email" class="form-control new-control" name="email" id="email" placeholder="Email Address" required>
                        </div>

                        <div class="mb-4">
                            <input type="password" class="form-control new-control" name="password" id="password" placeholder="Password" required>
                        </div>

                        <button type="submit" id="loginBtn" class="btn btn-green w-100">
                            Login
                        </button>
                    </form>

                    <p class="text-center mt-5">A Product By <a href="https://webp.com.au">Web Professionals</a></p>
                </div>
                <div class="col-sm-6 rightside-column">
                    <img src="assets/images/login.jpg" class="login-img" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- <div class="container d-flex justify-content-center align-items-center login-container">
        <div class="card login-card shadow-sm p-4">
            <h3 class="text-center mb-3">Employee Management Login</h3>
            <div id="alert-box" class="alert d-none"></div>

            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <button type="submit" id="loginBtn" class="btn btn-primary w-100">
                    Login
                </button>
            </form>
        </div>
    </div> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        $('#loginBtn').prop('disabled', true).text('Logging in...');

        $.ajax({
            url: 'ajax/login_ajax.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#loginBtn').prop('disabled', false).text('Login');

                if (response.status === 'success') {
                    $('#alert-box')
                        .removeClass('d-none alert-danger')
                        .addClass('alert alert-success')
                        .text(response.message);

                    window.location.href = response.redirect;
                } else {
                    $('#alert-box')
                        .removeClass('d-none alert-success')
                        .addClass('alert alert-danger')
                        .text(response.message);
                }
            },
            error: function () {
                $('#loginBtn').prop('disabled', false).text('Login');
                $('#alert-box')
                    .removeClass('d-none alert-success')
                    .addClass('alert alert-danger')
                    .text('Something went wrong. Please try again.');
            }
        });
    });
});
</script>
</body>
</html>
