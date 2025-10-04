<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Check if the ProductID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

// retrieve the ProductID
$ProductID = intval($_GET['id']);

// Delete related data in child tables first
try {
    $conn->begin_transaction();

    // Delete from `ProductSizes` table
    $size_stmt = $conn->prepare("DELETE FROM ProductSizes WHERE ProductID = ?");
    $size_stmt->bind_param('i', $ProductID);
    $size_stmt->execute();

    // Delete from `ProductCategories` table
    $category_stmt = $conn->prepare("DELETE FROM ProductCategories WHERE ProductID = ?");
    $category_stmt->bind_param('i', $ProductID);
    $category_stmt->execute();

    // Fetch the product's image names
    $product_stmt = $conn->prepare("SELECT ProductImg, ProductImgLarge FROM Products WHERE ProductID = ?");
    $product_stmt->bind_param('i', $ProductID);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();
    $product = $product_result->fetch_assoc();

    if ($product) {
        $image_path = "../../img/shop/" . $product['ProductImg'];
        $large_image_path = "../../img/shop/" . $product['ProductImgLarge'];

        // Delete the product images
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        if (file_exists($large_image_path)) {
            unlink($large_image_path);
        }
    }

    // Delete from `Products` table
    $product_delete_stmt = $conn->prepare("DELETE FROM Products WHERE ProductID = ?");
    $product_delete_stmt->bind_param('i', $ProductID);
    $product_delete_stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Redirect to the products page with a success message
    header('Location: ' . BASE_URL . 'admin/dashboard/products.php?deleted=1');
    exit();
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    die("Error deleting product: " . $e->getMessage());
}
?>
