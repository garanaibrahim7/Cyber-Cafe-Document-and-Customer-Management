<?php

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "Saher Digital";

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>