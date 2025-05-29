<?php
session_start();
include '../includes/header2.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';
$user_id = $_SESSION['user_id'];
$message = "";

// Handle claim submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['visit_id'])) {
    $visit_id = $_POST['visit_id'];

    // Get cost from visit
    $stmt = $conn->prepare("SELECT visit_cost FROM visits WHERE visit_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $visit_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($cost);
    $stmt->fetch();
    $stmt->close();

    if ($cost) {
        $stmt = $conn->prepare("INSERT INTO claims (user_id, amount, date_submitted, status) VALUES (?, ?, CURDATE(), 'Pending')");
        $stmt->bind_param("id", $user_id, $cost);

        if ($stmt->execute()) {
            $message = "✅ Claim submitted successfully.";
        } else {
            $message = "❌ Error submitting claim.";
        }
    } else {
        $message = "❌ Invalid visit.";
    }
}

// Fetch visits
$stmt = $conn->prepare("SELECT v.visit_id, v.visit_date, v.diagnosis, v.visit_cost, u.full_name FROM visits v JOIN users u ON v.doctor_id = u.user_id WHERE v.user_id = ? ORDER BY v.visit_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Claim</title>
    <link rel="stylesheet" href="/style2.css">
</head>
<body>
<main>
    <h2>Submit a Claim</h2>

    <div class="card">
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Date</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Cost</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['visit_date']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['diagnosis']) ?></td>
                    <td>$<?= number_format($row['visit_cost'],2) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="visit_id" value="<?= $row['visit_id'] ?>">
                            <button type="submit">Claim</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</main>
</body>
</html>

