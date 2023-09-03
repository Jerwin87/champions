<?php
include "../htmls/header.html";
include "../data/mysqlconnect.php";

?>
<h1>Statistik</h1>
<?php

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<input type="radio" class="dif_select" name="dif_select" value="" >
<label for="all">Alle</label>
<input type="radio" class="dif_select" name="dif_select" value="standard">
<label for="standard">Standard</label>
<input type="radio" class="dif_select" name="dif_select" value="expert" checked>
<label for="expert">Expert</label>
<input type="radio" class="dif_select" name="dif_select" value="heroic">
<label for="heroic">Heroisch</label>
<br>

<p>Kampagne ausschließen: 
<input type="radio" class="camp" name="camp" value=1 checked>
<label for="">Nein</label>
<input type="radio" class="camp" name="camp" value=0>
<label for="">Ja</label> </p>

<p>Nur vorgefertigte Decks anzeigen: 
<input type="radio" class="precon" name="precon" value=0 checked>
<label for="">Nein</label>
<input type="radio" class="precon" name="precon" value=1>
<label for="">Ja</label> </p>

<p>Benutzerdefinierte Modulars ausschließen: 
<input type="radio" class="custom" name="custom" value=1 checked>
<label for="">Nein</label>
<input type="radio" class="custom" name="custom" value=0>
<label for="">Ja</label> </p>
<br>

<div id="schwierigkeit">

<?php

$query_h = "SELECT * FROM heroes";
$heroes = $conn->query($query_h);

$villains = $conn->query("SELECT * FROM encounter_sets WHERE scenario=1");
$villain_num = $villains->num_rows;

$win_numbers = [];

while ($row = $heroes->fetch_assoc()) {
    $hero_id = $row['hero_id'];
    $won_games = $conn->query("SELECT * FROM games JOIN encounter_sets ON (games.villain_id=encounter_sets.set_id) WHERE games.hero_id=$hero_id AND games.difficulty='expert' AND games.win=1 GROUP BY villain_id");
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
</div>
<br>

<?php
include "../htmls/footer.html"
    ?>
<script src="../scripts/jquery.js" type="text/javascript"></script>
<script src="../scripts/dif.js" type="text/javascript"></script>