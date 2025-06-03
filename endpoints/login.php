<?php session_start();
  include('../includes/header2.php');
  include('../includes/head.php');
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="/style2.css">
</head>
<body>

<div class="login-container">
  <h2>Login</h2>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form action="/includes/authenticate.php" method="POST">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
