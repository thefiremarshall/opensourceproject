<?php
require '../includes/db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$full_name =$_POST['full_name'];
$plan = $_POST['plan_id'];

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if username exists
$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "❌ Username already exists.";
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, full_name, role, plan_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password_hash, $full_name, $role, $plan);
    if ($stmt->execute()) {
        echo "✅ Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
