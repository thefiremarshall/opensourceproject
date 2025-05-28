<?php
session_start();
require_once 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query for user
    $stmt = $conn->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $username, $password_hash, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $password_hash)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect based on role
            switch ($role) {
                case 'admin':
                    header("Location: /endpoints/admin_dashboard.php");
                    break;
                case 'doctor':
                    header("Location: /endpoints/doctor_dashboard.php");
                    break;
                case 'patient':
                    header("Location: /endpoints/user_dashboard.php"); // insurance holder
                    break;
                default:
                    // fallback or unknown role
                    echo "Unknown role. Contact administrator.";
            }
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
}
?>
