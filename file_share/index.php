<?php
include 'connection.php';

function deleteOldFiles() {
    global $conn;
    
    $sql = "SELECT file_path FROM uploads WHERE uploaded_at <= DATE_SUB(CURDATE(), INTERVAL 15 DAY)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filePath = $row['file_path'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $deleteSql = "DELETE FROM uploads WHERE file_path = ?";
            $stmt = $conn->prepare($deleteSql);
            $stmt->bind_param("s", $filePath);
            $stmt->execute();
            $stmt->close();
        }
        //echo "Old files deleted successfully.";
    } else {
        //echo "No old files found.";
    }
}
 
deleteOldFiles();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload & Download</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.10), rgba(7, 40, 255, 0.10), rgba(0, 119, 255, 0.10));
        }
        .dropzone {
            width: 40%;
            margin: auto;
            padding: 20px;
            border: 2px dashed #ccc;
            background:rgba(255, 255, 255, 0.35);
            border-radius: 10px;
        }
        input, button {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
        }
        .uploaded-files {
            margin-top: 30px;
            width: 50%;
            margin: auto;
        }
        .uploaded-files a {
            display: block;
            padding: 8px;
            background: #007bff;
            color: white;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
        }
        .upload-button {
            display: inline-block;
            width: 20%;
            background-color:rgb(32, 50, 255);
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            font-family: 'Arial', sans-serif;
        }
        @media (max-width: 600px) {
            .dropzone {
                width: 90%;
                padding: 15px;
            }
            .upload-button{
                width: 60%;
            }
            .uploaded-files{
                width: 85%;
            }
        }
    </style>
</head>
<body>

<h2>Upload Files</h2>
<form id="uploadForm" class="dropzone">
    <input type="text" id="fileTitle" name="file_title" placeholder="Enter File Title" required>
    <input type="password" id="password" name="password" placeholder="Enter Password (Optional)">
</form>
<button class="upload-button" onclick="submitForm()">Upload File</button>

<div class="uploaded-files">
    <div id="fileList"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    var dropzone = new Dropzone("#uploadForm", {
        url: "upload.php", // Server-side upload script
        autoProcessQueue: false, // Disable auto-upload
        paramName: "file", // The name of the file input
        acceptedFiles: "image/*, .pdf, .docx, .zip", // Accepted file types
        init: function() {
            this.on("success", function(file, response) {
                alert("File uploaded successfully!");
                loadFiles();
                resetForm(); // Reset form fields and clear file preview after successful upload
            });

            this.on("error", function(file, response) {
                alert("Error uploading file: " + response);
            });
        }
    });

    function submitForm() {
        let title = document.getElementById("fileTitle").value;
        let password = document.getElementById("password").value;

        // Validate file title
        if (title.trim() === "") {
            alert("File title is required!");
            return;
        }

        // Set additional parameters for the file upload
        dropzone.options.params = {
            file_title: title,
            password: password
        };

        // Start the file upload
        dropzone.processQueue();
    }

    // Function to reset the form and clear the file preview
    function resetForm() {
        // Clear the file input and the form fields
        document.getElementById("uploadForm").reset();
        document.getElementById("fileTitle").value = ""; // Clear the title field
        document.getElementById("password").value = ""; // Clear the password field

        // Remove the file preview from Dropzone
        dropzone.removeAllFiles();
    }

    // Function to load the list of uploaded files
    function loadFiles() {
        fetch("list_files.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("fileList").innerHTML = data;
        });
    }

    // Load files initially
    loadFiles();
</script>

</body>
</html>