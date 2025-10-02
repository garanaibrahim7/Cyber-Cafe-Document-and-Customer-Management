<?php 
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: login.php");
        exit;
    }
?>

<style>

main {
    margin-top: 80px;
    padding: 20px;
    background: linear-gradient(90deg, rgba(49, 22, 157, 0.10), rgba(157, 22, 22, 0.10), rgb(0, 119, 255, 0.10));
    width: 90%;
    margin: 0 auto;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 100vw;
}

section {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.user-list h2, .filter-section h2 {
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 10px;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    max-width: 100vw;
}

table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
}


table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: center;
    font-size: 16px;
    color: black;
    white-space: nowrap;
}

th {
    background-color: rgba(6, 80, 255, 0.24);
}

.filter-section {
    background: rgba(255, 255, 255, 0.36);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.filter-section form {
    display: flex;
    justify-content: center; 
    gap: 20px;
    align-items: center; 
    flex-wrap: wrap;
}

.filter-section h2 {
    width: 100%;
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

.filter-field-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 180px;
    max-width: 300px;
}

.filter-section label {
    margin-bottom: 8px;
    font-size: 16px;
    color: #555;
    text-align: center;
}

.filter-section input[type="date"],
.filter-section select {
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ddd;
    width: 15%;
    min-width: 180px;
}

.filter-section button {
    background-color:rgb(0, 93, 193);
    color: white;
    padding: 12px 30px;
    height: 42px;
    font-size: 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    flex: 0 0 auto;
}
.button-container {
    display: flex;
    justify-content: center; /* Center the buttons */
    gap: 20px;
    margin-top: 20px; /* Add space from input fields */
    width: 100%;
}
button {
    margin: 10px;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
}

button[type="submit"] {
    background-color: #28a745;
    color: white;
}

button[type="button"] {
    background-color: #dc3545;
    color: white;
}

@media (min-width: 769px) and (max-width: 1024px) {
    .filter-section form {
        gap: 15px;
    }
    
    .filter-field-group {
        flex: 1 1 160px;
    }
}


@media (max-width: 1024px) {
    main {
        max-width: 95%;
        padding: 15px;
    }
    
    .filter-section {
        flex-direction: column;
        align-items: center;
    }
    
    .filter-section input[type="date"],
    .filter-section select,
    .filter-section button {
        width: 100%;
        max-width: 300px;
    }
    
    th, td {
        font-size: 15px;
        padding: 8px;
    }
}

@media (max-width: 768px) {
    main {
        max-width: 100%;
        padding: 10px;
    }
    .filter-section form {
        flex-direction: column;
        justify-content: center;
    }
    
    .filter-field-group {
        width: 100%;
    }
    
    .filter-section button {
        width: 100%;
        height: auto;
    }    
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    th, td {
        font-size: 15px;
        padding: 6px;
    }
    .button-container {
        flex-direction: column; /* Stack buttons vertically */
        gap: 10px;
        align-items: center;
    }

    .button-container button {
        width: 100%; /* Full width */
        max-width: 300px;
    }
}

@media (max-width: 480px) {
    main {
        margin-top: 60px;
        padding: 10px;
    }

    .filter-section h2 {
        font-size: 18px;
    }

    .filter-section label {
        font-size: 14px;
    }

    .filter-section button {
        font-size: 14px;
        padding: 12px 30px;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    th, td {
        font-size: 15px;
        padding: 5px;
    }

    .filter-section {
        flex-direction: column;
    }
}


</style>

<?php     

    include 'connection.php';
    include 'header.php';

    $workOptions = [];
    $sqlWorks = "SELECT work_name FROM works";
    $resultWorks = $conn->query($sqlWorks);

    if ($resultWorks->num_rows > 0) {
        while ($row = $resultWorks->fetch_assoc()) {
            $workOptions[] = $row['work_name'];
        }
    }

    $name = $_SESSION['name'];

    // Handle filter inputs
    $filterDate = $_POST['filter_date'] ?? '';
    $filterWork = $_POST['filter_work'] ?? '';
    $filterStatus = $_POST['filter_status'] ?? '';

    // Build the SQL query with filters
    $sql = "SELECT * FROM customer_records WHERE 1=1";
    if (!empty($filterDate)) {
        $sql .= " AND date = '$filterDate'";
    }
    if (!empty($filterWork)) {
        $sql .= " AND work = '$filterWork'";
    }
    if (!empty($filterStatus)) {
        $sql .= " AND complete = '$filterStatus'";
    }
    $sql .= " ORDER BY date DESC";

    $result = $conn->query($sql);

    // Group records by date
    $recordsByDate = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recordsByDate[$row['date']][] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Records</title>
    <style>
        /* Your styles from the previous code */
        /* Add your complete styles here */
    </style>
</head>
<body>

<main>
    <section class="filter-section">
        <h2>Filter Customer Records</h2>
        <form method="post">
            <label for="filter-date">Filter by Date:</label>
            <input type="date" id="filter-date" name="filter_date" value="<?php echo htmlspecialchars($filterDate); ?>">

            <label for="filter-work">Filter by Work:</label>
            <select id="filter-work" name="filter_work">
                <option value="">Select Work Type</option>
                <?php foreach ($workOptions as $work) { ?>
                    <option value="<?php echo htmlspecialchars($work); ?>" <?php echo $filterWork == $work ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($work); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="filter-status">Filter by Status:</label>
            <select id="filter-status" name="filter_status">
                <option value="">Select</option>
                <option value="Yes" <?php echo $filterStatus == "Complete" ? 'selected' : ''; ?>>Complete</option>
                <option value="No" <?php echo $filterStatus == "Incomplete" ? 'selected' : ''; ?>>Incomplete</option>
            </select>

            <div class="button-container">
                <button type="submit">Apply Filters</button>
                <button type="button" onclick="resetFilters()">Reset Filters</button>
            </div>
        </form>
    </section>

    <?php if (!empty($recordsByDate)) { ?>
        <?php foreach ($recordsByDate as $date => $records) { 
            $formattedDate = date('d-M-Y, l', strtotime($date));
            
            $sqltot = "SELECT SUM(charge) FROM customer_records WHERE date = '$date'";
            $tot = $conn->query($sqltot)->fetch_column();
        ?>
        <section class="user-list">
            <h2><?php echo $formattedDate; ?></h2>
                <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Work</th>
                            <th>Status</th>
                            <th>Charge</th>
                            <th>Attached File</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; ?>
                        <?php foreach ($records as $row) { ?>
                            <tr>
                                <td><?php echo ++$count; ?></td>
                                <td><?php echo htmlspecialchars($row["cust_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["contact"]); ?></td>
                                <td><?php echo htmlspecialchars($row["work"]); ?></td>
                                <td><?php echo htmlspecialchars($row["complete"]); ?></td>
                                <td><?php echo htmlspecialchars($row["charge"]); ?></td>
                                <td>
                                    <?php if (!empty($row["work_file_name"])) { 
                                        $filePath = "uploads/" . $row["work_file_name"];
                                        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                        if (in_array(strtolower($fileExt), $imageExtensions)) { ?>
                                            <a href="<?php echo $filePath; ?>" target="_blank">View Image</a>
                                        <?php } else { ?>
                                            <a href="<?php echo $filePath; ?>" target="_blank">View File</a>
                                        <?php } 
                                    } else { ?>
                                        <span style="color: gray;">No File</span>
                                    <?php } ?>
                                </td>
                                <td><a href="customer_delete.php?id=<?php echo $row["cust_id"]; ?>" onclick="return confirm_Delete()">Delete</a></td>
                            </tr>
                            <?php } ?>
                            <tr><td>Total Collection : </td> <td> <?php echo $tot; ?> </td> <tr>
                    </tbody>
                </table>
            </section>
        </div>
        <?php } ?>
    <?php } else { ?>
        <section class="user-list">
            <h2>No customer records found for the applied filters.</h2>
        </section>
    <?php } ?>
</main>

<script>
    function resetFilters() {
        window.location.href = window.location.pathname; // Reloads the page without filters
    }
    function confirm_Delete() {
        return confirm("Are you sure you want to delete this customer?");
    }
</script>

<?php include("footer.php"); ?>
</body>
</html>

<?php $conn->close(); ?>
