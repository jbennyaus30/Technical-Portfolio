<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Chic Styles Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="aboutus.css">
    <script src="../script.js"></script>

</head>

<?php include '../config.php'; ?>
<?php include '../header.php'; ?>
<body data-base-url="<?php echo BASE_URL; ?>">


    <!-- background-overlay -->
    <div id="overlay"></div>

    
    <main id="mainAboutus">

        <!-- breadcrumbs -->
        <nav class="breadcrumbs">
            <ol>
                <li><a href="../index.html">Home</a></li>
                <li>About Us</li>
            </ol>
        </nav>

        <!-- fv -->
         <section class="fv">
            <div class="fv_bg">
                <video autoplay loop muted playsinlin>
                  <source src="../img/aboutus/aboutus_fv.mp4" type="video/mp4">
                </video>
            </div>
            <div class="fv_title">
                <h2>About Us</h2>
            </div>

            <div class="para1_bg">
                <p>
                    At <strong>Chic Styles Boutique</strong>, we believe in the beauty of simplicity. <br>
                    Our curated collection of resort-inspired clothing and accessories is designed for women who appreciate clean lines, timeless elegance, and effortless style. Based in Australia, we specialize in pieces that embody the perfect balance of sophistication and relaxation. Our boutique offers a thoughtfully selected range of high-quality items in classic black and white, with prices that reflect the value of impeccable craftsmanship and design.
                </p>
            </div>
         </section>

         <section class="ceo">
            <ul>
                <li>
                    <!-- <img src="../img/aboutus/ceo.png" alt="CEO Sophia Maxwell"> -->
                    <img src="../img/aboutus/ceo_name.png" alt="Sophia Maxwell" class="ceo_name">
                </li>
                <li>
                    <figure>
                        <img src="../img/aboutus/item_pc.png" alt="Our signatured neckless" class="pc_only">
                        <img src="../img/aboutus/item_sp.png" alt="Our signatured neckless" class="sp_only">
                    </figure>
                    <p>"Effortless Elegance,<br>Curated for You"</p>
                    <small>Founder & Creative Director: Sophia Maxwell</small>
                </li>
            </ul>

            <div class="para2_bg">
                <p>
                    Founded by Sophia Maxwell, a passionate fashion designer and creative visionary, Chic Styles Boutique is a small yet exclusive fashion destination for women aged 30-40. Sophia’s love for resort wear—pieces that transition seamlessly from beachside elegance to an evening out—drives the heart of the brand. Drawing inspiration from Australian coastal living, her designs emphasize fluid silhouettes, luxurious fabrics, and an innate sense of effortless style.<br><br>

                    Every item at Chic Styles is selected with intention. We focus on offering a small, but refined collection that ensures exclusivity and elevates your wardrobe with timeless, versatile pieces. Our curated collection in black and white is designed to suit women who appreciate the beauty of minimalist style, but with the added luxury of high-quality materials. With a price range of AUD 80–120, our items strike the perfect balance of luxury and accessibility.<br><br>

                    Whether you’re lounging by the sea or dining at a resort, Chic Styles ensures you look and feel your best, no matter the occasion.
                </p>
            </div>

         </section>

    </main>


    <?php include '../footer.php'; ?>

</body>
</html>