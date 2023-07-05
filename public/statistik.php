<?php
include "../htmls/header.html";
include "../htmls/menu.html";
include "../data/mysqlconnect.php";
?>
<h1>Spiele</h1>
<?php

$conn = new mysqli($servername, $username, $password, $database);

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
include "../htmls/footer.html"
    ?>
<script src="" async defer></script>