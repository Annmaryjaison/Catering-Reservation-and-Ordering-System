<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/utils.php';

if (!is_admin()) {
    header("Location: ../login.php");
    exit();
}

$message = '';
$food_item = null;

// Handle form submissions (Add/Edit/Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        
        // Check if file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_path = 'assets/images/' . basename($_FILES['image']['name']);
            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_path)) {
                $stmt = $conn->prepare("INSERT INTO food_items (name, description, price, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $image_path]);
                $message = "Product added successfully!";
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "No image uploaded or an error occurred.";
        }
    } elseif (isset($_POST['edit_product'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("UPDATE food_items SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $id]);
        $message = "Product updated successfully!";
    } elseif (isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM food_items WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Product deleted successfully!";
    }
}

// Fetch all food items
$stmt = $conn->query("SELECT * FROM food_items");
$food_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
            max-width: 1000px;
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

        /* Form Styles */
        form {
            display: grid;
            gap: 15px;
            margin-bottom: 40px;
            text-align: left;
        }

        form label {
            font-weight: 600;
            color: #555;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box; /* Ensures padding doesn't affect the width */
        }

        form button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
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
        
        img {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            object-fit: cover;
        }

        table button {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        table button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Manage Products</h1>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="../logout.php">Logout</a>
        </nav>
    </div>

    <div class="container">
        <h2>Add New Product</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <form action="products.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>
            
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>
            
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <h2>Existing Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($food_items as $item): ?>
                <tr>
                    <td><img src="../<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="60" height="60"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                    <td>
                        <form action="products.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                            <button type="submit" name="delete_product" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
