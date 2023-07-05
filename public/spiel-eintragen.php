<?php

include "../htmls/header.html";
include "../htmls/menu.html";
include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$query_h = "SELECT * FROM heroes";
$heroes = $conn->query($query_h);
$herocount = $heroes->num_rows;

$query_v = "SELECT * FROM scenarios";
$villains = $conn->query($query_v);
$villaincount = $villains->num_rows;

$query_aspects = "SELECT * FROM aspects";
$aspects = $conn->query($query_aspects);
$aspectcount = $aspects->num_rows;

$query_modular = "SELECT * FROM encounter_sets WHERE modular = 1";
$encounters = $conn->query($query_modular);
$encountercount = $encounters->num_rows;

?>
<h1>Neues Spiel eintragen</h1>

<form action="../src/eintragen.php" method="post">

    <!-- Datum auswählen -->

    <input type="date" name="date" value="date">

    <!-- Held auswählen -->
    <select name="hero_id">
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

    <!-- Aspekt(e) auswählen -->

    <select name="aspect">
        <option value="">Aspekt</option>
        <?php
        while ($row = $aspects->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["aspect"] ?>"><?php echo $row["aspect"] ?></option>
            <?php
        }
        ?>
    </select>

    <select name="aspect_2">
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

    <!-- Schwierigkeitsgrad -->

    <select name="difficulty">
        <option value="standard">Standard</option>
        <option value="expert">Experte</option>
        <option value="heroic">Heroisch</option>
    </select>

    gegen

    <!-- Szenarioname eintragen -->

    <select name="villain_id">
        <option value="">Scenario auswählen</option>
        <?php
        while ($row = $villains->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["scenario_id"] ?>"><?php echo $row["scenario_name"] ?></option>
            <?php
        }
        ?>
    </select>

    <!-- Modulare sets -->

    <?php
    $x = 1;
    while ($x <= 7) {
        $set_num = "encounter_set_" . $x;
        ?>
        <select name="<?php echo $set_num?>">
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

    <!-- Ergebniss eintragen -->

    Gewonnen?
    <input type="checkbox" name="result" value=1>


    <!-- Alles abschicken -->

    <input type="submit" value="Eintragen">


</form>
<?php include "../htmls/footer.html"
    ?>
<script src="" async defer></script>