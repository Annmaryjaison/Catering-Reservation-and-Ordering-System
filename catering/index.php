<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Catering Service</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500&display=swap');

        :root {
            --primary-color: #A52A2A; /* A warm brown or burgundy */
            --secondary-color: #F5F5DC; /* Off-white or beige */
            --accent-color: #FFD700; /* A golden color for highlights */
            --text-dark: #333;
            --text-light: #fff;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: var(--secondary-color);
            color: var(--text-dark);
        }

        .header {
            background-color: var(--primary-color);
            color: var(--text-light);
            text-align: center;
            padding: 20px 0;
            position: relative;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            margin: 0;
            letter-spacing: 2px;
        }

        .header p {
            font-style: italic;
            margin: 5px 0 20px;
            font-size: 1em;
        }

        nav {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 10px 0;
        }

        nav a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            padding: 0 15px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--accent-color);
        }

        .logo {
            text-align: center;
            margin: 20px 0;
        }

        .logo img {
            width: 100%;
            max-width: 1080px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .image-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .image-container img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.05);
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
            background-color: var(--text-light);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .container p {
            line-height: 1.6;
            font-size: 1.1em;
        }

        .footer {
            background-color: var(--primary-color);
            color: var(--text-light);
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Ann's Catering Service</h1>
        <p>Delicious food for every occasion.</p>
        <nav>
            <a href="index.php">Home</a> |
            <a href="menu.php">Menu</a> |
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="cart.php">Cart</a> |
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a> |
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="logo">
        <img src="logo.png" alt="Ann's Catering Logo"> 
    </div>

    <div class="image-container">
        <img src="home1.jpg" alt="A variety of delicious foods">
        <img src="biriyani.png" alt="A delicious plate of biriyani">
        <img src="porotta.png" alt="A stack of porotta">
        <img src="noodles.png" alt="A plate of noodles">
        <img src="chapati.png" alt="A pile of chapati">
    </div>

    <div class="container">
        <h2>About Us</h2>
        <p>
            Welcome to Ann's Catering System, where every meal is a celebration. We are a premier catering company dedicated to providing exceptional culinary experiences for all of life's special moments. From intimate family gatherings to grand corporate events, we believe that food is the heart of every occasion.
        </p>
    </div>

    <div class="footer">
        <p>&copy; 2025 Catering Service. All rights reserved.</p>
    </div>
</body>
</html>