<?php

include('connection.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_name = $conn->real_escape_string($_POST['customer_name']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $work = isset($_POST['work']) ? $_POST['work'] : [];

    if(isset($_POST['print_id']) && !empty($_POST['print_id'])) {
        $print_id = $conn->real_escape_string($_POST['print_id']);
        $delete_sql = "DELETE FROM printed_forms WHERE id = $print_id";
        $conn->query($delete_sql);
    }

    if (in_array('Other', $work)) {
        $work = array_diff($work, ['Other']);
        if (!empty($_POST['other_work_details'])) {
            $other_work = $conn->real_escape_string($_POST['other_work_details']);
            $work[] = $other_work;
        }
    }

    $work_completed = isset($_POST['work_completed']) && $_POST['work_completed'] === "Yes" ? "Yes" : "No";
    $work_fees = intval($_POST['work_fees']);
    $file_name = '';

    if (isset($_FILES['work-file']) && $_FILES['work-file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "C:/wamp64/www/Saher Digital/uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['work-file']['name']);
        $target_file = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['work-file']['tmp_name'], $target_file)) {
            $file_name = ''; 
        }
    }

    $work_str = implode(", ", $work);
    $sql = "INSERT INTO customer_records (cust_name, contact, work, work_file_name, date, complete, charge)
            VALUES ('$cust_name', '$contact_no', '$work_str', '$file_name', NOW(), '$work_completed', '$work_fees')";

    $success = false;

    if ($conn->query($sql) === TRUE) {
        $success = true;
    }
    if ($success) {

        $sql_id = "SELECT cust_id FROM customer_records ORDER BY cust_id DESC LIMIT 1";
        $id = $conn->query($sql_id)->fetch_column();

        $excel_file_path = 'C:/wamp64/www/Saher Digital/Database File/customer_entry.xlsx';
        $excel_file_path2 = 'C:/software/Saher Digital All Customer Entries/customer_entry.xlsx';

        if (file_exists($excel_file_path) && file_exists($excel_file_path2)) {
            $spreadsheet = IOFactory::load($excel_file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet2 = IOFactory::load($excel_file_path2);
            $sheet2 = $spreadsheet2->getActiveSheet();
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet2 = new Spreadsheet();
            $sheet2 = $spreadsheet2->getActiveSheet();

            $sheet->setCellValue('A1', 'Customer Name')
                  ->setCellValue('B1', 'Contact No')
                  ->setCellValue('C1', 'Work')
                  ->setCellValue('D1', 'Work File Name')
                  ->setCellValue('E1', 'Date')
                  ->setCellValue('F1', 'Work Completed')
                  ->setCellValue('G1', 'Work Fees')
                  ->setCellValue('H1', 'id');

            $sheet2->setCellValue('A1', 'Customer Name')
                  ->setCellValue('B1', 'Contact No')
                  ->setCellValue('C1', 'Work')
                  ->setCellValue('D1', 'Work File Name')
                  ->setCellValue('E1', 'Date')
                  ->setCellValue('F1', 'Work Completed')
                  ->setCellValue('G1', 'Work Fees')
                  ->setCellValue('H1', 'id');
        }

        $nextRow = $sheet->getHighestRow() + 1;
        $nextRow2 = $sheet2->getHighestRow() + 1;

        $sheet->setCellValue("A$nextRow", $cust_name)
              ->setCellValue("B$nextRow", $contact_no)
              ->setCellValue("C$nextRow", $work_str)
              ->setCellValue("D$nextRow", $file_name)
              ->setCellValue("E$nextRow", date('Y-m-d H:i:s'))
              ->setCellValue("F$nextRow", $work_completed)
              ->setCellValue("G$nextRow", $work_fees)
              ->setCellValue("H$nextRow", $id);

        $sheet2->setCellValue("A$nextRow", $cust_name)
              ->setCellValue("B$nextRow", $contact_no)
              ->setCellValue("C$nextRow", $work_str)
              ->setCellValue("D$nextRow", $file_name)
              ->setCellValue("E$nextRow", date('Y-m-d H:i:s'))
              ->setCellValue("F$nextRow", $work_completed)
              ->setCellValue("G$nextRow", $work_fees)
              ->setCellValue("H$nextRow", $id);

        // Save the Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save($excel_file_path);
        $writer2 = new Xlsx($spreadsheet2);
        $writer2->save($excel_file_path2);

        header("Location: customer_entry.php?status=success");
        exit;
    } else {
        header("Location: customer_entry.php?status=error");
        exit;
    }
}

$conn->close();
?>