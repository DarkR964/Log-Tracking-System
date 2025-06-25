<?php
session_start();
require '../includes/dbconnection.php';

$tarih          = $_POST['tarih'] ?? '';
$kullanici_adi  = $_POST['kullanici_adi'] ?? '';
$bilgisayar_adi = $_POST['bilgisayar_adi'] ?? '';
$ip_adresi      = $_POST['ip_adresi'] ?? '';
$sistem         = $_POST['sistem'] ?? '';
$surum          = $_POST['surum'] ?? '';
$platform       = $_POST['platform'] ?? '';
$ulke           = $_POST['ulke'] ?? 'Bilinmiyor';
$sehir          = $_POST['sehir'] ?? 'Bilinmiyor';

// Veriyi veritabanına ekle
$stmt = $conn->prepare("INSERT INTO logs 
    (tarih, kullanici_adi, bilgisayar_adi, ip_adresi, sistem, surum, platform, ulke, sehir) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $tarih, $kullanici_adi, $bilgisayar_adi, $ip_adresi, $sistem, $surum, $platform, $ulke, $sehir);

if ($stmt->execute()) {
    echo "Log başarıyla kaydedildi.";
} else {
    echo "Veritabanına kaydedilemedi.";
}
?>
