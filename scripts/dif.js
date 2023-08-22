$("document").ready(function () {

    $(".dif_select, .camp, .precon, .custom").change(function () {
        var dif = $(".dif_select:checked").val();
        var camp = $(".camp:checked").val();
        var precon = $(".precon:checked").val();
        var custom = $(".custom:checked").val();
        $("#schwierigkeit").load("../src/dif.php", {
            dif: dif,
            camp: camp,
            precon: precon,
            custom: custom
        });
    });

});