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
    width: 80%;
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
}

.table-container {
    width: 100%;
    overflow-x: auto;
    max-width: 100vw;
    -webkit-overflow-scrolling: touch;
}

table {
    width: 100%;
    min-width: 900px;
    max-width: 100%;
    border-collapse: collapse;
}


table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: center;
    font-size: 16px;
    color: #555;
    white-space: nowrap;
}

th {
    background-color: rgba(6, 80, 255, 0.24);
}

@media (max-width: 1024px) {
    main {
        max-width: 95%;
        padding: 15px;
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
    th, td {
        font-size: 15px;
        padding: 6px;
    }
}

@media (max-width: 480px) {
    main {
        margin-top: 60px;
        padding: 10px;
    }
    .table-container {
        width: 100%;
        overflow-x: auto;
    }
    th, td {
        font-size: 15px;
        padding: 5px;
    }
}

</style>
<?php 

    include 'connection.php';
    include 'header.php';
    $name = $_SESSION['name'];
    ?>

    <main>
        <?php
        // $sql = "SELECT * FROM customer_records";
        $sql = "SELECT * FROM customer_records WHERE date = CURDATE()";
        $result = $conn->query($sql);
        $count = 0;
        $sqltot = "SELECT SUM(charge) FROM customer_records WHERE date = CURDATE()";
        $tot = $conn->query($sqltot)->fetch_column();

        if ($result->num_rows > 0) { ?>
        <section class="user-list">
            <h2>Today's Customer Entries</h2>
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
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php $count++; echo $count; ?></td>
                                <td><?php echo $row["cust_name"]; ?></td>
                                <td><?php echo $row["contact"]; ?></td>
                                <td><?php echo $row["work"]; ?></td>
                                <td><?php echo $row["complete"]; ?></td>
                                <td><?php echo $row["charge"]; ?></td>
                                
                                <td>


                                <?php    if (!empty($row["work_file_name"])) { 
                            $filePath = "uploads/" . $row["work_file_name"];
                            $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);

                            
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                            if (in_array(strtolower($fileExt), $imageExtensions)) { ?>
                                
                                <a href="<?php echo $filePath; ?>" target="_blank" style="color: blue; text-decoration: underline;">
                                    View Image
                                </a>
                            <?php } else { ?>
                                
                                <a href="<?php echo $filePath; ?>" target="_blank" style="color: blue; text-decoration: underline;">
                                    View File
                                </a>
                            <?php } ?>
                        <?php } else { ?>
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
        <?php } else { ?>
            <style>
                footer{
                    margin-top: 370px;
                }
            </style>
            <section class="user-list" style="margin-top: 70px;">
                <h2>No customer entries found for today.</h2>
            </section>
        <?php }
        ?>
    </main>
    <script>
    function confirm_Delete() {
        return confirm("Are you sure you want to delete this customer?");
    }
</script>
<?php
    include("footer.php");
?>
