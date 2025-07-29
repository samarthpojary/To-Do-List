<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include 'config/db.php';

$user_id = $_SESSION['user_id'];
$data = $conn->query("SELECT * FROM tasks WHERE user_id=$user_id");

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Task');
$sheet->setCellValue('B1', 'Due Date');
$sheet->setCellValue('C1', 'Status');
$sheet->setCellValue('D1', 'Created At');

$row = 2;
while ($task = $data->fetch_assoc()) {
  $sheet->setCellValue("A$row", $task['task']);
  $sheet->setCellValue("B$row", $task['due_date']);
  $sheet->setCellValue("C$row", $task['is_done'] ? 'Completed' : 'Pending');
  $sheet->setCellValue("D$row", $task['created_at']);
  $row++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="tasks.xlsx"');
$writer->save("php://output");
exit;
?>