<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: /endpoints/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="login-container">
  <h2>Admin Dashboard</h2>
  <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>

  <ul>
    <li><a href="/endpoints/register.php">Add New User</a></li>
    <li><a href="/endpoitns/view_users.php">View All Users</a></li>
    <li><a href="/endpoints/logout.php">Logout</a></li>
  </ul>
</div>

</body>
</html>
