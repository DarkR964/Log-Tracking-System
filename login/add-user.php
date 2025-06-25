<?php
session_start();
require '../includes/dbconnection.php';

$username  = $_POST['username'] ?? '';
$password  = $_POST['password'] ?? '';
$is_admin  = isset($_POST['is_admin']) ? intval($_POST['is_admin']) : 0;

// Eksik veri kontrolü
if (empty($username) || empty($password)) {
    echo "Eksik veri";
    exit;
}

// Aynı kullanıcı adı var mı kontrolü
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo "Bu kullanıcı adı zaten var";
    exit;
}

// Şifreyi hashle ve kullanıcıyı ekle
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $username, $hashed, $is_admin);

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "Veritabanına eklenemedi.";
}
