<?php
$host = "localhost";
$user = "insurance_user";
$pass = "open1234";
$db = "insurance_manager";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
