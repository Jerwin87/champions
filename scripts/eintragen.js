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
            $("#aspect_2").show();
        }
        else if (hero == 25) {
            $("#aspect_1").hide();
            $("#aspect_2").hide();
        }
        else if (hero != 13 ) {
            $("#aspect_1").show();
            $("#aspect_2").hide();
        };
    });

});

document.getElementById("dateToday").valueAsDate = new Date();
