<?php
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: login.php");
        exit;
    }
    include 'connection.php';
    include 'header.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $customer_name = isset($_GET['cust_name']) ? htmlspecialchars($_GET['cust_name']) : '';
        $contact_no = isset($_GET['contact']) ? htmlspecialchars($_GET['contact']) : '';
        $work = isset($_GET['work']) ? htmlspecialchars($_GET['work']) : '';
        $charge = isset($_GET['charge']) ? htmlspecialchars($_GET['charge']) : '';
        $print_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';        

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
            align-items: center;
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
            background-color: rgb(15, 73, 134);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        button:active {
            background-color: #004085;
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            width: 60px;
            height: 38px;
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
            height: 26px;
            width: 26px;
            left: 2px;
            bottom: 2px;
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
        
        

    </style>
</head>
<body>

<div id="success-popup" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, 0); background-color: #4caf50; color: white; padding: 15px 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); z-index: 1000; text-align: center;">
    Record added successfully !
</div>
<div id="error-popup" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, 0); background-color:rgb(236, 31, 31); color: white; padding: 15px 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); z-index: 1000; text-align: center;">
    Error in Data Entry, Please Contact Developer !
</div>
<div id="entry_form" class="entry_form">

<form action="add_cust.php" method="post" enctype="multipart/form-data">

<input type="hidden" id="print_id" name="print_id" value="<?= $print_id ?>">

    <label for="customer-name">Customer Name</label>
    <input type="text" id="customer-name" name="customer_name" value="<?php echo $customer_name; ?>" required>

    <label for="work">Select Work</label>
    <div class="checkbox-group" id="work-checkbox-group">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $checked = (strpos($work, $row["work_name"]) !== false) ? 'checked' : ''; // Check if work matches
                echo '<label>';
                echo '<input type="checkbox" name="work[]" value="' . $row["work_name"] . '" data-fees="' . $row["fees"] . '" ' . $checked . '> ';
                echo $row["work_name"] . ' (₹' . $row["fees"] . ')';
                echo '</label>';
            }
        }
        ?>
        <label>
            <input type="checkbox" id="other-checkbox" name="work[]" value="Other"> Other
        </label>
    </div>
    <input type="text" id="other-work-details" name="other_work_details" placeholder="Please specify..." style="display: none;">

    <label for="work-fees">Total Fees</label>
    <input type="number" id="work-fees" name="work_fees" value="<?php echo $charge; ?>" required>

    <label for="work-completed">Work Completed Status</label>
    <div class="toggle-switch">
        <input type="checkbox" id="work-completed" name="work_completed" value="Yes" checked>
        <label for="work-completed"></label>
    </div>

    <label for="contact-no">Contact No</label>
    <input type="tel" id="contact-no" name="contact_no" maxlength="10" pattern="\d+" value="<?php echo $contact_no; ?>" required>

    <label for="file-upload">Choose File</label>
    <input type="file" id="work-file" name="work-file" accept="/*" multiple>

    <button type="submit">Add Entry</button>
</form>

    </div>
    <script>

        function validateContactNumber(event) {
            event.target.value = event.target.value.replace(/\D/g, '');
        }


         <?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
                const successPopup = document.getElementById('success-popup');
                successPopup.style.display = 'block';
                setTimeout(() => {
                    successPopup.style.display = 'none';
                }, 3000);
            <?php } elseif(isset($_GET['status']) && $_GET['status'] == 'error') { ?>                
                const successPopup = document.getElementById('error-popup');
                successPopup.style.display = 'block';
                setTimeout(() => {
                    successPopup.style.display = 'none';
                }, 3000);
           <?php } ?>
           

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