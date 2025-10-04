<?php
    require_once "../db_connection.php";

    if ($_SERVER["QUERY_STRING"] == "") {
        echo "Product ID not set";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM Products WHERE Products.ProductID=" . $_SERVER["QUERY_STRING"]);
    $stmt -> execute();
    $products_result = $stmt->get_result();

    $product = [
        "ProductName" => "UNKNOWN", 
        "ProductImg" => "UNKNOWN", 
        "ProductImgLarge" => "UNKNOWN", 
        "ProductPrice" => 0
    ];
    if ($products_result->num_rows != 0) {
        $product = $products_result->fetch_assoc();
    }

    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product["ProductName"]; ?> - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="product.css">
    <script src="../script.js"></script>
</head>

<?php include '../config.php'; ?>
<?php include '../header.php'; ?>
<body data-base-url="<?php echo BASE_URL; ?>">

    <!-- background-overlay -->
    <div id="overlay"></div>

    
    <main>

        <!-- breadcrumbs -->
        <nav class="breadcrumbs">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../shop/index.php">Shop</a></li>
                <li><?php echo $product["ProductName"]; ?></li>
            </ol>
        </nav>

        <!-- Product Details Section -->
        <section class="product-details">
            <article class="product-container">

                <!-- Left: Product Thumbnail -->
                <figure class="product-thumbnail">
                        <a href="../img/shop/large/<?php echo $product["ProductImgLarge"]; ?>">
                            <?php
                                echo '<img src="../img/shop/' . $product["ProductImg"]. '" alt="' . $product["ProductName"] . '" title="' . $product["ProductName"] . '">';
                            ?>
                        </a>
                </figure>

                <!-- Right: Product Information -->
                <section class="product-info">
                    <?php
                    echo '<h2>'.$product["ProductName"].'</h2>
                    <p class="price">AUD ' . number_format((float)$product["ProductPrice"], 2, '.', '') . '</p>';
                    ?>

                    <form action="<?php echo BASE_URL; ?>cart/index.php" method="POST" >
                        <!-- Size -->
                        <?php require_once "fetch_size_selector.php"; ?>

                        <!-- Amount Selection -->
                        <section class="amount-selector">
                            <label for="amount">Amount :</label>
                            <input type="number" id="amount" name="amount" value="1" min="1" max="3">
                        </section>
                        
                        <input type="hidden" name="product_id" value="<?php echo $product["ProductID"]; ?>">
                        
                        <!-- Cart Button -->
                        <?php 
                        if (!$isUserLoggedIn) {
                            echo '<p>You must login to add this item to your cart.</p><br><br>';
                        } else {
                            echo '<button class="add-to-cart-button">Add to Cart</button>';
                        }
                        ?>
                    </form>
                    <!-- Product Description -->
                    <p class="product-description">
                        <?php
                            echo $product["ProductDescription"];
                        ?>
                    </p>
                </section>
            </article>
        </section>

    </main>
    

    <?php include '../footer.php'; ?>

</body>
</html>