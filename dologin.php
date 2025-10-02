<?php
include('connection.php');

    // Retrieve user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT name FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        session_start();
        $_SESSION['name'] = $result->fetch_assoc()['name'];
        header("Location: analysis.php");
        exit();
    } else {
        ?>
            <script> alert("Invalid Username or Password, Try Again.");
                        window.location.href = "login.php";
        </script>
        <?php
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
?>