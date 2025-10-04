<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="myaccount.css">
    <script src="../script.js"></script>
    <script src="myaccount.js"></script>
</head>

<?php include '../config.php'; ?>
<?php include '../header.php'; ?>
<body data-base-url="<?php echo BASE_URL; ?>">

    <!-- background-overlay -->
    <div id="overlay"></div>

    <!-- breadcrumbs -->
    <nav class="breadcrumbs">
        <ol>
            <li><a href="../index.php">Home</a></li>
            <li>My Account</li>
        </ol>

        <h2>My Account</h2>
    </nav>


    <div id="myaccount">

        <!-- Left -->
        <aside>
            <p class="welcome">Welcome, ◯◯◯!</p>
            <hr>
            <nav>
                <ul>
                    <li><a href="orders.php">Orders →</a></li>
                    <li><a href="account-detail.php">Account Details →</a></li>
                    <li><a href="billing-detail.php">Billing Details →</a></li>
                    <li><a href="../login/index.php">Log out →</a></li>
                </ul>
            </nav>
        </aside>


        <!-- Right -->
        <main>

            <section id="orders" class="order-detail">
                <h3>Orders</h3>

                <table>
                    <tr>
                        <th>Order No.:</th>
                        <td>00003</td>
                    </tr>
                    <tr>
                        <th>Order Date:</th>
                        <td>12 Dec 2022</td>
                    </tr>
                    <tr>
                        <th>Order Status:</th>
                        <td class="shipped">Shipped</td>
                        <!-- <td class="processing">Processing</td> -->
                        <!-- <td class="pending">Pending</td> -->
                    </tr>
                </table>

                <hr>

                <ol>
                    <li>
                        <figure><img src="../img/shop/DR8.png" alt=""></figure>
                        <div class="order-text">
                            <p>White cotton dress</p>
                            <p>$120.00</p>
                            <p>×1</p>
                        </div>
                    </li>
                    <li>
                        <figure><img src="../img/shop/AC8.png" alt=""></figure>
                        <div class="order-text">
                            <p>Double ring necklace</p>
                            <p>$120.00</p>
                            <p>×1</p>
                        </div>
                    </li>
                </ol>
                <table>
                    <tr>
                        <th>Subtotal:</th>
                        <td>$240</td>
                    </tr>
                    <tr>
                        <th>Shipping Fee:</th>
                        <td>$15</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>$255</td>
                    </tr>
                </table>

                <hr>

                <table class="order-address">
                    <tr>
                        <th>Billing Details:</th>
                        <td>
                            Akiko Ishijima <br>
                            Level 1/31 Market St, Sydney NSW 2000
                            Australia<br>
                            +61 41234 5678
                        </td>
                    </tr>
                    <tr>
                        <th>Shipping Details:</th>
                        <td>
                            Akiko Ishijima<br>
                            Level 1/31 Market St, Sydney NSW 2000
                            Australia<br>
                            +61 41234 5678
                        </td>
                    </tr>
                    <tr>
                        <th>Additional Information:</th>
                        <td>-</td>
                    </tr>
                </table>

                <button type="button" onclick="location.href='orders.php'">← Back</button>
            
            </section>
        </main>
    </div>

    <?php include '../footer.php'; ?>


</body>
</html>
