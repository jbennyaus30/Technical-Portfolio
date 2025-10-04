<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $tracking_number = $_POST['tracking_number'];

    // Update order status and tracking number
    $sql = "UPDATE orders SET status = ?, tracking_number = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $status, $tracking_number, $order_id);

    if ($stmt->execute()) {
        header('Location: order_details.php?order_id=' . $order_id . '&success=1');
        exit();
    } else {
        die("Error updating order: " . $conn->error);
    }
} else {
    die("Invalid request.");
}
?>
