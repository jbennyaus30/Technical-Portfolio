<?php 

require_once "../db_connection.php";

// Get products
if ($_SERVER["QUERY_STRING"] == "") {
    $db_query = "SELECT * FROM Products";
} else {
    $db_query = 'SELECT * 
                FROM ProductCategories
                INNER JOIN Products 
                    ON ProductCategories.ProductID = Products.ProductID 
                WHERE ProductCategories.CategoryID = ' . $_SERVER["QUERY_STRING"];
}

$stmt = $conn->prepare($db_query);
$stmt -> execute();
$products_result = $stmt->get_result();
$stmt->close();

$row_num = 0;
$products = [];
while ($row_num < $products_result->num_rows) {
    $row = $products_result->fetch_assoc();
    array_push($products, $row);
    $row_num++;
}
header('Content-Type: application/json');
echo json_encode($products);