<?php

session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get product details
    $ProductID = intval($_POST['ProductID']);
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

    // Update product details
    $sql = "UPDATE Products SET ProductName = ?, ProductPrice = ?, ProductDescription = ? WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsi', $ProductName, $price, $description, $ProductID);
    if (!$stmt->execute()) {
        die("Error updating product: " . $conn->error);
    }

    // Handle image upload (if a new image is uploaded)
    if (!empty($image['name'])) {
        $target_dir = "../../img/shop/";
        $image_name = time() . '_' . basename($image["name"]); // Avoid overwriting by appending a timestamp
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image file type
        $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $allowed_file_types)) {
            die("Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        // Validate image size (optional, e.g., max 5MB)
        if ($image["size"] > 5 * 1024 * 1024) {
            die("Image size exceeds the allowed limit of 5MB.");
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            // Update the database with the new image name
            $sql = "UPDATE Products SET ProductImg = ? WHERE ProductID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $image_name, $ProductID);
            if (!$stmt->execute()) {
                die("Error updating product image: " . $stmt->error);
            }
        } else {
            die("Error uploading the image.");
        }
    }


    // Update categories
    $conn->query("DELETE FROM ProductCategories WHERE ProductID = $ProductID");
    $category_stmt = $conn->prepare("INSERT INTO ProductCategories (ProductID, CategoryID) VALUES (?, ?)");
    foreach ($categories as $CategoryID) {
        $category_stmt->bind_param('ii', $ProductID, $CategoryID);
        $category_stmt->execute();
    }

    // Update size-specific stock
    foreach ($size_stock as $SizeID => $stock) {
        $size_stmt = $conn->prepare("
            INSERT INTO ProductSizes (ProductID, SizeID, Stock) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE Stock = VALUES(Stock)
        ");
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


    // Redirect to product listing or success page
    header('Location: ' . BASE_URL . 'admin/dashboard/products.php?success=1');
    exit();
} else {
    die("Invalid request.");
}
?>
