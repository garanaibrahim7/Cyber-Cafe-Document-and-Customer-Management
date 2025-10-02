<?php
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .login-body {
        font-family: Arial, sans-serif;
        background: linear-gradient(90deg, rgba(49, 22, 157, 0.00), rgba(7, 40, 255, 0.00),rgba(0, 119, 255, 0.00));
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        }

        .login-container {
            background: linear-gradient(90deg, rgba(49, 22, 157, 0.15), rgb(7, 40, 255, 0.15),rgb(0, 119, 255, 0.15));
            padding: 20px;
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .login-form {
            max-width: 100%;
            margin: 0 auto;
            margin-right: 25px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="username"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background: linear-gradient(90deg, rgb(49, 22, 157), rgb(7, 40, 255), #0078ff);
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            width: 50%;
            font-size: 16px;
            border-radius: 4px;
        }

        button:hover {
            background-color: #444;
        }

        .register-link {
            color: rgb(125, 125, 255);
            text-decoration: none;
            font-weight: bold;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
    
    <div  class="login-body">
    <div class="login-container">
        <form class="login-form" action="dologin.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username :</label>
                <input type="username" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div align="center">
                <button type="submit">Login</button><br><br>
                <!-- Not Have an Account ? <a href="register.php" class="register-link">Create an Account</a> -->
            </div>
        </form>
    </div>
    </div>

<?php
    include("footer.php");
?>