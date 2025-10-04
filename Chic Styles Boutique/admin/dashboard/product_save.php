<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$target_dir = realpath(__DIR__ . "/../../img/shop/") . "/";
if (!is_dir($target_dir)) {
    die("Target directory does not exist: " . $target_dir);
}
if (!is_writable($target_dir)) {
    die("Target directory is not writable: " . $target_dir);
}


session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ProductName = $_POST['ProductName'];
    $price = floatval($_POST['price']);
    $description = $_POST['description'];
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
    $size_stock = isset($_POST['size_stock']) ? $_POST['size_stock'] : [];
    $image = $_FILES['image'];

    // Validate required fields
    if (empty($ProductName) || empty($price) || empty($description)) {
        die("All fields are required.");
    }

    // Handle image upload
    $image_name = null;
    if (!empty($image['name'])) {
        $target_dir = "../../img/shop/";
        $image_name = time() . "_" . basename($image["name"]);
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
            die("Error uploading image.");
        }
    }

    // Insert product into the `product` table
    $sql = "INSERT INTO Products (ProductName, ProductPrice, ProductDescription, ProductImg, ProductImgLarge) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsss', $ProductName, $price, $description, $image_name, $image_name);

    if (!$stmt->execute()) {
        die("Error adding product: " . $stmt->error);
    }

    // Get the inserted product ID
    $ProductID = $stmt->insert_id;

    // Insert categories into `product_categories` table
    $category_stmt = $conn->prepare("INSERT INTO ProductCategories (ProductID, CategoryID) VALUES (?, ?)");
    foreach ($categories as $CategoryID) {
        $category_stmt->bind_param('ii', $ProductID, $CategoryID);
        $category_stmt->execute();
    }

    // Update ProductSizes
    foreach ($size_stock as $SizeID => $stock) {
        $size_stmt = $conn->prepare("INSERT INTO ProductSizes (ProductID, SizeID, Stock) VALUES (?, ?, ?)");
        $size_stmt->bind_param('iii', $ProductID, $SizeID, $stock);
        $size_stmt->execute();
    }

    // Update ProductStock in Products table
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


    // Redirect to product list with success message
    header('Location: ' . BASE_URL . 'admin/dashboard/products.php?success=1');
    exit();
} else {
    die("Invalid request.");
}
?>
