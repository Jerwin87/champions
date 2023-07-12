<?php

include "../htmls/header.html";
include "../htmls/menu.html";
include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$query_h = "SELECT * FROM heroes JOIN products ON heroes.product_ref=products.product_ref WHERE products.collected = 1";
$heroes = $conn->query($query_h);
$herocount = $heroes->num_rows;

$query_v = "SELECT * FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.scenario = 1";
$villains = $conn->query($query_v);
$villaincount = $villains->num_rows;

$query_aspects = "SELECT * FROM aspects";
$aspects = $conn->query($query_aspects);
$aspectcount = $aspects->num_rows;

$query_modular = "SELECT * FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.modular = 1";
$encounters = $conn->query($query_modular);
$encountercount = $encounters->num_rows;

?>
<h1>Neues Spiel eintragen</h1>

<form action="../src/eintragen.php" method="post">

    <!-- Datum auswählen -->

    <input type="date" name="date" value="date" id="dateToday">
    <br>

    <!-- Held auswählen -->
    
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
    <br>

    <!-- Aspekt(e) auswählen -->

    <select id="aspect_1" name="aspect">
        <option value="">Aspekt</option>
        <?php
        while ($row = $aspects->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["aspect"] ?>"><?php echo $row["aspect"] ?></option>
            <?php
        }
        ?>
    </select>

    <select hidden id="aspect_2" name="aspect_2">
        <option value="">Aspekt</option>
        <?php
        $aspects->data_seek(0);
        while ($row = $aspects->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["aspect"] ?>"><?php echo $row["aspect"] ?></option>
            <?php
        }
        ?>
    </select>
    <br>
    <!-- Schwierigkeitsgrad -->
    Schwierigkeit:
    <select name="difficulty">
        <option value="standard">Standard</option>
        <option value="expert">Experte</option>
        <option value="heroic">Heroisch</option>
    </select>
    <br>
    gegen
    <br>
    <!-- Szenarioname eintragen -->

    <select name="villain_id">
        <option value="">Scenario auswählen</option>
        <?php
        while ($row = $villains->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["set_id"] ?>"><?php echo $row["set_name"] ?></option>
            <?php
        }
        ?>
    </select>
    <br>
    <!-- Modulare sets -->

    <?php
    $x = 1;
    while ($x <= 7) {
        $set_num = "encounter_set_" . $x;
        ?>
        <select name="<?php echo $set_num ?>">
            <option value="">Modulare Sets</option>
            <?php
            while ($row = $encounters->fetch_assoc()) {
                ?>
                <option value="<?php echo $row["set_id"] ?>"><?php echo $row["set_name"] ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        $encounters->data_seek(0);
        $x++;
    }
    ?>
    <br>
    <!-- Ergebniss eintragen -->

    <label class="collection_button_2">
        <input type="checkbox" id="game_checkbox" name="result" value=1>
        <span id="checkmark_2">
            <label id="result_label">Verloren</span>
    </label>
    <br>
    <!-- Alles abschicken -->

    <input class="confirm_button" type="submit" value="Eintragen">


</form>
<?php include "../htmls/footer.html"
    ?>
<script src="../scripts/jquery.js" type="text/javascript"></script>
<script src="../scripts/eintragen.js" type="text/javascript"></script>
