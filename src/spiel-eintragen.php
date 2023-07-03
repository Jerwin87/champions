<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Neues Spiel eintragen</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $database = "champions.db";

    $conn = new mysqli($servername, $username, "", $database);

    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_h = "SELECT * FROM heroes";
    $heroes = $conn->query($query_h);
    $herocount = $heroes->num_rows;

    $query_v = "SELECT * FROM scenarios";
    $villains = $conn->query($query_v);
    $villaincount = $villains->num_rows;

    include "header.php";
    include "menu.php";
    ?>
    <h1>Neues Spiel eintragen</h1>

    <form action="eintragen.php" method="post">
        <select name="hero_id">
            <option value="">Held auswählen</option>
            <?php
            if ($heroes->num_rows > 0) {
                while ($row = $heroes->fetch_assoc()) {
                    if (strlen($row["alter_ego"]) > 0) {
                    ?>
                    <option value="<?php echo $row["hero_id"] ?>"><?php echo $row["hero_name"] . " (" . $row["alter_ego"] . ")" ?></option>
                    <?php
                }
                else {
                    ?>
                    <option value="<?php echo $row["hero_id"] ?>"><?php echo $row["hero_name"] ?></option>
                    <?php 
                }
            }
            } else {
                echo "Keine Daten erhalten";
            }
            ?>
        </select>
        schlägt
        <select name="villain_id">
            <option value="">Scenario auswählen</option>
            <?php
            if ($villains->num_rows > 0) {
                while ($row = $villains->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row["scenario_id"] ?>"><?php echo $row["scenario_name"] ?></option>
                    <?php
                }
            } else {
                echo "Keine Daten erhalten";
            }
            ?>
        </select>
        <input type="submit" value="Eintragen">
    </form>
    <?php include "footer.php"
        ?>
    <script src="" async defer></script>
</body>

</html>