$("document").ready(function () {

    $("#filter_button").click(function () {
        $("#filter_form").load("../src/spiele_filtern.php");
    });

});