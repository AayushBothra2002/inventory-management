<?php
session_start();
if ($_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $query = "INSERT INTO products (product_name, quantity, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sid', $product_name, $quantity, $price);
    $stmt->execute();
}

$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <!-- Form to add a new product -->
    <form action="admin_dashboard.php" method="POST">
        <h3>Add New Product</h3>
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Display inventory -->
    <h3>Product Inventory</h3>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['product_name']}</td><td>{$row['quantity']}</td><td>{$row['price']}</td>";
            echo "<td><a href='edit_product.php?id={$row['id']}'>Edit</a> | <a href='delete_product.php?id={$row['id']}'>Delete</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No products found.";
    }
    ?>
</body>
</html>
