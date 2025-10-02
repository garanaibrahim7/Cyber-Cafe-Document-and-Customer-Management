<?php
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: login.php");
        exit;
    } else {
    include 'connection.php';
    include 'header.php';

    $name = $_SESSION['name'];

    $query = "SELECT name, username, contact FROM admin WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $username = $row["username"];
            $contact = $row["contact"];            
        }        
    }
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - E-commerce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin-left: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- <header>
        <div class="header-container">
            <h1><?php echo "Welcome, " . $_SESSION['name'] . " To Admin Panel"; ?></h1>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </header> -->

    <main>
        <section class="profile-info">
            <h2>Profile Information</h2>
            <h5><ul>
                <li><strong>Name:</strong> <?php echo $name; ?></li>
                <li><strong>Username:</strong> <?php echo $username; ?></li>
                <li><strong>Contact:</strong> <?php echo $contact; ?></li>
            </ul></h5>
        </section>
    </main>
</body>
</html>

<?php
}
    include("footer.php");
    $conn->close();
?>