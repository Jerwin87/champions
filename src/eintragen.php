<?php
include "../htmls/header.html";
include "../htmls/menu.html";
include "../data/mysqlconnect.php";


$conn = new mysqli($servername, $username, $password, $database);

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