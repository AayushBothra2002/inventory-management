<?php
session_start();
if ($_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header('Location: admin_dashboard.php');
exit;
?>
