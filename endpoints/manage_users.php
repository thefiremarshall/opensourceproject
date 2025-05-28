<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header2.php';

$result = $conn->query("SELECT user_id, username, role FROM users");
?>
<head>
<link rel="stylesheet" href="/style2.css">

</head>
<h2>User Management</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php while ($user = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($user['user_id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>
