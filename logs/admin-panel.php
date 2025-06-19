<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jcp";

$conn = new mysqli($host, $user, $pass, $db);
$result = $conn->query("SELECT * FROM logs ORDER BY tarih DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Loglar</title>
</head>
<body style="background:#111;color:white;font-family:sans-serif">
    <h2>Log Kayıtları</h2>
    <table border="1" cellpadding="5" cellspacing="0" style="width:100%;background:#222;color:white">
        <tr>
            <th>Kullanıcı</th>
            <th>Bilgisayar</th>
            <th>IP</th>
            <th>Sistem</th>
            <th>Giriş Sayısı</th>
            <th>Tarih</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['kullanici_adi'] ?></td>
            <td><?= $row['bilgisayar_adi'] ?></td>
            <td><?= $row['ip_adresi'] ?></td>
            <td><?= $row['sistem'] ?></td>
            <td><?= $row['giris_sayisi'] ?></td>
            <td><?= $row['tarih'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
