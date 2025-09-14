<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/utils.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

// Handle order placement
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (empty($cart)) {
        $message = "Your cart is empty.";
    } else {
        $user_id = $_SESSION['user_id'];
        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
            $stmt->execute([$user_id, $total_price]);
            $order_id = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, food_id, quantity, price_at_order) VALUES (?, ?, ?, ?)");
            foreach ($cart as $food_id => $item) {
                $stmt->execute([$order_id, $food_id, $item['quantity'], $item['price']]);
            }

            $conn->commit();
            unset($_SESSION['cart']);
            $message = "Order placed successfully! Your order number is: " . $order_id;
        } catch (PDOException $e) {
            $conn->rollBack();
            $message = "Failed to place order: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
            margin-bottom: 40px;
        }

        .container h2 {
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .container h3 {
            text-align: right;
            margin-top: 20px;
            color: #333;
            font-weight: 600;
        }

        .container p {
            color: #666;
            line-height: 1.6;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }
        
        thead tr {
            background-color: #f8f9fa;
        }
        
        th, td {
            padding: 12px;
            border: 1px solid #e9ecef;
            text-align: left;
        }
        
        th {
            font-weight: 600;
            color: #333;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Button Styles */
        form button {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Cart</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="container">
        <h2>Your Shopping Cart</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="menu.php">Go to menu</a></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    foreach ($cart as $id => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
            <form action="cart.php" method="post">
                <button type="submit" name="place_order">Place Order</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
