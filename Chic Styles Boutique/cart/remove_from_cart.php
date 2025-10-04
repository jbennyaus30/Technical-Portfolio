<?php

require_once '../db_connection.php';
session_start();

$data = explode("&", $_SERVER["QUERY_STRING"]);
$productID = $data[0];
$sizeID = $data[1];

$query  = "DELETE FROM CartItems 
           WHERE CartItems.UserID=" . $_SESSION["user_id"] . 
           " AND CartItems.ProductID=" . $productID .
           " AND CartItems.ProductSize=" . $sizeID;
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->close();

echo "Removed from cart";