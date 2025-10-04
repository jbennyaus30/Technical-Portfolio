<?php
session_start();
require '../db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Access denied. Please log in.');
}

// Check if user is an admin
$query = "SELECT user_role_id FROM USER WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if ($user['user_role_id'] != 2) {
        die('Access denied. Admins only.');
    }
} else {
    die('Access denied.');
}

// Display admin dashboard content
echo '<h1>Welcome to the Admin Dashboard!</h1>';
echo '<p>Only admins can see this page.</p>';
?>
