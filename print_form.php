<?php
    session_start();
    include('connection.php');
    include('header.php');
   

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Fetch work options from the database
$sql = "SELECT work_name, fees FROM works WHERE status = 'Active'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Entry</title>
    <style>
        #entry_form {
            display: flex;
            flex-direction: column;
            align-items: center; /* This will center content horizontally */
            justify-content: flex-start;
            min-height: 100vh;
        }

        form {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.15), rgb(7, 40, 255, 0.15),rgb(0, 119, 255, 0.15));
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }      

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;           
        }
        

        input[type="text"],
        input[type="number"],
        input[type="tel"] {
            width: 96%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        input[type="checkbox"] {
            margin-right: 8px;
        }

        #other-work-details {
            display: none;
            margin-top: 10px;
        }

        button {
            background: linear-gradient(90deg, rgb(49, 22, 157), rgb(7, 40, 255), #0078ff);
            color: white;       
            padding: 12px 40px; 
            font-size: 20px;    
            font-weight: bold;  
            border: none;       
            border-radius: 10px;
            cursor: pointer;    
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 300px;    
            text-align: center;
            display: block;
            margin: 20px auto; 
        }

        button:hover {
            background-color: rgb(15, 73, 134); /* Darker blue for hover */
            transform: translateY(-2px); /* Subtle lift effect */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
        }

        button:active {
            background-color: #004085; /* Even darker blue for active state */
            transform: translateY(0); /* Reset lift effect */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Reduced shadow for active state */
        }


        .header-label {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 12px;
            margin-top: 20px;
            display: block;
            color: #333;
        }

        .toggle-switch {
            position: relative;
            /* display: inline-block; */
            width: 80px;
            height: 47px;
            margin-left: 20px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-switch label {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgb(255, 0, 0);
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch label:before {
            position: absolute;
            content: "";
            height: 26px; /* Slightly smaller than the height of the switch */
            width: 26px;
            left: 2px; /* Center the circle */
            bottom: 2px; /* Center the circle */
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch input:checked + label {
            background-color:rgb(0, 218, 11);
        }

        .toggle-switch input:checked + label:before {
            transform: translateX(30px);
        }

        input[type="file"] {
            margin-bottom: 15px;
        }
        
        h2{
            margin-top: 50px;
        }
        table {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div id="error-popup" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, 0); background-color:rgb(236, 31, 31); color: white; padding: 15px 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); z-index: 1000; text-align: center;">
    Error in Printing, Please Contact Developer !
</div>
<div id="entry_form" class="entry_form">
<form action="printing.php" method="GET">

        <label class="header-label" for="customer-name">Customer Name</label>
        <input type="text" id="customer-name" name="customer_name" placeholder="Enter Customer Name" required>

        <label class="header-label" for="work">Select Work</label>
    <div class="checkbox-group" id="work-checkbox-group">
        <?php
        // Generate checkboxes from the database
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<label>';
                echo '<input type="checkbox" name="work[]" value="' . $row["work_name"] . '" data-fees="' . $row["fees"] . '"> ';
                echo $row["work_name"] . ' (₹' . $row["fees"] . ')';
                echo '</label>';
            }
        }
        ?>
        <!-- Other checkbox -->
        <label>
            <input type="checkbox" id="other-checkbox" name="work[]" value="Other"> Other
        </label>
    </div>
    <!-- Textbox for "Other" -->
    <input type="text" id="other-work-details" name="other_work_details" placeholder="Please specify..." style="display: none;">


        <label class="header-label" for="work-fees">Total Fees</label>
        <input type="number" id="work-fees" name="work_fees" placeholder="Total fees will be calculated here" required>

        
            <input type="checkbox" id="work-completed" name="work_completed" value="No" checked style="display:none;">
           



        <label class="header-label" for="contact-no">Contact No</label>
        <input type="tel" id="contact-no" name="contact_no" maxlength="10" pattern="\d+" placeholder="Enter Contact Number" oninput="validateContactNumber(event)" required>
        
        <button type="submit">Print Form</button>


    </form>

    <?php 
        $sql = "SELECT * FROM printed_forms ORDER BY date DESC";
        $result = $conn->query($sql);
    ?>
    <h2>Last Printed Forms</h2>
    <?php         
        if (!isset($_SESSION['name'])) {
            echo 'Login to View Last Printed Forms';
        }
        else {
    ?>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Work</th>
                <th>Charge</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['cust_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['work']) . "</td>";
                    echo "<td>₹" . htmlspecialchars($row['charge']) . "</td>";
                    echo "<td><a href=entry_of_printed.php?&id=" . urlencode($row['id']) . "&cust_name=" . urlencode($row['cust_name']) . "&contact=" . urlencode($row['contact']) . "&work=" . urlencode($row['work']) . "&charge=" . urlencode($row['charge']) . "'>Add</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No printed forms found.</td></tr>";
            }
            ?>
        </table>
        <?php } ?>
    </div>
    <script>      
           

            const checkboxes = document.querySelectorAll('#work-checkbox-group input[type="checkbox"]');
            const feesInput = document.getElementById('work-fees');
            const otherCheckbox = document.getElementById("other-checkbox");
            const otherWorkDetails = document.getElementById("other-work-details");

            otherCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    otherWorkDetails.style.display = "block";
                    otherWorkDetails.required = true; // Make the textbox required
                } else {
                    otherWorkDetails.style.display = "none";
                    otherWorkDetails.required = false;
                    otherWorkDetails.value = ""; // Clear the textbox when "Other" is unchecked
                }
            });

            let isEditingFees = false;

            function calculateFees() {
            if (isEditingFees) return;

            let totalFees = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked && checkbox !== otherCheckbox) {
                    const fee = parseInt(checkbox.getAttribute('data-fees'), 10) || 0;
                    totalFees += fee;
                }
            });

            feesInput.value = totalFees; // Update the fees field as an integer
        }

        // Add event listeners to checkboxes
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                if (checkbox === otherCheckbox && checkbox.checked) {
                    // Handle "Other" checkbox
                    checkboxes.forEach((cb) => {
                        if (cb !== otherCheckbox) cb.checked = false;
                    });
                    otherWorkDetails.style.display = 'block';
                    otherWorkDetails.required = true;
                    feesInput.value = ''; 
                } else if (checkbox.checked) {
                    otherCheckbox.checked = false;
                    otherWorkDetails.style.display = 'none';
                    otherWorkDetails.required = false;
                }
                calculateFees(); 
            });
        });

        feesInput.addEventListener('input', () => {
            isEditingFees = true; 
        });

        feesInput.addEventListener('blur', () => {
            isEditingFees = false;
        });

        calculateFees();
</script>




</body>
</html>
<?php

include('footer.php');
?>