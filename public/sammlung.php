<?php

include "../htmls/header.html";
include "../htmls/menu.html";

include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<h1>Sammlung bearbeiten</h1>

<?php
$product_query="SELECT * FROM products";
$products=$conn->query($product_query);
$productnum=$products->num_rows;

?>
<form action="../src/sammlung_anpassen.php" method="Post">
<?php

while ($row=$products->fetch_assoc()) {
    if ($row["collected"]) {
    ?>
    <input type="checkbox" value="<?php echo $row["product_id"]?>" name="<?php echo $row["product_id"]?>" checked>
    <label for="<?php echo $row["product_id"]?>"><?php echo $row["product_name"]?><br> 
    <?php 
    }
    else {
        ?>
        <input type="checkbox" value="<?php echo $row["product_id"]?>" name="<?php echo $row["product_id"]?>">
        <label for="<?php echo $row["product_id"]?>"><?php echo $row["product_name"]?><br> 
        <?php  
    }
}
?>

<input type="submit" value="Sammlung aktualisieren">

<?php include "../htmls/footer.html"
    ?>
<script src="" async defer></script>