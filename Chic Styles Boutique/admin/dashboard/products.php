<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Fetch products from the database
$sql = "SELECT ProductID, ProductName, ProductPrice, ProductImg, ProductStock FROM Products";
$result = $conn->query($sql);

if (!$result) {
    die("Error retrieving products: " . $conn->error);
}

// After deleting size stock or a size:
$sql = "UPDATE Products 
        SET ProductStock = (
            SELECT COALESCE(SUM(Stock), 0) 
            FROM ProductSizes 
            WHERE ProductID = ?
        ) 
        WHERE ProductID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $ProductID, $ProductID);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Chic Style Boutique</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/dashboard/admin-dashboard.css">
    <script src="<?php echo BASE_URL; ?>script.js"></script>
    <script src="<?php echo BASE_URL; ?>admin/dashboard/admin-dashboard.js"></script>
</head>
<body>
    <div class="flex">
        <!-- Include the sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex2">
            <main>
                <h2>Products</h2>
                <button class="add-product-btn" type="button" onclick="location.href='<?php echo BASE_URL; ?>admin/dashboard/products_add.php'">+ Add New Product</button>

                <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
                    <p class="success-message" style="color:red;">Product deleted successfully!</p>
                <?php endif; ?>

                <div class="scrollable-table">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['ProductID']); ?></td>
                                    <td><img src="<?php echo BASE_URL . 'img/shop/' . htmlspecialchars($row['ProductImg']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>"></td>
                                    <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
                                    <td>$<?php echo number_format($row['ProductPrice'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['ProductStock']); ?></td>
                                    <td>
                                        <button class="edit-btn" type="button" onclick="location.href='<?php echo BASE_URL; ?>admin/dashboard/products_edit.php?id=<?php echo $row['ProductID']; ?>'">Edit</button>
                                        <button class="delete-btn" type="button" onclick="deleteProduct(<?php echo $row['ProductID']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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

    <script>
        // Delete product confirmation
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = '<?php echo BASE_URL; ?>admin/dashboard/products_delete.php?id=' + productId;
            }
        }
    </script>
</body>
</html>
