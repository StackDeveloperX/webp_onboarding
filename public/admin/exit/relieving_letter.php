<?php
require_once '../../../app/helpers/auth_helper.php';
requireAdmin();
require_once '../../../app/config/database.php';
require_once '../../../vendor/fpdf/fpdf.php';

$exit_id = $_GET['id'] ?? null;
if (!$exit_id) { die("Invalid request"); }

// Fetch exit + employee details
$stmt = $pdo->prepare("
    SELECT ex.*, e.first_name, e.last_name, e.employee_code, e.department, e.designation, e.joining_date
    FROM employee_exit ex
    JOIN employees e ON ex.employee_id = e.id
    WHERE ex.id = ?
");
$stmt->execute([$exit_id]);
$data = $stmt->fetch();

if (!$data) { die("Exit record not found"); }

$empName  = $data['first_name']." ".$data['last_name'];
$empCode  = $data['employee_code'];
$dept     = $data['department'];
$desg     = $data['designation'];
$joinDate = $data['joining_date'];
$lwd      = $data['last_working_day'];

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relieving Letter',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Date: '.date('Y-m-d'),0,1);

$pdf->Ln(5);
$pdf->Cell(0,8,"To,",0,1);
$pdf->Cell(0,8,$empName.",",0,1);
$pdf->Cell(0,8,"Employee Code: ".$empCode,0,1);
$pdf->Ln(5);

$body = "
This is to confirm that Mr/Ms. $empName, who was employed with us as $desg in the $dept department, 
from $joinDate to $lwd, has been relieved from his/her duties.

During the tenure with us, Mr/Ms. $empName has discharged the responsibilities assigned 
to him/her to our satisfaction.

We wish him/her all the best in future endeavours.
";

$pdf->MultiCell(0,7,utf8_decode($body));

$pdf->Ln(15);
$pdf->Cell(0,8,"For, [Your Company Name]",0,1);
$pdf->Ln(15);
$pdf->Cell(0,8,"Authorized Signatory",0,1);

$pdf->Output("I","Relieving_Letter_".$empCode.".pdf");
exit;
?>