<?php
session_start();
require '../includes/db.php';

$username = trim($_POST['username']);
$password = $_POST['password'];
$role = $_POST['role'];
$full_name = trim($_POST['full_name']);
$plan = $_POST['plan_id'];

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if username exists
$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Username already exists.";
    header("Location: register.php");
    exit;
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, full_name, role, plan_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password_hash, $full_name, $role, $plan);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful. You can now log in.";
        if($_SESSION['role']=='admin'){
            header("Location: admin_dashboard.php");
            exit;
        }elseif($_SESSION['role']=='doctor'){
            header("Location: admin_dashboard.php");
            exit;
        }
        
    } else {
        $_SESSION['error'] = "Error creating user: " . $stmt->error;
        header("Location: register.php");
        exit;
    }
}
