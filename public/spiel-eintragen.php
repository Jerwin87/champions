<?php

include "../htmls/header.html";
include "../data/mysqlconnect.php";

session_start();
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset(("utf8"));

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

$query_standard = "SELECT * FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.standard = 1";
$standard = $conn->query($query_standard);

$query_expert = "SELECT * FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.expert = 1";
$expert = $conn->query($query_expert);

$query_game_id = "SELECT game_id FROM games ORDER BY game_id DESC";
$game_id_sql = $conn->query($query_game_id);
$row = $game_id_sql->fetch_assoc();
$_SESSION['game_id'] = $row['game_id'] + 1;

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
            <option value="<?php echo $row["aspect_id"] ?>"><?php echo $row["aspect"] ?></option>
            <?php
        }
        ?>
    </select>

    <select hidden id="aspect_2" name="aspect_2">
        <option value="0">Aspekt</option>
        <?php
        $aspects->data_seek(0);
        while ($row = $aspects->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["aspect_id"] ?>"><?php echo $row["aspect"] ?></option>
            <?php
        }
        ?>
    </select>
    <br>
    <!-- Schwierigkeitsgrad -->

    <input type="radio" id="std" class="radio" name="difficulty" value="standard" checked>
    <label for="std">Standard</label>
    <input type="radio" id="exp" class="radio" name="difficulty" value="expert">
    <label for="exp">Experte</label>
    <input type="radio" id="her" class="radio" name="difficulty" value="heroic">
    <label for="her">Heroisch</label>

    <br>
        <select name="standard">
        <?php         
        while ($row = $standard->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["set_id"] ?>"><?php echo $row["set_name"] ?></option>
            <?php
        }
        ?>
        </select>

        <select hidden id="exp_set" name="expert">
        <?php         
        while ($row = $expert->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["set_id"] ?>"><?php echo $row["set_name"] ?></option>
            <?php
        }
        ?>
        </select>

        <select hidden id="heroic_score" name="heroic_score">
            <?php for ($x = 0; $x < 5; $x++) {
                ?>
                <option value="<?php echo $x?>"><?php echo $x ?>
                <?php
            }
            ?>
        </select>
    

    <!-- Zwischenblock -->

    <br>
    <br>
    gegen
    <br>
    <br>

    <!-- Szenarioname eintragen -->

    <select id="villain" name="villain_id">
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

<div id="encounterSets"></div>
    <!-- Modulare sets -->

    <br>
    <!-- Ergebniss eintragen -->

    <label class="collection_button_2">
        <input type="checkbox" id="game_checkbox" name="result" value=1>
        <span id="checkmark_2">
            <label id="result_label">Verloren</span>
    </label>
    <br>
    <label for="custom">Benutzerdefinierte Einstellungen: </label>
    <input type="checkbox" id="custom" name="custom" value=1>
    <br>
    <br>
    <!-- Alles abschicken -->

    <input class="confirm_button" type="submit" value="Eintragen">


</form>
<?php include "../htmls/footer.html"
    ?>
<script src="../scripts/jquery.js" type="text/javascript"></script>
<script src="../scripts/spiel-eintragen.js" type="text/javascript"></script>