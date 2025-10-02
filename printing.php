<?php

include('connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $cust_name = $conn->real_escape_string($_GET['customer_name']);
    $contact_no = $conn->real_escape_string($_GET['contact_no']);
    $work = isset($_GET['work']) ? $_GET['work'] : [];

    if (in_array('Other', $work)) {
        $work = array_diff($work, ['Other']);
        if (!empty($_GET['other_work_details'])) {
            $other_work = $conn->real_escape_string($_GET['other_work_details']);
            $work[] = $other_work;
        }
    }

    $work_fees = intval($_GET['work_fees']);

    $work_str = implode(", ", $work);
    $sql = "INSERT INTO printed_forms (cust_name, contact, work, date, charge)
            VALUES ('$cust_name', '$contact_no', '$work_str', NOW(), '$work_fees')";

    if ($conn->query($sql) === TRUE) {       

        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Saher Digital - Customer Entry Form</title>
            <style>
                @media print {
                    body {
                        font-family: 'Arial', sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #ffffff;
                    }

                    .print-container {
                        width: 21cm;
                        height: 29.7cm;
                        margin: 1cm;
                        padding: 30px;
                        background-color: #ffffff;
                        border: none;
                        page-break-before: always;
                        box-sizing: border-box;
                        border-radius: 12px;
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                        overflow: hidden;
                    }

                    h1 {
                        font-size: 30px;
                        color: #000;
                        text-align: center;
                        margin-bottom: 20px;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        padding-bottom: 10px;
                        border-bottom: 2px solid #000;
                    }

                    .form-details {
                        margin-bottom: 30px;
                        padding: 15px;
                        border: 1px solid #000;
                        border-radius: 8px;
                        background-color: #f9f9f9;
                        text-align: left;  /* Align content to the left */
                    }

                    .form-details label {
                        font-weight: bold;
                        display: inline-block;
                        width: 200px;
                        font-size: 18px;
                    }

                    .form-details .data {
                        font-size: 18px;
                        display: inline-block;
                        font-style: italic;
                        padding: 5px;
                        background-color: #e0e0e0;
                        border-radius: 4px;
                        max-width: 75%;
                    }

                    .form-details p {
                        margin: 10px 0;
                        padding: 8px 0;
                        border-bottom: 2px solid #ddd;
                    }

                    .signature-section {
                        margin-top: 100px;
                        display: flex;
                        justify-content: space-between;
                    }

                    .signature-box {
                        color:rgba(0, 0, 0, 0.34);
                        width: 45%;
                        height: 100px;
                        border: 1px solid #000;
                        border-radius: 6px;
                        padding: 10px;
                        text-align: center;
                        font-style: italic;
                    }
                    

                    .footer {
                        text-align: center;
                        margin-top: 160px;
                        font-size: 16px;
                        color: #777;
                        font-style: italic;
                    }

                    .footer p {
                        margin: 5px 0;
                    }

                    /* Hide the print button when printing */
                    .print-btn {
                        display: none;
                    }
                }

                /* On Screen Styling */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    padding: 30px;
                    text-align: center;
                }

                .screen-container {
                    width: 90%;
                    max-width: 900px;
                    background-color: #fff;
                    padding: 30px;
                    border-radius: 10px;
                    margin: 0 auto;
                }

                .screen-container h1 {
                    font-size: 32px;
                    font-weight: 700;
                    text-transform: uppercase;
                }

                .screen-container p {
                    font-size: 18px;
                    margin-bottom: 15px;
                    text-align: left;  /* Align content to the left */
                }

                .print-btn {
                    margin-top: 30px;
                    padding: 12px 20px;
                    background-color: #4CAF50;
                    color: #fff;
                    border: none;
                    font-size: 18px;
                    cursor: pointer;
                    border-radius: 6px;
                }

                .print-btn:hover {
                    background-color: #45a049;
                }

            </style>
        </head>
        <body>
            <div class="screen-container">
                <h1><div style="font-size:50px;">Saher Digital</div><br>Customer Details Form</h1>
                <p><strong>Customer Name:</strong> <span style="margin-left: 100px; text-align: left;"><?php echo htmlspecialchars($cust_name); ?></span></p>
                <p><strong>Work Types:</strong> <span style="margin-left: 137px; text-align: left;"><?php echo htmlspecialchars($work_str); ?><span></p>
            <?php if (!empty($otherWorkDetails)) { ?>
                <p><strong>Other Work Details:</strong> <?php echo htmlspecialchars($otherWorkDetails); ?></p>
            <?php } ?>
                <p><strong>Work Fees:</strong> <span style="margin-left: 150px; text-align: left;"><?php echo htmlspecialchars($work_fees); ?></span></p>
                <p><strong>Contact Number:</strong> <span style="margin-left: 102px; text-align: left;"><?php echo htmlspecialchars($contact_no); ?></span></p>
                <p><strong>Complete[    ] | Incomplete[    ]</strong></p>        
                
                <!-- Line after Other Details -->
                <hr>
                
                <div><strong style="font-size:20px;"> <?php echo date("d/m/Y"); ?> </strong></div>
                <div><strong style="font-size:16px;"> <?php echo date("l"); ?> </strong></div>
                <!-- Signature and Note moved to the end -->
                <div class="footer">
                    <p><strong>Note :</strong><p>I am Allowing Saher Digital for Use My Information About My Background For Goverment or Non-Goverment Work.</p>
                    <p>And Please Verify Above Information before Signature</p>
            </p>
                </div>
                
                <div class="signature-section">
                    <div class="signature-box">
                        <p style="margin-top: -5px;"><strong>Customer Signature</strong></p>
                        <p></p>
                    </div>
                    <div class="signature-box">
                        <p style="margin-top: -5px;"><strong>Employee Signature</strong></p>
                        <p></p>
                    </div>
                </div>

                <!-- Print Button -->
                <button class="print-btn" onclick="window.print();">Print Form</button>
            </div>
        </body>
        </html>
    <?php
    } else {
        header("Location: print_form.php?status=error");
        exit;
    }
}

$conn->close();
?>