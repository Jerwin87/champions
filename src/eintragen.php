<?php
include "../htmls/header.html";
include "../htmls/menu.html";
include "../data/mysqlconnect.php";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$date = date('Y-m-d', strtotime($_POST["date"]));
$hero_id = $_POST["hero_id"];
$villain_id = $_POST["villain_id"];
$aspect = $_POST["aspect"];
$aspect_2 = $_POST["aspect_2"];
$difficulty = $_POST["difficulty"];
$std_set = $_POST["standard"];
$exp_set = $_POST["expert"];
$heroic = $_POST["heroic_score"];
$encounter_set_1 = $_POST["encounter_set_1"];
$encounter_set_2 = $_POST["encounter_set_2"];
$encounter_set_3 = $_POST["encounter_set_3"];
$encounter_set_4 = $_POST["encounter_set_4"];
$encounter_set_5 = $_POST["encounter_set_5"];
$encounter_set_6 = $_POST["encounter_set_6"];
$encounter_set_7 = $_POST["encounter_set_7"];
$result = $_POST["result"] == 1 ? 1 : 0; 

$query = "INSERT INTO games 
(game_id, date, hero_id, aspect, aspect_2, difficulty, std_set, exp_set, 
heroic, set_id, 
encounter_set_1, encounter_set_2, encounter_set_3, encounter_set_4, 
encounter_set_5, encounter_set_6, encounter_set_7, win) 
VALUES (NULL, '$date', $hero_id, '$aspect', '$aspect_2', '$difficulty', $std_set, $exp_set, $heroic,
 $villain_id, 
'$encounter_set_1', '$encounter_set_2', '$encounter_set_3', '$encounter_set_4', 
'$encounter_set_5', '$encounter_set_6', '$encounter_set_7', $result)";
if ($conn->query($query) === TRUE) {
    echo "<h2>Spiel erfolgreich eingetragen</h2>";
} else {
    echo "Fehler: " . $eintrag . "<br>" . $conn->error;
}
include "footer.php"
    ?>