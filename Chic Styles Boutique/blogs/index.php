<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="blogs.css">
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
                <li>Blogs</li>
            </ol>

            <h2>Blogs</h2>
        </nav>

        <section class="blog-section">
            <ul class="blog-list">
                <li class="blog-item full-width">
                    <ul>
                        <li>
                            <img src="../img/blog/blog_list/blog1_pc.png" alt="How to Transform Any Outfit with the Right Necklace">
                        </li>
                        <li>
                            <small>Nov 2024</small>
                            <h3>How to Transform Any Outfit with the Right Necklace</h3>
                            <button onclick="location.href='blog_NOV2024.php'">View more <span>→</span></button>
                        </li>
                    </ul>
                </li>
                <li class="blog-item half-width">
                    <ul>
                        <li>
                            <img src="../img/blog/blog_list/blog2_pc.png" alt="The Secret to Romanticizing Your Resort-Wear Wardrobe">
                        </li>
                        <li>
                            <small>Oct 2024</small>
                            <h3>The Secret to Romanticizing Your Resort-Wear Wardrobe</h3>
                            <button onclick="location.href='blog_OCT2024.php'">View more <span>→</span></button>
                        </li>
                    </ul>
                </li>
                <li class="blog-item half-width">
                    <ul>
                        <li>
                            <img src="../img/blog/blog_list/blog3_pc.png" alt="Elevate Your Style with the Power of Perfume">
                        </li>
                        <li>
                            <small>Sep 2024</small>
                            <h3>Elevate Your Style with the Power of Perfume</h3>
                            <button onclick="location.href='blog_SEP2024.php'">View more <span>→</span></button>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
    </main>
    

    <?php include '../footer.php'; ?>

</body>
</html>