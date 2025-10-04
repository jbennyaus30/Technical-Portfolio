<?php

session_start();
$isUserLoggedIn = isset($_SESSION['user_id']);
$stripeSecretKey = $_ENV["STRIPE_KEY"];
require_once 'stripe-php/init.php';
require_once '../db_connection.php';
require_once "fetch_cart.php";

if ($stripeSecretKey == "") {
    echo "STRIPE SECRET KEY NOT CONFIGURED";
    exit();
}

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$row_num = 0;
$total_price = 0;
$line_items = [];
while ($row_num < $cart_items_result->num_rows) {
    $row = $cart_items_result->fetch_assoc();

    $stripe_product_name = $row["ProductName"];
    // If product has a size then append it to the name
    // E.g. Maxi Dress size small will show as "Maxi Dress (Small)"
    // on the Stripe checkout page
    if ($row["ProductSize"] != 5) {
      $stripe_product_name = $stripe_product_name . " (".$row["SizeName"].")";
    }

    // add to line_items
    array_push($line_items, 
    [
        "price_data" => [
            'currency' => 'aud',
            'product_data' => [
              'name' => $stripe_product_name,
            ],
            'unit_amount' => $row["ProductPrice"]*100,
        ],
        'quantity' => $row["ProductAmount"],
    ]);
    $row_num++;
}
if (!$line_items) {
  echo "Cart is empty";
  exit;
}
                  
$DOMAIN = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $line_items,
  'mode' => 'payment',
  'success_url' => $DOMAIN . '/cart/thankyou.php',
  'cancel_url' => $DOMAIN . '/cart/index.php',
  'billing_address_collection' => 'required',
  'shipping_address_collection' => [
    'allowed_countries' => ['AU'],
  ],
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);

$conn->close();