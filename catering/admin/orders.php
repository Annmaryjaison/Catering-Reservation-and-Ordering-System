<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/utils.php';

if (!is_admin()) {
    header("Location: ../login.php");
    exit();
}

$message = '';
// Handle order status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    $message = "Order #$order_id status updated to '$status'.";
}

// Fetch all orders with user information
$stmt = $conn->query("SELECT o.id, u.username, o.total_price, o.order_date, o.status FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
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
            max-width: 1100px;
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
        
        /* Action Column Styles */
        td.actions {
            white-space: nowrap; /* Prevent actions from wrapping */
        }
        
        td.actions select {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        td.actions button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        td.actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Manage Orders</h1>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="../logout.php">Logout</a>
        </nav>
    </div>

    <div class="container">
        <h2>All User Orders</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td class="actions">
                        <form action="orders.php" method="post" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                            <select name="status">
                                <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo ($order['status'] == 'processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
