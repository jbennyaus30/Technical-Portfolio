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

            <section id="orders">
                <h3>Orders</h3>

                <ul>
                    <li>
                        <div class="order-thum">
                            <figure>
                                <img src="../img/shop/DR8.png" alt="">
                            </figure>
                            <figure>
                                <img src="../img/shop/AC8.png" alt="">
                            </figure>
                        </div>
                        <div class="order-summary">
                            <table>
                                <tr>
                                    <th>Order No.</th>
                                    <td>00003</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>12 Dec 2022</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td class="shipped">Shipped</td>
                                    <!-- <td class="processing">Processing</td> -->
                                    <!-- <td class="pending">Pending</td> -->
                                </tr>
                            </table>
                            <button type="button" onclick="location.href='order-detail.html'">View Order →</button>  
                        </div>      
                    </li>
                </ul>
            </section>
        
        </main>
    </div>

    <?php include '../footer.php'; ?>


</body>
</html>
