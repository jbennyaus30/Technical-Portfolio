<?php
if (!isset($adminName)) {
    $adminName = 'Admin'; // Ensure $adminName has a default value
}
?>
<aside>
    <div class="fix">
        <h1><a href="<?php echo BASE_URL; ?>admin/dashboard/index.php">CHIC STYLES BOUTIQUE</a></h1>
        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>admin/dashboard/products.php">Products →</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/dashboard/orders.php">Orders →</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/dashboard/customers.php">Customers →</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/logout.php">Log out →</a></li>
            </ul>
        </nav>
    </div>
</aside>
