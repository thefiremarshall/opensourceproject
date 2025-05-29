<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header2.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patient_id = $_POST['patient_id'];
    $date = $_POST['date'];
    $symptoms = $_POST['symptoms'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];
    $cost = $_POST['cost'];

    $stmt = $conn->prepare("INSERT INTO visits (user_id, doctor_id, visit_date, symptoms, diagnosis, treatment_plan, vistit_cost) VALUES (?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("issssss", $patient_id, $_SESSION['user_id'], $date, $symptoms, $diagnosis, $treatment);
    $stmt->execute();

    echo "<p style='color: green;'>Visit added successfully!</p>";
}
?>
<head>
<link rel="stylesheet" href="/style2.css">

</head>

<h2>Add Patient Visit</h2>
<form method="post">
    <label>Patient ID:</label>
    <input type="number" name="patient_id" required><br>

    <label>Date of Visit:</label>
    <input type="date" name="date" required><br>

    <label>Symptoms:</label>
    <textarea name="symptoms" required></textarea><br>

    <label>Diagnosis:</label>
    <textarea name="diagnosis"></textarea><br>

    <label>Treatment:</label>
    <textarea name="treatment"></textarea><br>

    <label>Cost$:</label>
    <input type="number" name="cost" required><br>

    <button type="submit">Submit</button>
</form>
