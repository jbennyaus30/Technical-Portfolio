<?php
session_start();
require_once '../../config.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Retrieve the admin name from the session
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Chic Style Boutique</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">
    <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>
    <div class="flex">

        <!-- sidebar menu -->
        <?php include 'sidebar.php'; ?>

        <!-- main -->
        <div class="flex2">
            <main>
                <h2>Welcome, <?php echo htmlspecialchars($adminName); ?>!</h2>
                <p>This is your admin dashboard.</p>
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
