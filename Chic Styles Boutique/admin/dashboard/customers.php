<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Fetch customer details along with billing addresses from `billing_details`
$sql = "
    SELECT 
        u.user_id,
        u.user_first_name,
        u.user_last_name,
        u.user_email,
        u.user_phone,
        b.company_name,
        b.address_line1,
        b.address_line2,
        b.suburb,
        b.state,
        b.postcode,
        b.country
    FROM user u
    LEFT JOIN billing_details b ON u.user_id = b.user_id
    WHERE u.user_role_id = '1' -- Assuming '1' is the role ID for customers
    ORDER BY u.user_first_name ASC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Chic Style Boutique</title>
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
                <h2>Customers</h2>
                <div class="scrollable-table">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Billing Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($customer = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(str_pad($customer['user_id'], 5, '0', STR_PAD_LEFT)); ?></td>
                                        <td><?php echo htmlspecialchars($customer['user_first_name'] . ' ' . $customer['user_last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['company_name'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($customer['user_email']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['user_phone'] ?? '-'); ?></td>
                                        <td>
                                            <?php 
                                                echo htmlspecialchars($customer['address_line1'] ?? '') . '<br>' . 
                                                     htmlspecialchars($customer['address_line2'] ?? '') . '<br>' . 
                                                     htmlspecialchars($customer['suburb'] ?? '') . ', ' . 
                                                     htmlspecialchars($customer['state'] ?? '') . ' ' . 
                                                     htmlspecialchars($customer['postcode'] ?? '') . '<br>' . 
                                                     htmlspecialchars($customer['country'] ?? ''); 
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No customers found.</td>
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
