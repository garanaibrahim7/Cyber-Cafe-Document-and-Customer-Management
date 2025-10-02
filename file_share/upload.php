<?php
include('connection.php');

$fileTitle = $_POST['file_title'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($_FILES['file']['name']) && !empty($fileTitle)) {
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        // Save password directly, no hashing
        $stmt = $conn->prepare("INSERT INTO uploads (file_title, file_path, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fileTitle, $filePath, $password);
        $stmt->execute();
        echo "File uploaded successfully!";
    } else {
        echo "File upload failed!";
    }
}
?>