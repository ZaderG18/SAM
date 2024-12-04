<?php
require 'vendor/autoload.php';

$pdf = new Fpdf();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Teste de PDF', 0, 1, 'C');
$pdf->Output();
?>
