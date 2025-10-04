<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Validate and get the order_id from the URL
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die('Invalid order ID.');
}

$order_id = intval($_GET['order_id']);

// Fetch the order details
$order_query = "
    SELECT 
        o.*, 
        s.first_name AS shipping_first_name, s.last_name AS shipping_last_name, 
        s.address_line1 AS shipping_address1, s.address_line2 AS shipping_address2, 
        s.suburb AS shipping_suburb, s.state AS shipping_state, s.postcode AS shipping_postcode, 
        s.country AS shipping_country, s.phone AS shipping_phone
    FROM orders o
    INNER JOIN shipping_address s ON o.shipping_address_id = s.shipping_id
    WHERE o.order_id = ?
";
$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param('i', $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

// If no order is found, show an error
if (!$order) {
    die('Order not found.');
}

// Fetch the order items
$order_items_query = "
    SELECT 
        oi.*, 
        p.ProductName, p.ProductImg
    FROM order_items oi
    INNER JOIN products p ON oi.product_id = p.ProductID
    WHERE oi.order_id = ?
";
$order_items_stmt = $conn->prepare($order_items_query);
$order_items_stmt->bind_param('i', $order_id);
$order_items_stmt->execute();
$order_items = $order_items_stmt->get_result();

// Calculate totals
$subtotal = 0;
while ($item = $order_items->fetch_assoc()) {
    $subtotal += $item['subtotal'];
}
$order_items->data_seek(0); // Reset result pointer
$shipping_fee = 15.00; // Example fixed shipping fee
$total = $subtotal + $shipping_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Chic Style Boutique</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>
    <div class="flex">
        <!-- Include the sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex2">
            <main class="orders-details">
                <h2>Order Details</h2>
                <section class="order-summary">
                    <form id="order-status-form" action="order_status_update.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <p><strong>Order No.:</strong> <?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></p>
                        <p><strong>Order Date:</strong> <?php echo date('d M Y', strtotime($order['order_date'])); ?></p>

                        <fieldset>
                            <label for="order-status"><strong>Order Status:</strong></label>
                            <select id="order-status" name="status">
                                <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Completed" <?php echo $order['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </fieldset>

                        <fieldset>
                            <label for="tracking-number"><strong>Tracking Number:</strong></label>
                            <input type="text" id="tracking-number" name="tracking_number" value="<?php echo htmlspecialchars($order['tracking_number']); ?>">
                        </fieldset>
                        
                        <button type="submit" class="update-btn">Update Order</button>
                    </form>
                </section>
                            
                <hr>
            
                <section class="address-details">
                    <article class="shipping-details">
                        <h3>Shipping Details:</h3>
                        <address>
                            <?php echo htmlspecialchars($order['shipping_first_name'] . ' ' . $order['shipping_last_name']); ?><br>
                            <?php echo htmlspecialchars($order['shipping_address1']) . ' ' . htmlspecialchars($order['shipping_address2']); ?><br>
                            <?php echo htmlspecialchars($order['shipping_suburb']) . ', ' . htmlspecialchars($order['shipping_state']) . ' ' . htmlspecialchars($order['shipping_postcode']); ?><br>
                            <?php echo htmlspecialchars($order['shipping_country']); ?><br>
                            <?php echo htmlspecialchars($order['shipping_phone']); ?>
                        </address>
                    </article>
                </section>
            
                <hr>
            
                <section class="order-items">
                    <h3>Order Items</h3>
                    <table>
                        <tbody>
                            <?php while ($item = $order_items->fetch_assoc()): ?>
                                <tr>
                                    <td><img src="../../img/shop/<?php echo htmlspecialchars($item['ProductImg']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>"></td>
                                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td>×<?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>Subtotal: $<?php echo number_format($item['subtotal'], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </section>
            
                <section class="order-totals">
                    <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                    <p><strong>Shipping Fee:</strong> $<?php echo number_format($shipping_fee, 2); ?></p>
                    <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
                </section>
            
                <nav class="back-navigation">
                    <button class="back-btn" onclick="history.back()">← Back</button>
                </nav>
            </main>
            <footer>
                <div class="container">
                    <small>©<?php echo date('Y'); ?> All Rights Reserved</small>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
