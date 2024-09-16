<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'Admin') {
                header('Location: admin_dashboard.php');
            } elseif ($user['role'] === 'Special') {
                header('Location: special_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
