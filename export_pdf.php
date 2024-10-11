<?php
require('fpdf186/fpdf.php'); // Pastikan jalur ini benar sesuai dengan lokasi folder FPDF Anda
include 'koneksi.php'; // Pastikan koneksi database sudah benar

// Ambil nama file dari parameter URL
$file_name = isset($_GET['file_name']) ? $_GET['file_name'] : 'data_pm';
$file_name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $file_name); // Sanitasi nama file

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Data Preventive Maintenance (PM)', 0, 1, 'C');
$pdf->Ln(10);

// Ambil data dari tabel
$sql = "SELECT pm.id, tel.nama_pc, pm.kondisi_setelah, pm.kondisi_sebelum, pm.tanggal_sebelum, pm.tanggal_setelah, tel.lokasi_pc, pm.jenis_pc 
        FROM pm_tel pm
        JOIN pc_tel tel ON pm.pc_id = tel.id";
$result = $conn->query($sql);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Nama PC', 1);
$pdf->Cell(40, 10, 'Kondisi Setelah', 1);
$pdf->Cell(40, 10, 'Kondisi Sebelum', 1);
$pdf->Cell(30, 10, 'Tanggal Sebelum', 1);
$pdf->Cell(30, 10, 'Tanggal Setelah', 1);
$pdf->Cell(30, 10, 'Lokasi PC', 1);
$pdf->Cell(30, 10, 'Jenis PC', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(40, 10, $row['nama_pc'], 1);
        $pdf->Cell(40, 10, $row['kondisi_setelah'], 1);
        $pdf->Cell(40, 10, $row['kondisi_sebelum'], 1);
        $pdf->Cell(30, 10, $row['tanggal_sebelum'], 1);
        $pdf->Cell(30, 10, $row['tanggal_setelah'], 1);
        $pdf->Cell(30, 10, $row['lokasi_pc'], 1);
        $pdf->Cell(30, 10, $row['jenis_pc'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'Tidak ada data ditemukan.', 1, 1, 'C');
}

// Output PDF
$pdf->Output('D', $file_name . '.pdf'); // Menyimpan file dengan nama yang ditentukan
?>
