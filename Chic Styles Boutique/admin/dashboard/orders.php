<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Fetch orders with related customer and shipping information
$sql = "
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        o.total_price,
        u.user_first_name,
        u.user_last_name,
        s.address_line1,
        s.address_line2,
        s.suburb,
        s.state,
        s.postcode,
        s.country,
        s.phone
    FROM orders o
    INNER JOIN USER u ON o.user_id = u.user_id
    INNER JOIN shipping_address s ON o.shipping_address_id = s.shipping_id
    ORDER BY o.order_date DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Chic Style Boutique</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="admin-dashboard.css">
    <script src="../../script.js"></script>
    <script src="admin-dashboard.js"></script>
</head>
<body>
    <div class="flex">
        <!-- Include the sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex2">
            <main>
                <h2>Orders</h2>
                <div class="scrollable-table">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Ship to</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($order = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($order['user_first_name'] . ' ' . $order['user_last_name']); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($order['address_line1']); ?><br>
                                            <?php if (!empty($order['address_line2'])) echo htmlspecialchars($order['address_line2']) . '<br>'; ?>
                                            <?php echo htmlspecialchars($order['suburb'] . ', ' . $order['state'] . ' ' . $order['postcode']); ?><br>
                                            <?php echo htmlspecialchars($order['country']); ?><br>
                                            <?php echo htmlspecialchars($order['phone']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        <td>
                                            <button class="order-view-btn" type="button" onclick="location.href='order_details.php?order_id=<?php echo $order['order_id']; ?>'">View Details</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
