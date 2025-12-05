<?php
$current_page = basename($_SERVER['PHP_SELF']);
$employee_pages = ['list.php', 'add.php', 'edit.php', 'view.php'];

$leaves_pages = ['leave_list.php','leave_types.php'];
?>

<div class="menu-nav">
    <p class="<?php echo ($current_page == 'dashboard.php') ? 'menu-active' : ''; ?>">
        <a href="../dashboard.php" class="menu-item">
            <i class="fa-solid fa-grip"></i> Dashboard
        </a>
    </p>

    <p class="<?php echo (in_array($current_page, $employee_pages)) ? 'menu-active' : ''; ?>">
        <a href="../employees/list.php" class="menu-item">
            <i class="fa-solid fa-users"></i> Employees
        </a>
    </p>

    <p class="<?php echo ($current_page == 'attendance.php') ? 'menu-active' : ''; ?>">
        <a href="attendance.php" class="menu-item">
            <i class="fa-solid fa-calendar"></i> Attendance
        </a>
    </p>

    <p class="<?php echo (in_array($current_page, $leaves_pages)) ? 'menu-active' : ''; ?>">
        <a href="../leaves/leave_list.php" class="menu-item">
            <i class="fa-solid fa-calendar-check"></i> Leaves
        </a>
    </p>

    <p>
        <a href="../logout.php" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </p>
</div>