$("#aresSearch").click(function () {
    var data = $("#aresInput").val();

    var request = $.ajax({
        url: "/ajax/getCompanyDetailsFromARES.php",
        method: "GET",
        data: { data: data },
        dataType: "html"
    });
    request.done(function( msg ) {
        $("#resARES").html(msg);
    });

    request.fail(function( jqXHR, textStatus ) {
        $("#resARES").html("Nepodařilo se načíst data z ARES. Chyba: "+textStatus);
    });
});

$("#checkARES").click(function () {
    var name = $("#name").val();
    var ic = $("#ic").val();
    var adresa = $("#address").val();

    var request = $.ajax({
        url: "/ajax/checkCompanyDetailsFromARES.php",
        method: "GET",
        data: { name: name, ic: ic, adresa: adresa },
        dataType: "html"
    });
    request.done(function( msg ) {
        $("#resUpdateARES").html(msg);
    });

    request.fail(function( jqXHR, textStatus ) {
        $("#resUpdateARES").html("Nepodařilo se načíst data z ARES. Chyba: "+textStatus);
    });
});

$(document).keyup(function(event) {
    var input = $("#aresInput");
    if (input.is(":focus") && event.key === "Enter") {
        var data = input.val();

        var request = $.ajax({
            url: "/ajax/getCompanyDetailsFromARES.php",
            method: "GET",
            data: { data: data },
            dataType: "html"
        });
        request.done(function( msg ) {
            $("#resARES").html(msg);
        });

        request.fail(function( jqXHR, textStatus ) {
            $("#resARES").html("Nepodařilo se načíst data z ARES. Chyba: "+textStatus);
        });
    }
});

$(document).on('click','.vyplnit',function() {
    $("#name").val($(this).attr('nazev'));
    $("#address").val($(this).attr("adresa"));
    $("#ic").val($(this).attr("ico"));
    $("#dic").val('CZ'+$(this).attr("ico"));
    $("#aresModal").modal("hide");
});

$(document).on('click','.opravit',function() {
    $("#companyEditForm").submit();
    var name = $("#name").val();
    var ic = $("#ic").val();
    var adresa = $("#address").val();

    var request = $.ajax({
        url: "/ajax/checkCompanyDetailsFromARES.php",
        method: "GET",
        data: { name: name, ic: ic, adresa: adresa },
        dataType: "html"
    });
    request.done(function( msg ) {
        $("#resUpdateARES").html(msg);
    });

    request.fail(function( jqXHR, textStatus ) {
        $("#resUpdateARES").html("Nepodařilo se načíst data z ARES. Chyba: "+textStatus);
    });
});