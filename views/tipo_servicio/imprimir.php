<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('./fpdf/fpdf.php');
require_once("../../models/tipo_servicio.models.php");

$Tipo_Servicio = new Tipo_Servicio();
$datos = $Tipo_Servicio->todos();

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Lista de Servicios de Mecanica',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,10,'ID',1,0,'C');
$pdf->Cell(90,10,'Detalle',1,0,'C');
$pdf->Cell(30,10,'Valor',1,0,'C');
$pdf->Cell(30,10,'Estado',1,1,'C');

$pdf->SetFont('Arial','',12);

while ($row = mysqli_fetch_assoc($datos)) {

    $pdf->Cell(20,10,$row["id"],1,0,'C');
    $pdf->Cell(90,10,$row["detalle"],1,0,'L');
    $pdf->Cell(30,10,$row["valor"],1,0,'C');
    $pdf->Cell(30,10, ($row["estado"] ? 'Activo' : 'Inactivo'),1,1,'C');
}

$pdf->Output();