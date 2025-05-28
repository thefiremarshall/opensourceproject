<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="login-container">
  <h2>Register</h2>

  <form action="register_user.php" method="POST">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <label>Plan</label>
    <select name ="plan">
    <option value= 2 selected>-- Select a Plan --</option>
    <option value= 1 >test</option> 
    </select>

    <label>Role</label>
    <select name="role" required>
      <option value="insurance_holder">Insurance Holder</option>
      <option value="doctor">Doctor</option>
      <option value="admin">Admin</option>
    </select>

    <button type="submit">Register</button>
  </form>
</div>

</body>
</html>
