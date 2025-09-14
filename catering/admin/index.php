<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/utils.php';

// Check if user is logged in and is an admin
if (!is_admin()) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Google Fonts import for Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        /* Universal Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Header Styles */
        .header {
            width: 100%;
            background-color: #ffffff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .header nav {
            margin-top: 15px;
        }

        .header nav a {
            color: #555;
            text-decoration: none;
            font-weight: 400;
            margin: 0 15px;
            padding: 8px 12px;
            transition: color 0.3s ease, background-color 0.3s ease, border-radius 0.3s ease;
        }

        .header nav a:hover {
            color: #007bff;
            background-color: #e9ecef;
            border-radius: 5px;
        }

        /* Container Styles */
        .container {
            width: 90%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
            text-align: center;
        }

        .container h2 {
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .container p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="../logout.php">Logout</a>
        </nav>
    </div>

    <div class="container">
        <h2>Welcome, Admin!</h2>
        <p>Use the navigation above to manage the website's content and orders.</p>
    </div>
</body>
</html>
