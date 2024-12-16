<?php
require('fpdf/fpdf.php');
include 'config.php';

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header PDF
$pdf->Cell(0, 10, 'Daftar Mahasiswa', 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Nama', 1);
$pdf->Cell(80, 10, 'Email', 1);
$pdf->Ln();

// Mengambil data mahasiswa dari database
$query = "SELECT * FROM students";
$students = $conn->query($query);

// Isi tabel
$pdf->SetFont('Arial', '', 12);
while ($row = $students->fetch_assoc()) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(60, 10, $row['name'], 1);
    $pdf->Cell(80, 10, $row['email'], 1);
    $pdf->Ln();
}

// Output PDF
$pdf->Output('D', 'Daftar_Mahasiswa.pdf');
?>
