<?php
session_start();
require '../includes/dbconnection.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Kullanıcıyı çek
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Şifre doğru mu?
    if (password_verify($password, $user['password'])) {
        if (!$user['is_admin']) {
            header("Location: login.php?error=Sadece admin girişi yapılabilir");
            exit;
        }

        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];

        header("Location: ../logs/admin-panel.php");
        exit;
    }
}

header("Location: login.php?error=Kullanıcı adı veya şifre hatalı");
exit;
