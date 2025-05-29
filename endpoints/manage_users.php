<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header2.php';

$result = $conn->query("SELECT user_id, username, full_name, role FROM users");
?>

<head>
  <link rel="stylesheet" href="/style2.css">
</head>

<main>
  <h2>User Management</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Full Name</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
    <?php while ($user = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($user['user_id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['full_name']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
          <?php if ($user['role'] !== 'admin' && $user['user_id'] !== $_SESSION['user_id']): ?>
            <form action="delete_user.php" method="POST" style="display:inline;">
              <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
              <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
            </form>
          <?php else: ?>
            <em>Protected</em>
          <?php endif; ?>

          <form action="change_password.php" method="POST" style="display:inline;">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit">Update Password</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</main>
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert success"><?= $_SESSION['success'] ?></div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert error"><?= $_SESSION['error'] ?></div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>