$("document").ready(function () {

    // Ergebnislabel verändern
    $("#game_checkbox").change(function () {
        if ($(this).is(":checked")) {
            $("#result_label").html("Gewonnen");
        }
        else {
            $("#result_label").html("Verloren");
        }
    });

    // 2 Aspektfelder anzeigen wenn Spider-Women, keines wenn Adam Warlock
    $("#hero_select").change(function () {
        var hero = this.value;
        if (hero == 13) {
            $("#aspect_1").show();
            $("#aspect_2").show();
        }
        else if (hero == 25) {
            $("#aspect_1").hide();
            $("#aspect_2").hide();
        }
        else if (hero != 13) {
            $("#aspect_1").show();
            $("#aspect_2").hide();
        };
    });

    // Schwierigkeitsmodule auswählen
    $(".radio").change(function () {
        if ($("#her").is(":checked")) {
            $("#exp_set").show();
            $("#heroic_score").show();
        }
        else if ($("#exp").is(":checked")) {
            $("#exp_set").show();
            $("#heroic_score").hide();
        }
        else if ($("#std").is(":checked")) {
            $("#exp_set").hide();
            $("#heroic_score").hide();
        }
    });

    // Scenario automatisch ausfüllen und nur die entsprechenden Module anzeigen
    $("#villain").change(function () {
        var villain = $("#villain option:selected").text();
        var villain_id = $("#villain option:selected").val();
        $("#encounterSets").load("../src/get_scenario.php", {
            villain: villain,
            villain_id : villain_id
        });
    });

});

document.getElementById("dateToday").valueAsDate = new Date();
