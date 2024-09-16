<?php
session_start();
if ($_SESSION['role'] !== 'Special') {
    header('Location: login.php');
    exit;
}

require 'config.php';

$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special User Dashboard</title>
</head>
<body>
    <h2>Special User Dashboard</h2>
    <!-- Display inventory -->
    <h3>Product Inventory</h3>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['product_name']}</td><td>{$row['quantity']}</td><td>{$row['price']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No products found.";
    }
    ?>
</body>
</html>
