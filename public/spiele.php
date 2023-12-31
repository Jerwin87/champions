<?php

include "../htmls/header.html";
include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset(("utf8"));

$query = "SELECT * FROM games JOIN heroes ON games.hero_id=heroes.hero_id JOIN encounter_sets ON games.villain_id=encounter_sets.set_id ORDER BY game_id DESC";
$games = $conn->query($query);
$num_games = $games->num_rows;
$aspects = ['unbekannt', 'Aggression', 'Führung', 'Gerechtigkeit', ' Schutz'];


?>

<h1>Spiele</h1>

<button id="filter_button">Filter hinzufügen</button>
<br>
<div id="filter_form">
</div>

<!-- Tabelle anzeigen -->
<table class="result">
    <tr>
        <th>Spiel</th>
        <th>Datum</th>
        <th>Held</th>
        <th>Aspekt(e)</th>
        <th>Schwierigkeit</th>
        <th>Szenario</th>
        <th>Modulare Sets</th>
        <th>Ergebnis</th>
    </tr>
    <?php
    $y = $num_games;
    while ($row = $games->fetch_assoc()) {
        $game_id = $row['game_id'];
        $aspects = "";
        $query = "SELECT * FROM aspects JOIN aspect_config USING(aspect_id) WHERE game_id=$game_id";
        $result = $conn->query($query);
        $v = 0;
        while ($aspect_row = $result->fetch_assoc()) {
            $h = $v > 0 ? " / " : "";
            $aspects = $aspects . $h . $aspect_row['aspect'];
            $v++;
            }
        // $aspect = $row['aspect_2'] != 0 ? $aspects[$row['aspect']] . " / " . $aspects[$row['aspect_2']] : $aspects[$row['aspect']];
        $modulars = "";
        $query = "SELECT * FROM games_config JOIN encounter_sets USING(set_id) WHERE game_id=$game_id ";
        $result = $conn->query($query);
        $v = 0;
        while ($set_row = $result->fetch_assoc()) {
            $h = $v > 0 ? " / " : "";
            if ($set_row["set_id"] == 14 || $set_row["set_id"] == 15 || $set_row["set_id"] == 101 || $set_row["set_id"] == 102) {
            } else {
                $modulars = $modulars . $h . $set_row['set_name'];
                $v++;
            }
        }
        if (strlen($row["alter_ego"]) > 0) {
            $hero_name = $row["hero_name"] . " (" . $row["alter_ego"] . ")";
        } else {
            $hero_name = $row["hero_name"];
        }
        $win = $row['win'] ? "Sieg" : "Niederlage";

        echo "<tr>";
        echo "<td>" . $y . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . $hero_name . "</td>";
        echo "<td>" . $aspects . "</td>";
        echo "<td>" . $row['difficulty'] . "</td>";
        echo "<td>" . $row["set_name"] . "</td>";
        echo "<td>" . $modulars . "</td>";
        echo "<td>" . $win . "</td>";
        echo "</tr>";
        $y--;
    }

    ?>
</table>
<?php
include "../htmls/footer.html"
    ?>
<script src="../scripts/jquery.js" type="text/javascript"></script>
<script src="../scripts/spiele-filtern.js" type="text/javascript"></script>