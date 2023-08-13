<?php
include "../htmls/header.html";
include "../data/mysqlconnect.php";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$product_query = "SELECT * FROM products";
$products = $conn->query($product_query);
$productnum = $products->num_rows;

while ($row = $products->fetch_assoc()) {
    $product = $row["product_id"];
    if (isset($_POST["$product"])) {
        $query = "UPDATE products SET collected = 1 WHERE products.product_id = $product";
    } else {
        $query = "UPDATE products SET collected = 0 WHERE products.product_id = $product";
    }
    $conn->query($query);
}

echo "<br> Sammlung aktualisiert";