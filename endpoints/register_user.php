<?php
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if username exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "❌ Username already exists.";
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $role);
    if ($stmt->execute()) {
        echo "✅ Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
