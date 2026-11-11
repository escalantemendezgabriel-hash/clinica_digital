<?php
require 'config.php';
auth();
require 'lib/fpdf.php';   // descarga fpdf.php desde fpdf.org y colócalo en la carpeta lib/

$id = (int)($_GET['id'] ?? 0);
$s  = $db->prepare("SELECT * FROM pacientes WHERE id=?");
$s->bind_param('i', $id);
$s->execute();
$p = $s->get_result()->fetch_assoc();
if (!$p) die('Paciente no encontrado');

$s = $db->prepare(
    "SELECT h.*,pr.nombre proc FROM historia h JOIN procedimientos pr ON pr.id=h.procedimiento_id WHERE paciente_id=? ORDER BY fecha"
);
$s->bind_param('i', $id);
$s->execute();
$hist = $s->get_result()->fetch_all(MYSQLI_ASSOC);

function t($x) {
    return mb_convert_encoding((string)$x, 'ISO-8859-1', 'UTF-8');
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, t('Historia Clínica Odontológica'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Ln(4);

$pdf->Cell(0, 7, t('Paciente: ' . $p['nombre'] . ' ' . $p['apellido']), 0, 1);
$pdf->Cell(0, 7, t('Cédula: ' . $p['cedula'] . '   Nacimiento: ' . $p['fecha_nacimiento'] . '   Tel: ' . $p['telefono']), 0, 1);
$pdf->Cell(0, 7, t('Alergias/antecedentes: ' . ($p['alergias'] ?: 'Ninguno')), 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 230, 250);
foreach ([['Fecha', 25], ['Procedimiento', 55], ['Diente', 25], ['Observaciones', 85]] as $c) {
    $pdf->Cell($c[1], 8, t($c[0]), 1, 0, 'C', true);
}
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);

foreach ($hist as $h) {
    $pdf->Cell(25, 8, $h['fecha'], 1);
    $pdf->Cell(55, 8, t($h['proc']), 1);
    $pdf->Cell(25, 8, t($h['diente']), 1);
    $pdf->Cell(85, 8, t(substr($h['observaciones'], 0, 45)), 1);
    $pdf->Ln();
}

$pdf->Output('I', 'historia_' . $p['cedula'] . '.pdf');
