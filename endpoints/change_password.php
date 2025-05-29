<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$user_id = $_POST['user_id'] ?? null;
$new_password = $_POST['new_password'] ?? null;

if ($user_id && $new_password) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
    $stmt->bind_param("si", $password_hash, $user_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Password updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update password.";
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Missing information.";
}

header("Location: manage_users.php");
exit;
