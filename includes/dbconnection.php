<?php
$host = "localhost";
$user = "root";        // XAMPP kullanıyorsan genelde root olur
$pass = "";            // Şifre yoksa boş bırak
$db   = "jcp";         // Veritabanı adın

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>
