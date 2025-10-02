
<?php
    include("connection.php");
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $id = $_GET['id'];

    $sql = "DELETE From customer_records WHERE cust_id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: analysis.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit;
    }
    $conn->close();



$excel_file_path = 'C:/wamp64/www/Saher Digital/Database File/customer_entry.xlsx';
$excel_file_path2 = 'C:/software/Saher Digital All Customer Entries/customer_entry.xlsx';

function deleteRowFromExcel($filePath, $id) {
    if (!file_exists($filePath)) return false;

    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    for ($row = 2; $row <= $highestRow; $row++) {
        $cid = $sheet->getCell("H$row")->getValue();

        if ($id == $cid) {
            $sheet->removeRow($row, 1);
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
            return true;
        }
    }
    return false;
}

// Delete from both files
$deleted1 = deleteRowFromExcel($excel_file_path, $id);
$deleted2 = deleteRowFromExcel($excel_file_path2, $id);

if ($deleted1 && $deleted2) {
    header("Location: customer_entry.php?delete_status=success");
} else {
    header("Location: customer_entry.php?delete_status=not_found");
}
exit;

?>