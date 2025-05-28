<?php
include '../includes/header2.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit;
}
?>

<main>
<head>
<link rel="stylesheet" href="/style2.css">
</head>

  <h2>My Health Information</h2>

  <div class="card">
    <h3>Recent Medical Visits</h3>
    <table>
      <tr>
        <th>Date</th>
        <th>Provider</th>
        <th>Symptoms</th>
        <th>Prognosis</th>
        <th>Treatment</th>
      </tr>
      <!-- Sample Data -->
      <tr>
        <td>2025-04-15</td>
        <td>Dr. John Doe</td>
        <td>Headache</td>
        <td>Migraine</td>
        <td>Painkillers</td>
      </tr>
    </table>
  </div>

  <div class="card">
    <h3>Insurance Coverage</h3>
    <p><strong>Plan:</strong> Premium Plus</p>
    <p><strong>Claims Used:</strong> $1,200</p>
    <p><strong>Remaining Coverage:</strong> $3,800</p>
  </div>
</main>
