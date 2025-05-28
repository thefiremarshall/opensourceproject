<?php
include '../includes/header2.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<main>
<head>
<link rel="stylesheet" href="/style2.css">

</head>
  <h2>Admin Dashboard</h2>
  <div class="card">
    <h3>All Users Summary</h3>
    <table>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
      <!-- Sample data -->
      <tr>
        <td>1</td>
        <td>Jane Doe</td>
        <td>user</td>
        <td><a href="edit_user.php?id=1" class="button">Edit</a></td>
      </tr>
    </table>
  </div>

  <div class="card">
    <a href="register.php" class="button">Add New User</a>
  </div>
</main>
