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

<form action="../src/sammlung_anpassen.php" method="Post">
    <?php

    $set_types = array(
        "core_set" => "Grundspiel",
        "campaign" => "Kampagne",
        "hero" => "Helden",
        "scenario" => "Szenarien"
    );

    foreach ($set_types as $type => $name) {

        ?><u><?php echo $name . "<br>";?></u><?php
        $product_query = "SELECT * FROM products WHERE $type=1";
        $products = $conn->query($product_query);
        $productnum = $products->num_rows;

        while ($row = $products->fetch_assoc()) {
            if ($row["collected"]) {
                $checked = "checked";
            } else {
                $checked = ""; }
                ?>
                <label class="collection_button">
                    <input type="checkbox" <?php echo $checked?> value="<?php echo $row["product_id"] ?>" name="<?php echo $row["product_id"] ?>" >
                    <span class="checkmark"> <span class="collection_label"><?php echo $row["product_name"] ?></span><span>
                </label><br>
                <?php
        }
        echo "<br>";
    }
    ?>

        <input type="submit" value="Sammlung aktualisieren">

        <?php include "../htmls/footer.html"
            ?>
        <script src="" async defer></script>