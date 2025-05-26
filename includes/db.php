<?php
$host = "localhost";
$user = "thefiremarshall";
$pass = "open1234";
$db = "health_insurance";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
