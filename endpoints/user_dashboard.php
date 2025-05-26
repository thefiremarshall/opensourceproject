<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<div class="login-container">
  <h2>User Hub</h2>
  <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

  <?php if ($_SESSION['role'] === 'insurance_holder'): ?>
    <ul>
      <li><a href="view_medical_history.php">View Medical History</a></li>
      <li><a href="view_claims.php">View Insurance Claims</a></li>
    </ul>
  <?php elseif ($_SESSION['role'] === 'doctor'): ?>
    <ul>
      <li><a href="search_patient.php">Search/Add Patient Record</a></li>
    </ul>
  <?php elseif ($_SESSION['role'] === 'admin'): ?>
    <ul>
      <li><a href="admin_dashboard.php">Go to Admin Dashboard</a></li>
    </ul>
  <?php endif; ?>

  <a href="logout.php">Logout</a>
</div>

</body>
</html>
