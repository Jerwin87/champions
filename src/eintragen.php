<?php
include "../htmls/header.html";
include "../data/mysqlconnect.php";

session_start();

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$game_id = $_SESSION['game_id'];
$date = date('Y-m-d', strtotime($_POST["date"]));
$hero_id = $_POST["hero_id"];
$villain_id = $_POST["villain_id"];
$aspect_ids = array($_POST["aspect"], $_POST["aspect_2"], $_POST["aspect_3"], $_POST["aspect_4"]);
$difficulty = $_POST["difficulty"];
$heroic = $_POST["heroic_score"];
$custom = $_POST["custom"] == 1 ? 1 : 0;
$result = $_POST["result"] == 1 ? 1 : 0;
$camp = $_POST['camp'] == 1 ? 1 : 0;
$precon = $_POST['precon'] == 1 ? 1 : 0;

$mod_count = $_SESSION["mod_count"];
$std_set = $_POST['standard'];
$exp_set = $_POST['expert'];

mysqli_begin_transaction($conn);

try {
    $query = "INSERT INTO games (game_id, date, hero_id, villain_id, 
                difficulty, heroic, custom, win, campaign, precon) VALUES 
                ($game_id, '$date', $hero_id, $villain_id, 
                '$difficulty', $heroic, $custom, $result, $camp, $precon)";

    if ($conn->query($query) === TRUE) {
        echo "Spiel erfolgreich eingetragen<br>";
    } else {
        echo "Fehler: " . $eintrag . "<br>" . $conn->error;
    }

    for ($x = 1; $x <= $mod_count; $x++) {
        $set_id = $_POST["$x"];
        $query = "INSERT INTO games_config VALUES
                ($game_id, $set_id)";
        if ($conn->query($query) === TRUE) {
            echo "Set erfolgreich eingetragen<br>";
        } else {
            echo "Fehler: " . $eintrag . "<br>" . $conn->error;
        }
    }

    $query = "INSERT INTO games_config VALUES
                ($game_id, $std_set)";
    if ($conn->query($query) === TRUE) {
        echo "Standard erfolgreich eingetragen<br>";
    } else {
        echo "Fehler: " . $eintrag . "<br>" . $conn->error;
    }

    if ($exp_set > 0) {
        $query = "INSERT INTO games_config VALUES
    ($game_id, $exp_set)";
        if ($conn->query($query) === TRUE) {
            echo "Expert erfolgreich eingetragen<br>";
        } else {
            echo "Fehler: " . $eintrag . "<br>" . $conn->error;
        }
    }

    foreach ($aspect_ids as &$value) {
        if ($value > 0) {
            $query = "INSERT INTO aspect_config VALUES
                ($game_id, $value)";
            if ($conn->query($query) === TRUE) {
                echo "Aspekt erfolgreich eingetragen<br>";
            } else {
                echo "Fehler: " . $eintrag . "<br>" . $conn->error;
            }
        }
    }
    mysqli_commit($conn);
} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($conn);

    throw $exception;
}

include "footer.php"
    ?>