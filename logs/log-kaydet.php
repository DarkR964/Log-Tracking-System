<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jcp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Bağlantı hatası");

$tarih       = $_POST['tarih'] ?? '';
$kullanici   = $_POST['kullanici_adi'] ?? '';
$bilgisayar  = $_POST['bilgisayar_adi'] ?? '';
$ip          = $_POST['ip_adresi'] ?? '';
$sistem      = $_POST['sistem'] ?? '';
$surum       = $_POST['surum'] ?? '';
$platform    = $_POST['platform'] ?? '';

// Kullanıcı daha önce kayıtlı mı kontrol et
$stmt = $conn->prepare("SELECT id, giris_sayisi FROM logs WHERE kullanici_adi = ? AND bilgisayar_adi = ?");
$stmt->bind_param("ss", $kullanici, $bilgisayar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Kayıt varsa: giriş sayısını arttır ve tarihi güncelle
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $giris_sayisi = $row['giris_sayisi'] + 1;

    $stmt = $conn->prepare("UPDATE logs SET tarih = ?, ip_adresi = ?, sistem = ?, surum = ?, platform = ?, giris_sayisi = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $tarih, $ip, $sistem, $surum, $platform, $giris_sayisi, $id);
    $stmt->execute();
    echo "Güncellendi";
} else {
    // Kayıt yoksa: yeni kayıt oluştur
    $stmt = $conn->prepare("INSERT INTO logs (tarih, kullanici_adi, bilgisayar_adi, ip_adresi, sistem, surum, platform, giris_sayisi)
                            VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssssss", $tarih, $kullanici, $bilgisayar, $ip, $sistem, $surum, $platform);
    $stmt->execute();
    echo "Yeni kayıt eklendi";
}
?>
