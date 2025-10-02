<?php
include('connection.php');

if (isset($_GET['id'])) {
    $fileId = $_GET['id'];

    $stmt = $conn->prepare("SELECT file_title, file_path FROM uploads WHERE id = ?");
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($fileTitle, $filePath);

    if ($stmt->fetch()) {
        header("Content-Disposition: attachment; filename=" . basename($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File not found!";
    }
}
?>