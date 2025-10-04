<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Chic Styles Boutique</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<?php include 'config.php'; ?>
<?php include 'header.php'; ?>
<body data-base-url="<?php echo BASE_URL; ?>">



    <!-- background-overlay -->
    <div id="overlay"></div>

    <main>
        <!-- kv -->
        <section class="kv">
            <div class="kv_text">
                <p class="subtitle">Chic Styles Boutique</p>
                <h2>Summer Collection<br>2025</h2>
                <button onclick="location.href='shop/collection.php'">View all items <span>→</span></button>
            </div>
        </section>

        <!-- Category -->
        <section class="category">
            <ul>
                <li>
                    <a href="shop/newarrivals.php">
                        <figure>
                            <div><img src="img/top/section1-1.png" alt="New Arrivals" title="New Arrivals"></div>
                            <figcaption>New Arrivals</figcaption>
                        </figure>
                    </a>
                </li>
                <li>
                    <a href="shop/collection.php">
                        <figure>
                            <div><img src="img/top/section1-2.png" alt="Collection" title="Collection"></div>
                            <figcaption>Collection</figcaption>
                        </figure>
                    </a>
                </li>
                <li>
                    <a href="shop/dresses.php">
                        <figure>
                            <div><img src="img/top/section1-3.png" alt="Dresses" title="Dresses"></div>
                            <figcaption>Dresses</figcaption>
                        </figure>
                    </a>
                </li>
                <li>
                    <a href="shop/accessories.php">
                        <figure>
                            <div><img src="img/top/section1-4.png" alt="Accessories" title="Accessories"></div>
                            <figcaption>Accessories</figcaption>
                        </figure>
                    </a>
                </li>
            </ul>
        </section>

        <!-- Featured Item -->
        <section class="featureditem">
            <ul>
                <li>
                    <p class="subtitle">Featured item</p>
                    <h2>White Cotton Dress</h2>
                    <p>Discover our most popular resort-style pieces<br class="pc_only">
                        that combine elegance with effortless charm.<br class="pc_only">
                        Shop the favorites that everyone loves!</p>
                    <button onclick="location.href='product/?1'">View detail <span>→</span></button>
                </li>
                <li>
                    <img src="img/top/section2.png" alt="White Cotton Dress">
                </li>
            </ul>
        </section>

        <!-- About Us -->
        <section class="aboutus">
            <ul>
                <li>
                    <p class="subtitle">About Us</p>
                    <h2><img src="img/top/logo_white.png" alt="Chic Styles Boutique"></h2>
                    <p>Learn about Chic Styles Boutique, our philosophy, 
                        and how we curate timeless resort-inspired fashion for sophisticated women.</p>
                    <button onclick="location.href='aboutus/index.php'">View detail <span>→</span></button>
                </li>
                <li>
                    <img src="img/top/section3_pc.png" alt="Chic Styles Boutique Necklace" class="pc_only">
                    <img src="img/top/section3_sp.png" alt="Chic Styles Boutique Necklace" class="sp_only">
                </li>
            </ul>
        </section>

        <!-- look Book & Blogs -->
        <section class="lookbook_blogs">
            <ul>
                <li>
                    <p class="subtitle">Chic Styles Boutique’s</p>
                    <h2>Look Book</h2>
                    <p>Explore our gallery of styled outfits<br class="pc_only">
                        to inspire your next vacation wardrobe.<br class="pc_only">
                        See how our pieces come together in real-life settings.</p>
                    <button onclick="location.href='lookbook/index.php'">View our look book <span>→</span></button>
                </li>
                <li>            
                    <img src="img/top/section4-1.png" alt="Look Book">        
                </li>
            </ul>
            <ul>
                <li>
                    <p class="subtitle">Blogs</p>
                    <h2>Fashion Tips</h2>
                    <p>Get expert advice on styling resort wear,<br class="pc_only">
                        creating chic outfits, and embracing timeless elegance<br class="pc_only">
                        for any occasion.</p>
                    <button onclick="location.href='blogs/index.php'">View blogs <span>→</span></button>
                </li>
                <li>            
                    <img src="img/top/section4-2.png" alt="Look Book">  
                </li>
            </ul>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
