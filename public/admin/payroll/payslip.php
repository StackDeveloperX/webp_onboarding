<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';
require_once '../../../vendor/fpdf/fpdf.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("
SELECT p.*, e.first_name, e.last_name, e.employee_code, e.department, e.designation
FROM payroll p
JOIN employees e ON p.employee_id = e.id
WHERE p.id = ?
");
$stmt->execute([$id]);
$pay = $stmt->fetch();

if (!$pay) die("Invalid payslip");

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Salary Slip - '.$pay['salary_month'],0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','',12);

// Employee details
$pdf->Cell(50,8,'Employee Code:',0); $pdf->Cell(50,8,$pay['employee_code'],0,1);
$pdf->Cell(50,8,'Employee Name:',0); $pdf->Cell(50,8,$pay['first_name'].' '.$pay['last_name'],0,1);
$pdf->Cell(50,8,'Department:',0); $pdf->Cell(50,8,$pay['department'],0,1);
$pdf->Cell(50,8,'Designation:',0); $pdf->Cell(50,8,$pay['designation'],0,1);

$pdf->Ln(10);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Salary Details',0,1);

$pdf->SetFont('Arial','',12);
$pdf->Cell(50,8,'Total Earnings:',0); $pdf->Cell(50,8,$pay['total_earnings'],0,1);
$pdf->Cell(50,8,'Total Deductions:',0); $pdf->Cell(50,8,$pay['total_deductions'],0,1);
$pdf->Cell(50,8,'Net Pay:',0); $pdf->Cell(50,8,$pay['net_pay'],0,1);

$pdf->Output();
?>