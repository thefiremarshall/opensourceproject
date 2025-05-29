<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
<title>Health Insurance Manager</title>
  <link rel="stylesheet" href="/style.css">
    <nav class="navbar">
        <div class="logo">Health Insurance Manager</div>
        <ul class="nav-links">
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="/endpoints/admin_dashboard.php">Dashboard</a></li>
                    <li><a href="/endpoints/register.php">Add User</a></li>
                    <li><a href="/endpoints/manage_users.php">Manage Users</a></li>
                <?php elseif ($_SESSION['role'] === 'doctor'): ?>
                    <li><a href="/endpoints/doctor_dashboard.php">Dashboard</a></li>
                    <li><a href="/endpoints/add_visit.php">Add Visit</a></li>
                <?php elseif ($_SESSION['role'] === 'patient'): ?>
                    <li><a href="/endpoints/user_dashboard.php">Dashboard</a></li>
                    <li><a href="/endpoints/add_claim.php">Add Calim</a></li>
                    <li><a href="/endpoints/view_claims.php">My Claims</a></li>
                <?php endif; ?>
                <li><a href="/endpoints/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/index.php">Home</a></li>
                <li><a href="/endpoints/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
