<?php
include('connection.php');

$sql = "SELECT id, file_title, file_path, password FROM uploads ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
        }

        .file-card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .file-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 30%;
            padding: 20px;
            transition: transform 0.3s ease-in-out;
            text-align: center;
        }

        .file-card:hover {
            transform: translateY(-10px);
        }

        .file-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .file-password {
            color: #555;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .download-btn:hover {
            background-color: #0056b3;
        }

        .no-files-message {
            text-align: center;
            font-size: 18px;
            color: #777;
        }

        @media (max-width: 768px) {
            .file-card {
                width: 45%;
            }
        }

        @media (max-width: 480px) {
            .file-card {
                width: 100%;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center;">Uploaded Files</h2>

    <div class="file-card-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="file-card">
                    <div class="file-title"><?php echo htmlspecialchars($row['file_title']); ?></div>
                    <div class="file-password">
                        <?php echo !empty($row['password']) ? 'Password: ' . htmlspecialchars($row['password']) : 'No password set'; ?>
                    </div>
                    <a href="download.php?id=<?php echo $row['id']; ?>" class="download-btn">Download</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-files-message">
                No files uploaded yet.
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
