$("document").ready(function () {

    $(".dif_select").change(function () {
        var dif = $(".dif_select:checked").val();
        $("#schwierigkeit").load("../src/dif.php", {
            dif: dif,
        });
    });

});