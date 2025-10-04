<?php

require_once '../db_connection.php';
session_start();

$data = explode("&", $_SERVER["QUERY_STRING"]);
$productID = $data[0];
$sizeID = $data[1];
$newAmount = $data[2];

$query = 'UPDATE CartItems SET ProductAmount=' . $newAmount . 
         ' WHERE CartItems.UserID=' . $_SESSION["user_id"] .
         ' AND CartItems.ProductID=' . $productID .
         ' AND CartItems.ProductSize=' .$sizeID;

$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->close();

echo " Updated cart";