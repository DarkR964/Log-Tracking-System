<?php
session_start();
require '../logs/fpdf.php'; 
require '../includes/dbconnection.php';

// FPDF ayarları
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Log Kayitlari', 0, 1, 'C');
$pdf->Ln(5);

// Tablo başlıkları
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(50, 50, 50);
$pdf->SetTextColor(255);
$header = ['Tarih', 'Kullanıcı', 'IP', 'Bilgisayar', 'İşletim Sistemi', 'Konum'];
$widths = [35, 25, 25, 30, 45, 30];

foreach ($header as $i => $col) {
    $pdf->Cell($widths[$i], 8, $col, 1, 0, 'C', true);
}
$pdf->Ln();

// Verileri çek
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);

$result = $conn->query("SELECT * FROM logs ORDER BY tarih DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $isletim = $row['sistem'] . ' ' . $row['surum'];
        $konum = $row['ulke'] . ' / ' . $row['sehir'];

        $data = [
            $row['tarih'],
            $row['kullanici_adi'],
            $row['ip_adresi'],
            $row['bilgisayar_adi'],
            $isletim,
            $konum
        ];

        foreach ($data as $i => $value) {
            $pdf->Cell($widths[$i], 8, $value, 1);
        }
        $pdf->Ln();
    }
}

$pdf->Output('D', 'loglar.pdf'); // D: İndirme için
exit;
