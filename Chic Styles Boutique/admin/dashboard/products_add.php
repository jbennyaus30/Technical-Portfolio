<?php
session_start();
require_once '../../config.php';
require_once '../../db_connection.php';

// Redirect to login if the admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

// Fetch all categories
$categories = $conn->query("SELECT * FROM Categories");

// Fetch all sizes
$sizes = $conn->query("SELECT * FROM Sizes");

if (!empty($image['name'])) {
    $target_dir = "../../img/shop/";
    
    // Ensure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }

    $image_name = time() . "_" . basename($image["name"]);
    $target_file = $target_dir . $image_name;

    // Validate the uploaded file
    if ($image['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
        }
        if ($image['size'] > 2 * 1024 * 1024) {
            die("File size exceeds 2MB.");
        }
    } else {
        die("File upload error: " . $image['error']);
    }

    // Move the uploaded file
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        die("Error uploading image.");
    }

    // Save the file name to the database
    $sql = "UPDATE product SET ProductImg = ? WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $image_name, $ProductID);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Chic Style Boutique</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/dashboard/admin-dashboard.css">
</head>
<body>
    <div class="flex">
        <?php include 'sidebar.php'; ?>

        <div class="flex2">  
            <main class="product-edit">
                <h2>Add New Product</h2>
                
                <form action="product_save.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <label for="product-name">Product Name</label>
                        <input type="text" id="product-name" name="ProductName" required>    
                    </fieldset>
                    <fieldset>
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>    
                    </fieldset>
                    <fieldset>
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </fieldset>
                    <fieldset>
                        <label>Categories</label>
                        <div class="category-group">
                            <?php while ($category = $categories->fetch_assoc()): ?>
                                <label>
                                    <input type="checkbox" name="categories[]" value="<?php echo $category['CategoryID']; ?>">
                                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                                </label>
                            <?php endwhile; ?>
                        </div>    
                    </fieldset>
                    <fieldset>
                        <label>Size and Stock</label>
                        <div class="size-group">
                            <?php while ($size = $sizes->fetch_assoc()): ?>
                                <label>
                                    <strong><?php echo htmlspecialchars($size['SizeName']); ?></strong>
                                    <input type="number" name="size_stock[<?php echo $size['SizeID']; ?>]" min="0" value="0">
                                </label>
                            <?php endwhile; ?>
                        </div>
                    </fieldset>
                    <fieldset class="thumbnail">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" accept="image/*">    
                    </fieldset>
                    <div class="update_button">
                        <button type="submit">Add Product</button>
                    </div>
                </form>
                
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
