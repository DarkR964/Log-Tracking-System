<?php
session_start();
require '../includes/dbconnection.php'; 

// Admin kontrolü
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Bu sayfaya erişim yetkiniz yok.");
}

// Veritabanından logları çek
$query = "SELECT * FROM logs ORDER BY tarih DESC";
$result = $conn->query($query);

$logs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
    <div class="admin-container">
        <h2>Giriş Logları</h2>
        <div class="search-bar">
            <form method="get" action="">
                <input type="text" name="search" placeholder="Kullanıcı, IP veya cihaz ara...">
                <button type="submit">Ara</button>
            </form>
            <div class="actions">
    <a href="export-csv.php" class="export-button">CSV olarak indir</a>
    <a href="../includes/logout.php" class="logout-button">Çıkış Yap</a>
</div>
 

        </div>

        <table>
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Kullanıcı</th>
                    <th>IP</th>
                    <th>Bilgisayar</th>
                    <th>İşletim Sistemi</th>
                    <th>Konum</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['tarih']) ?></td>
                            <td><?= htmlspecialchars($log['kullanici_adi']) ?></td>
                            <td><?= htmlspecialchars($log['ip_adresi']) ?></td>
                            <td><?= htmlspecialchars($log['bilgisayar_adi']) ?></td>
                            <td><?= htmlspecialchars($log['sistem']) ?> <?= htmlspecialchars($log['surum']) ?></td>
                            <td><?= htmlspecialchars($log['ulke']) ?> / <?= htmlspecialchars($log['sehir']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Hiç log bulunamadı.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
