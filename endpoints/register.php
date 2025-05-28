<?php
session_start();
include('../includes/header2.php');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'doctor'])) {
  header("Location: login.php");
  exit;
}

$isAdmin = $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="login-container">
  <h2>Register a New User</h2>

  <?php
  if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    echo "<p class='success'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
  }
  ?>

  <form action="register_user.php" method="POST">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <label>Plan</label>
    <select name="plan_id"  >
      <option value= 2 selected >-- Select a Plan --</option>
      <option value= 1 >Test</option>
    </select>

    <?php if ($isAdmin): ?>
      <label>Role</label>
      <select name="role" required>
        <option value="patient">Insurance Holder</option>
        <option value="doctor">Doctor</option>
        <option value="admin">Admin</option>
      </select>
    <?php else: ?>
      <!-- Doctors can only add patients -->
      <input type="hidden" name="role" value="patient">
    <?php endif; ?>

    <button type="submit">Register</button>
  </form>
</div>

</body>
</html>
