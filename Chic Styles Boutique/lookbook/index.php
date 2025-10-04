<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lookbook - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="lookbook.css">
    <script src="../script.js"></script>
    <script src="lookbook.js"></script>

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
                <li>Look book</li>
            </ol>

            <h2>Look Book</h2>
        </nav>
    
        <!-- Gallery Section -->
        <section class="gallery-section">

            <h3 class="lookbook_title">I’d like to be inspired by…</h3>

            <!-- Tab Buttons -->
            <div class="tabs">
                <button class="tab-btn active" data-tab="dresses">Dresses</button>
                <button class="tab-btn" data-tab="accessories">Accessories</button>
            </div>
    
            <!-- Gallery -->
            <div class="tab-content" id="dresses">
                <div class="gallery-grid">
                    <figure>
                        <div><a href="../img/lookbook/dresses/img1.png"><img src="../img/lookbook/dresses/img1.png" alt="Flower mini Dress" title="Flower mini Dress"></a></div>
                        <figcaption>Flower mini Dress</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/dresses/img2.png"><img src="../img/lookbook/dresses/img2.png" alt="Pearl half tops" title="Pearl half tops"></a></div>
                        <figcaption>Pearl half tops</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/dresses/img3.png"><img src="../img/lookbook/dresses/img3.png" alt="Elegant cotton dress" title="Elegant cotton dress"></a></div>
                        <figcaption>Elegant cotton dress</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/dresses/img4.png"><img src="../img/lookbook/dresses/img4.png" alt="White chiffon setup" title="White chiffon setup"></a></div>
                        <figcaption>White chiffon setup</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/dresses/img5.png"><img src="../img/lookbook/dresses/img5.png" alt="White stripe mini dress" title="White stripe mini dress"></a></div>
                        <figcaption>White stripe mini dress</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/dresses/img6.png"><img src="../img/lookbook/dresses/img6.png" alt="White chiffon mini dress" title="White chiffon mini dress"></a></div>
                        <figcaption>White chiffon mini dress</figcaption>
                    </figure>
                </div>
            </div>
    
            <div class="tab-content hidden" id="accessories">
                <div class="gallery-grid">
                    <figure>
                        <div><a href="../img/lookbook/accessories/img1.png"><img src="../img/lookbook/accessories/img1.png" alt="Double thin necklace" title="Double thin necklace"></a></div>
                        <figcaption>Double thin necklace</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/accessories/img2.png"><img src="../img/lookbook/accessories/img2.png" alt="Marble round earrings" title="Marble round earrings"></a></div>
                        <figcaption>Marble round earrings</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/accessories/img3.png"><img src="../img/lookbook/accessories/img3.png" alt="Clear pink earrings" title="Clear pink earrings"></a></div>
                        <figcaption>Clear pink earrings</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/accessories/img4.png"><img src="../img/lookbook/accessories/img4.png" alt="Double ring necklace" title="Double ring necklace"></a></div>
                        <figcaption>Double ring necklace</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/accessories/img5.png"><img src="../img/lookbook/accessories/img5.png" alt="Silver ruby ring" title="Silver ruby ring"></a></div>
                        <figcaption>Silver ruby ring</figcaption>
                    </figure>
                    <figure>
                        <div><a href="../img/lookbook/accessories/img6.png"><img src="../img/lookbook/accessories/img6.png" alt="Gold elegant anklet" title="Gold elegant anklet"></a></div>
                        <figcaption>Gold elegant anklet</figcaption>
                    </figure>
                </div>
            </div>
        </section>
    
    </main>
    

    <?php include '../footer.php'; ?>

</body>
</html>