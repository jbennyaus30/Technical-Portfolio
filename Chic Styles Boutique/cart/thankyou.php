<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="cart.css">
    <script src="../script.js"></script>
    <script src="cart.js"></script>
</head>

<?php include '../config.php'; ?>
<?php include '../header.php'; ?>
<?php include '../db_connection.php'; ?>
<?php
    if ($isUserLoggedIn) {
        $query  = "DELETE FROM CartItems WHERE CartItems.UserID=" . $_SESSION["user_id"];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->close();
    }
?>
<body data-base-url="<?php echo BASE_URL; ?>">

    <!-- background-overlay -->
    <div id="overlay"></div>

    <!-- breadcrumbs -->
    <nav class="breadcrumbs">
        <ol>
            <li><a href="../index.php">Home</a></li>
            <li><a href="index.php">Cart</a></li>
            <li>Checkout</li>
        </ol>

        <h2>Checkout</h2>
    </nav>

    <main>
        <section id="login" class="thankyou">

            <figure><img src="../img/login/icon-check.svg" alt="check icon"></figure>
            <h3>Thank you so much for your order!</h3>

            <p>Your order no. #00003 is officialy confirmed and email has been sent on 20019026@students.koi.edu.au.</p>

            <form action="#" id="contactForm" onsubmit="return validateContactForm()" novalidate>
        
        </section>
    </main>
    


<?php include '../footer.php'; ?>


</body>
</html>
