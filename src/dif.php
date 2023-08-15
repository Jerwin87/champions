<?php

include "../data/mysqlconnect.php";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$dif = $_POST["dif"];

$query_h = "SELECT * FROM heroes";
$heroes = $conn->query($query_h);

$villains = $conn->query("SELECT * FROM encounter_sets WHERE scenario=1");
$villain_num = $villains->num_rows;

$win_numbers = [];

if ($dif != "") {
    $dif = "AND games.difficulty='" . $_POST["dif"] . "'"; 
}


while ($row = $heroes->fetch_assoc()) {
    $hero_id = $row['hero_id'];
    $won_games = $conn->query("SELECT * FROM games JOIN encounter_sets ON (games.villain_id=encounter_sets.set_id) WHERE games.hero_id=$hero_id $dif AND games.win=1 GROUP BY villain_id");
    $count = $won_games->num_rows;
    if ($count > 0) {
        if (strlen($row["alter_ego"]) > 0) {
            $hero_name = $row["hero_name"] . " (" . $row["alter_ego"] . ")";
        } else {
            $hero_name = $row["hero_name"];
        }
        $win_numbers[$hero_name] = $count;
    }
}

arsort($win_numbers);
echo "<table class='fortschritt'>";

foreach ($win_numbers as $key => $value) {
    $prozent = round(($value/$villain_num) * 100);
    echo "<tr>";
    echo "<td>" . $key . "</td>";
    echo "<td>" . "<progress value='". $prozent . "' max='100'></progress>" . "</td>";
    echo "<td>" . "(" . $value . "/" . $villain_num . ")". "</td>"; 
    echo "</tr>";
}
echo "</table>";


?>