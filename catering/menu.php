<?php
session_start();
require_once 'includes/db.php';

// Fetch all food items from the database
$stmt = $conn->query("SELECT * FROM food_items");
$food_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $food_id = $_POST['food_id'];
    $quantity = 1;

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to cart or update quantity if it exists
    if (isset($_SESSION['cart'][$food_id])) {
        $_SESSION['cart'][$food_id]['quantity'] += $quantity;
    } else {
        // Fetch item details to store in the session
        $stmt = $conn->prepare("SELECT * FROM food_items WHERE id = ?");
        $stmt->execute([$food_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($item) {
            $_SESSION['cart'][$food_id] = [
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $quantity
            ];
        }
    }
    header("Location: menu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="header">
        <h1>Our Menu</h1>
        <nav>
            <a href="index.php">Home</a> |
            <a href="menu.php">Menu</a> |
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a> |
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a> |
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="container">
        <h2>Food Items</h2>
        <div style="display: flex; flex-wrap: wrap;">
            <?php foreach ($food_items as $item): ?>
            <div class="food-item" style="width: 300px;">
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <p><strong>$<?php echo htmlspecialchars($item['price']); ?></strong></p>
                <form action="menu.php" method="post">
                    <input type="hidden" name="food_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>