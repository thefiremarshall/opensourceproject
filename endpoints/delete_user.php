<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$user_id = $_POST['user_id'] ?? null;

if ($user_id) {
    $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();

    if ($role !== 'admin') {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Cannot delete admin users.";
    }
} else {
    $_SESSION['error'] = "Invalid user ID.";
}

header("Location: manage_users.php");
exit;
