$("document").ready(function () {

    $("#game_checkbox").change(function () {
        if ($(this).is(":checked")) {
            $("#result_label").html("Gewonnen");
        }
        else {
            $("#result_label").html("Verloren");
        };
    });


});
