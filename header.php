<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saher Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.15), rgba(7, 40, 255, 0.15), rgba(0, 119, 255, 0.15));
        }

        header.hdr {
            display: flex;
            justify-content: space-between; /* Ensures space between logo/title and any other header items */
            background: linear-gradient(90deg, rgb(49, 22, 157), rgb(7, 40, 255), #0078ff);
            color: white;
            padding: 5px 30px;
            align-items: center;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.38);
            /* position: sticky; */
            top: 0;
            z-index: 1000;
            margin-bottom: 80px;
            position: relative;
        }

        .header-container h1 {
            font-size: 28px;
            text-align: center;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(255, 52, 52, 0.57);
            padding: 20px;
        }

        .sidebar {
            display: flex;
            align-items: center;
        }

        .sidebar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 18px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu-toggle {
            font-size: 24px;
            cursor: pointer;
            display: none;
        }

        /* Mobile Navigation */
        @media (max-width: 768px) {
            .sidebar ul {
                flex-direction: column;
                position: absolute;
                right: 0;
                top: 60px;
                background: linear-gradient(90deg, rgba(49, 22, 157, 0.75), rgba(7, 40, 255, 0.75), rgba(0, 119, 255, 0.75));
                padding: 10px;
                display: none;
                border-radius: 0 0 10px 10px;
                width: 50%;
                text-align: center;
                margin-top: 22px;
            }

            .sidebar ul.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }

            .header-container h1 {
                margin-left: -30px;
            }
        }

        .logout-button {
            color: white;               
            padding: 10px 20px;         
            text-decoration: none;      
            font-weight: bold;              
            transition: all 0.3s ease;  
            text-align: center;         
            font-size: 20px;
        }
        
        .logout-button:hover {            
            transform: translateY(-2px);
            color:rgb(255, 0, 0);
        }
        
        .logout-button:active {
            color: #cc0000;
            transform: translateY(0);
        }
        
        footer {
            text-align: center;
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.60), rgb(7, 40, 255),rgba(0, 119, 255, 0.60));
            color: white;
            padding: 80px 0;
            margin-top: 200px;
            border-top: 1px solid #555;
        }
    </style>
</head>
<body>

<header class="hdr">
    <div class="header-container">
        <a href="print_form.php" style="text-decoration: none; color: white;"><h1>Saher Digital</h1></a>
    </div>
    <div class="sidebar">
        <span class="menu-toggle">&#9776;</span>
        <ul>
            <li><a href="file_share">File Share</a></li>
            <li><a href="print_form.php">Print Form</a></li>
            <li><a href="customer_entry.php">Customer Entry</a></li>
            <li><a href="analysis.php">Today Analysis</a></li>
            <li><a href="whole_list.php">Whole List</a></li>
            <li><a href="works.php">Manage Works</a></li>
        </ul>
    </div>
</header>

<script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar ul').classList.toggle('active');
    });
</script>

