<?php
include '../includes/header2.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

// Handle Approve/Deny actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claim_id']) && isset($_POST['action'])) {
    $claim_id = $_POST['claim_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Fetch claim and user details
        $stmt = $conn->prepare("SELECT c.amount, u.user_id, u.coverage_used, p.coverage_limit, p.refund_amount
                                FROM claims c
                                JOIN users u ON c.user_id = u.user_id
                                JOIN Insurance_Plan p ON u.plan_id = p.plan_id
                                WHERE c.claim_id = ?");
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();
        $stmt->bind_result($amount, $user_id, $coverage_used, $coverage_limit, $refund_percent);
        $stmt->fetch();
        $stmt->close();

        $refund = ($refund_percent / 100) * $amount;
        $new_coverage_used = $coverage_used + $refund;

        if ($new_coverage_used <= $coverage_limit) {
            // Update claim status and user's coverage_used
            $conn->begin_transaction();
            $conn->query("UPDATE claims SET status = 'Approved' WHERE claim_id = $claim_id");
            $conn->query("UPDATE users SET coverage_used = $new_coverage_used WHERE user_id = $user_id");
            $conn->commit();
        } else {
            echo "<p class='error'>Cannot approve claim: exceeds coverage limit.</p>";
        }
    } elseif ($action === 'deny') {
        $stmt = $conn->prepare("UPDATE claims SET status = 'Denied' WHERE claim_id = ?");
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<main>
<head>
  <link rel="stylesheet" href="/style2.css">
</head>

<h2>Admin Dashboard – Review Claims</h2>

<div class="card">
  <table>
    <tr>
      <th>Claim ID</th>
      <th>User</th>
      <th>Amount</th>
      <th>Date Submitted</th>
      <th>Status</th>
      <th>Plan</th>
      <th>Refund %</th>
      <th>Action</th>
    </tr>

    <?php
    $query = "SELECT c.claim_id, c.amount, c.date_submitted, c.status, 
                     u.full_name, u.user_id, p.plan_name, p.refund_amount
              FROM claims c
              JOIN users u ON c.user_id = u.user_id
              JOIN Insurance_Plan p ON u.plan_id = p.plan_id
              ORDER BY c.date_submitted DESC";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= $row['claim_id'] ?></td>
      <td><?= htmlspecialchars($row['full_name']) ?></td>
      <td>$<?= $row['amount'] ?></td>
      <td><?= $row['date_submitted'] ?></td>
      <td><?= $row['status'] ?></td>
      <td><?= $row['plan_name'] ?></td>
      <td><?= $row['refund_amount'] ?>%</td>
      <td>
        <?php if ($row['status'] === 'Pending'): ?>
        <form method="POST" style="display:inline">
          <input type="hidden" name="claim_id" value="<?= $row['claim_id'] ?>">
          <button type="submit" name="action" value="approve">✅ Approve</button>
          <button type="submit" name="action" value="deny">❌ Deny</button>
        </form>
        <?php else: ?>
        <em><?= $row['status'] ?></em>
        <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</main>
