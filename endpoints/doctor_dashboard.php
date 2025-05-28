<?php
session_start();
include('../includes/header2.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit;
}

require('../includes/db.php');

// Handle search query
$patient_id = isset($_GET['patient_id']) ? trim($_GET['patient_id']) : '';
$patient_visits = [];
$patient_name = '';

if (!empty($patient_id)) {
    // Get patient's name
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE user_id = ? AND role = 'patient'");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($patient_name);
        $stmt->fetch();

        // Get visit records
        $stmt_visits = $conn->prepare("SELECT visit_date, symptoms, diagnosis, treatment_plan 
                                       FROM visits 
                                       WHERE user_id = ? 
                                       ORDER BY visit_date DESC");
        $stmt_visits->bind_param("i", $patient_id);
        $stmt_visits->execute();
        $result = $stmt_visits->get_result();
        $patient_visits = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "No patient found with that ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="/style2.css">
</head>
<body>

<main>
  <h2>Doctor Dashboard</h2>

  <div class="card">
    <h3>Search or Add Patient Records</h3>
    <form action="doctor_dashboard.php" method="get">
      <label for="patient_id">Enter Patient ID:</label>
      <input type="text" id="patient_id" name="patient_id" required>
      <button type="submit">View</button>
    </form>
  </div>

  <?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php elseif (!empty($patient_visits)): ?>
    <div class="card">
      <h3>Medical History for <?= htmlspecialchars($patient_name) ?> (ID: <?= htmlspecialchars($patient_id) ?>)</h3>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Symptoms</th>
            <th>Diagnosis</th>
            <th>Medication</th>
            <th>Treatment Plan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($patient_visits as $visit): ?>
            <tr>
              <td><?= htmlspecialchars($visit['visit_date']) ?></td>
              <td><?= htmlspecialchars($visit['symptoms']) ?></td>
              <td><?= htmlspecialchars($visit['diagnosis']) ?></td>
              <td><?= htmlspecialchars($visit['medication']) ?></td>
              <td><?= htmlspecialchars($visit['treatment_plan']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif (!empty($patient_id)): ?>
    <div class="info">No visit records found for this patient.</div>
  <?php endif; ?>
</main>

</body>
</html>
