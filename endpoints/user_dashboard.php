<?php
session_start();
include '../includes/header2.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$user_id = $_SESSION['user_id'];
$visits = [];
$plan = null;
// $total_claims = 0;

// Fetch medical visits
$stmt = $conn->prepare("SELECT visit_date, symptoms, diagnosis, treatment_plan, visit_cost
                        FROM visits 
                        WHERE user_id = ? 
                        ORDER BY visit_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$visits = $result->fetch_all(MYSQLI_ASSOC);

// Fetch user's insurance plan
$stmt = $conn->prepare("SELECT p.plan_name, p.monthly_fee, p.coverage_limit, u.coverage_used
                        FROM users u 
                        JOIN Insurance_Plan p ON u.plan_id = p.plan_id 
                        WHERE u.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$plan_result = $stmt->get_result();
$plan = $plan_result->fetch_assoc();

?> 

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="/style2.css">
</head>
<body>

<main>
  <h2>My Health Information</h2>

  <div class="card">
    <h3>Recent Medical Visits</h3>
    <?php if (count($visits) > 0): ?>
    <table>
      <tr>
        <th>Date</th>
        <th>Symptoms</th>
        <th>Diagnosis</th>
        <th>Treatment</th>
        <th>Cost</th>
      </tr>
      <?php foreach ($visits as $visit): ?>
        <tr>
          <td><?= htmlspecialchars($visit['visit_date']) ?></td>
          <td><?= htmlspecialchars($visit['symptoms']) ?></td>
          <td><?= htmlspecialchars($visit['diagnosis']) ?></td>
          <td><?= htmlspecialchars($visit['treatment_plan']) ?></td>
          <td>$<?= number_format($visit['visit_cost'],2)?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
      <p>No medical visits recorded yet.</p>
    <?php endif; ?>
  </div>

  <div class="card">
    <h3>Insurance Coverage</h3>
    <?php if ($plan): ?>
      <p><strong>Plan:</strong> <?= htmlspecialchars($plan['plan_name']) ?></p>
      <p><strong>Monthly Fee:</strong> $<?= number_format($plan['monthly_fee'], 2) ?></p>
      <p><strong>Coverage Limit:</strong> $<?= number_format($plan['coverage_limit'], 2) ?></p>
     <p><strong>Claims Used:</strong> $<?= number_format($plan['coverage_used'], 2) ?></p>
      <p><strong>Remaining Coverage:</strong> $<?= number_format($plan['coverage_limit']-$plan['coverage_used'], 2) ?></p>
    <?php else: ?>
      <p>No insurance plan assigned.</p>
    <?php endif; ?>
  </div> 
</main>

</body>
</html>
