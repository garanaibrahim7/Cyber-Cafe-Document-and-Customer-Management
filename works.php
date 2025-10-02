<?php
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: login.php");
        exit;
    }

    include 'connection.php';
    include 'header.php';

    // Handle form submission to add a new work type
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_work'])) {
        $work_name = $_POST['work_name'];
        $fees = $_POST['fees'];
        $status = 'Active'; // Default status
        $sql = "INSERT INTO works (work_name, fees, status) VALUES ('$work_name', '$fees', '$status')";
        $conn->query($sql);
    }

    // Handle delete request
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM works WHERE work_id = '$id'";
        $conn->query($sql);
    }

    // Handle status toggle (active/no-active)
    if (isset($_POST['toggle_status'])) {
        $id = $_POST['work_id'];
        $new_status = $_POST['new_status'];
        $sql = "UPDATE works SET status = '$new_status' WHERE work_id = '$id'";
        $conn->query($sql);
    }

    // Handle fees update
    if (isset($_POST['update_fees'])) {
        $id = $_POST['work_id'];
        $new_fees = $_POST['new_fees'];
        $sql = "UPDATE works SET fees = '$new_fees' WHERE work_id = '$id'";
        $conn->query($sql);
    }

    // Fetch all work types
    $sql = "SELECT * FROM works";
    $result = $conn->query($sql);
    $count = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Management</title>
    <style>
        
        .table-container {
            width: 100%;
            overflow-x: auto;
            max-wi  dth: 100vw;
            margin: 5px;
            margin-right: 5px;
            -webkit-overflow-scrolling: touch;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table th, table td {
            border: 2px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.75), rgb(7, 73, 255), rgba(49, 22, 157, 0.75));
            color: white;
        }
        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn.edit {
            background-color: #ffc107;
            color: black;
        }
        .btn.delete {
            background-color:#ff001a;
            color: white;
            text-decoration: none;
        }
        .btn.toggle {
            background-color:  #dc3545;
            color: white;
        }
        form {
            display: flex;
            justify-content: space-between;
            margin: 20px auto;
            max-width: 600px;
            margin-left: 5px;
            margin-right: 5px;
            gap: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #0078ff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1 style="text-align: center; margin-top:80px; font-size: 45px;">Work Management</h1>

<!-- Add Work Type Form -->
<form method="POST">
    <input type="text" name="work_name" placeholder="Enter work name" required>
    <input type="number" name="fees" placeholder="Enter fees" required>
    <button type="submit" name="add_work">Add Work</button>
</form>

<div class="table-container">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Work Name</th>
            <th>Fees</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { $count++;?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $row['work_name']; ?></td>
            <td>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="work_id" value="<?php echo $row['work_id']; ?>">
                    <input type="number" name="new_fees" value="<?php echo $row['fees']; ?>" style="width: 80px;">
                    <button type="submit" name="update_fees" class="btn edit" onclick="return confirm('Are You sure to Update the Price of Work ?')">Update</button>
                </form>
            </td>
            <td>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="work_id" value="<?php echo $row['work_id']; ?>">
                    <input type="hidden" name="new_status" value="<?php echo $row['status'] === 'Active' ? 'No-Active' : 'Active'; ?>">
                    <button type="submit" name="toggle_status" class="btn toggle" style="background-color: <?php echo $row['status'] === 'Active' ? '#f5051d' : '#28a745'; ?>;" onclick="return confirm('Are you sure to Change Status of the Work ?')">
                        <?php echo $row['status'] === 'Active' ? 'De-Activate' : 'Activate';                           
                        ?>
                    </button>
                </form>
            </td>
            <td>
                <a href="?delete=<?php echo $row['work_id']; ?>" class="btn delete" onclick="return confirm('Are you sure, you want to delete this work ?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>
<?php
    include('footer.php');
?>
