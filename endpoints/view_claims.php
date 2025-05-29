<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header2.php';


$userId = $_SESSION['user_id'];
$query = $conn->prepare("SELECT claim_id, user_id, amount, date_submitted, status FROM claims WHERE user_id = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();
?>
<head>
<link rel="stylesheet" href="/style2.css">
</head>
<h2>My Insurance Claims</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['date_submitted']) ?></td>
        <td>$<?= number_format($row['amount'],2) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>
