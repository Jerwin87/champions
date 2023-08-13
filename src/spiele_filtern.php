<?php
include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$query_h = "SELECT * FROM heroes JOIN products ON heroes.product_ref=products.product_ref WHERE products.collected = 1";
$heroes = $conn->query($query_h);

?>
    <select name="hero_id" id="hero_select">
        <option value="">Held auswählen</option>
        <?php
        while ($row = $heroes->fetch_assoc()) {
            // Unterscheidung ob es ein Alter Ego gibt, oder nicht, wenn nicht, kein leere Klammern anzeigen
            if (strlen($row["alter_ego"]) > 0) {
                ?>
                <option value="<?php echo $row["hero_id"] ?>"><?php echo $row["hero_name"] . " (" . $row["alter_ego"] . ")" ?>
                </option>
                <?php
            } else {
                ?>
                <option value="<?php echo $row["hero_id"] ?>"><?php echo $row["hero_name"] ?></option>
                <?php
            }
        }
        ?>
    </select>

<?php
?>