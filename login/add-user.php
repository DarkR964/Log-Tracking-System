<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jcp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("bağlantı hatası");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) exit("Eksik bilgi");

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);
$stmt->execute();
echo "OK";
?>