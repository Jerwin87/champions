<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Statistik</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php
    include "header.php";
    include "menu.php";
    ?>
    <h1>Statistik</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $database = "champions.db";

    $conn = new mysqli($servername, $username, "", $database);

    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT games.game_id, heroes.hero_name, scenarios.scenario_name FROM games JOIN heroes ON games.hero_id = heroes.hero_id JOIN scenarios ON games.scenario_id = scenarios.scenario_id ORDER BY game_id";
    $games = $conn->query($query);
    if ($games->num_rows > 0) {
        while ($row = $games->fetch_assoc()) {
            echo "Spiel " . $row["game_id"] . ": " . $row["hero_name"] . " schlägt " . $row["scenario_name"] . "<br>";
        }
    } else {
        echo "Nichts anzuzeigen";
    }
    ?>
    <?php
    include "footer.php"
        ?>
    <script src="" async defer></script>
</body>

</html>