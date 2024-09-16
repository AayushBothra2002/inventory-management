<?php
session_start();

// Ensure the user has the correct role
if ($_SESSION['role'] !== 'User') {
    header('Location: login.php');
    exit;
}

require 'config.php';

// Fetch the list of products from the database
$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2>User Dashboard</h2>

    <h3>Available Products</h3>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Product Name</th><th>Quantity</th><th>Price</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No products available.";
    }
    ?>

    <br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
