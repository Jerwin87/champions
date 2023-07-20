<?php

include "../data/mysqlconnect.php";

session_start();

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$villain = $_POST["villain"];
$villain_id = $_POST["villain_id"];

$query_modular = "SELECT set_id, set_name FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.modular = 1";
$encounters = $conn->query($query_modular);
$encountercount = $encounters->num_rows;

$query_scenario = "SELECT scenarios.set_id, encounter_sets.set_name FROM scenarios JOIN encounter_sets USING(set_id) WHERE scenario_id=$villain_id";
$scenarios = $conn->query($query_scenario);
$scenariocount = $scenarios->num_rows;

echo "<br>";
echo "Modulare Sets";
echo "<br>";

$mod_count = 0;
while ($row_set = $scenarios->fetch_assoc()) {
    $mod_count++;
    ?>
    <select name="<?php echo $mod_count?>">
        <option value="<?php echo $row_set['set_id'] ?>"><?php echo $row_set['set_name'] ?></option>
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
}

$_SESSION['mod_count'] = $mod_count;

?>