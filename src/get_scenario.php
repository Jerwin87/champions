<?php

include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$villain = $_POST["villain"];

echo "<br>";
echo "Modulare Sets";
echo "<br>";

$query_modular = "SELECT * FROM encounter_sets JOIN products ON encounter_sets.product_ref=products.product_ref WHERE products.collected = 1 AND encounter_sets.modular = 1";
$encounters = $conn->query($query_modular);
$encountercount = $encounters->num_rows;

$query_scenario = "SELECT * FROM scenarios WHERE scenario_name='$villain'";
$scenarios = $conn->query($query_scenario);
$scenariocount = $scenarios->num_rows;

$row_set = $scenarios->fetch_assoc();

$x = 1;
while ($x <= 10) {
    $hidden = "";
    $set_num = "encounter_set_" . $x;
    $mod_set = "modular_set_" . $x;
    $mod_name = $row_set[$mod_set];
    $module_query = "SELECT * FROM encounter_sets WHERE set_name='$mod_name'";
    $mod_query = $conn->query($module_query);
    $mod = $mod_query->fetch_assoc();
    $mod_id = $mod["set_id"];

    ?><select id=<?php echo $set_num?> name=<?php echo $set_num?> <?php echo $hidden?>>;
    <?php if ($mod_name == '') {
            ?> <option value='0'></option> <?php
        } else {
            ?> <option value="<?php echo $mod_id ?>"><?php echo $mod_name?></option> <?php
        }; 
        while ($row = $encounters->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["set_id"] ?>"><?php echo $row["set_name"] ?></option>
            <?php
        }
    ?></select><?php
    $encounters->data_seek(0);
    $x++;
}

?>