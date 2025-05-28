<?php
session_start();
$role = $_SESSION['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Health Insurance Manager</title>
  <link rel="stylesheet" href="/style2.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <?php if ($role === 'doctor'): ?>
          <li><a href="doctor_dashboard.php">Doctor Dashboard</a></li>
        <?php elseif ($role === 'admin'): ?>
          <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
        <?php elseif ($role === 'user'): ?>
          <li><a href="user_dashboard.php">My Info</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
