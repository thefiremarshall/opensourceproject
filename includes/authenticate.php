<?php
session_start();
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$stmt = $conn->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password_hash'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        header("Location: /endpoints/admin_dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid password.";
        header("Location: /endpoints/login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "User not found.";
    header("Location: /endpoints/login.php");
    exit;
}
