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
    include "header.php";
    include "menu.php";

    $servername = "localhost";
    $username = "root";
    $database = "champions.db";

    $conn = new mysqli($servername, $username, "", $database);

    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

    $hero_id = $_POST["hero_id"];
    $villain_id = $_POST["villain_id"];

    $query = "INSERT INTO games (game_id, hero_id, scenario_id) VALUES (NULL, $hero_id, $villain_id)";
    if ($conn->query($query) === TRUE) {
        echo "<h2>Spiel erfolgreich eingetragen</h2>";
    } else {
        echo "Fehler: " . $eintrag . "<br>" . $conn->error;
    }
    include "footer.php"
        ?>
    <script src="" async defer></script>
</body>

</html>
