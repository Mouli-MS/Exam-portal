<?php
// Include the necessary TCPDF files
require_once 'C:\xampp\htdocs\mini_project\tcpdf\tcpdf.php'; // Adjust the path to the TCPDF library
require_once 'C:\xampp\htdocs\mini_project\admin\config\apply.php'; // Include the configuration file
$obj = new Functions(); // Instantiate the Functions class
// Prepare the data for export
$tbl_name = "tbl_result_summary ORDER BY added_date DESC";
$query = $obj->select_data($tbl_name);
$res = $obj->execute_query($conn, $query);

// Create a new TCPDF instance
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set the document information
$pdf->SetCreator('PHPSpreadsheet');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('All Results Data');
$pdf->SetSubject('All Results Data');
$pdf->SetKeywords('Results, Data, Export');

// Set default font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Set the column headers
$pdf->Cell(20, 10, 'S.N.', 1, 0, 'C');
$pdf->Cell(40, 10, 'ID No', 1, 0, 'C');
$pdf->Cell(60, 10, 'Full Name', 1, 0, 'C');
$pdf->Cell(40, 10, 'Date', 1, 0, 'C');
$pdf->Cell(30, 10, 'Mark', 1, 0, 'C');
$pdf->Cell(40, 10, 'Faculty', 1, 1, 'C');

// Set the row index to start writing the data
$sn = 1;

// Iterate through the result data and populate the PDF
while ($row = $obj->fetch_data($res)) {
    $summary_id = $row['summary_id'];
    $student_id = $row['student_id'];
    $id_number = $row['id_number'];
    $marks = $row['marks'];
    $added_date = $row['added_date'];

    // Get the full name and faculty details from their respective tables
    $tbl_student = "tbl_student";
    $tbl_faculty = "tbl_faculty";
    $full_name = $obj->get_fullname($tbl_student, $student_id, $conn);
    $faculty_name = $obj->get_facultyname($tbl_faculty, $obj->get_faculty($tbl_student, $student_id, $conn), $conn);

    // Write the data to the PDF
    $pdf->Cell(20, 10, $sn++, 1, 0, 'C');
    $pdf->Cell(40, 10, $id_number, 1, 0, 'C');
    $pdf->Cell(60, 10, $full_name, 1, 0, 'C');
    $pdf->Cell(40, 10, $added_date, 1, 0, 'C');
    $pdf->Cell(30, 10, $marks, 1, 0, 'C');
    $pdf->Cell(40, 10, $faculty_name, 1, 1, 'C');
}

// Set the filename for the PDF file
$filename = 'all_results_data.pdf';

// Close and output the PDF
$pdf->Output($filename, 'D');

exit;
