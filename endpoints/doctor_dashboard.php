<?php
session_start();
include('../includes/header2.php');
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit;
}
?>
<head>
<link rel="stylesheet" href="/style2.css">

</head>
<main>
  <h2>Doctor Dashboard</h2>

  <div class="card">
    <h3>Search or Add Patient Records</h3>
    <form action="view_patient.php" method="get">
      <label for="patient_id">Enter Patient ID:</label>
      <input type="text" id="patient_id" name="patient_id" required>
      <button type="submit">View</button>
    </form>

    <a href="add_medical_record.php" class="button">Add New Visit</a>
  </div>
</main>
