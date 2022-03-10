$('.datetimepicker').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    },
    locale: 'cs'
});

$("#newCollaboratorForm").on("submit", function(e) {
    e.preventDefault();
    var collaboratorUsername = $('#collaboratorId').val();
    var begin = $('#begin').val();
    var expiry = $('#expiry').val();
    var idCollaboration = $("#idCollaboration").val();

    if (collaboratorUsername.length===0) {
        console.log("nechapu");
        $("#errorMsg").html("Musíte vybrat spolupracovníka");
    } else {

        var request2 = $.ajax({
            url: "/ajax/insertCollaborator.php",
            method: "POST",
            data: {collaborator: collaboratorUsername, begin: begin, expiry: expiry, idCollaboration: idCollaboration},
            dataType: "html"
        });

        request2.done(function (msg) {
            $("#collaboratorTableHere").html(msg);
            $("#datatableCollabolators").DataTable({
                "pagingType": "full_numbers",
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Hledat spolupracovníka"
                }
            });
            $("#collaborator").modal("hide");
        });


        request2.fail(function (jqXHR, textStatus) {
            console.log("Chyba vkladani spolupracovnika: " + textStatus);
        });
    }
});

$("#datatableCollabolators").DataTable({
    "pagingType": "full_numbers",
    responsive: true,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Hledat spolupracovníka"
    }
});

$("#datatableCollabolatorsForMe").DataTable({
    "pagingType": "full_numbers",
    responsive: true,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Hledat spolupracovníka"
    }
});

$(document).on('click','.remove-collaboration',function() {

    var id = $(this).attr('id-collaboration');
    var token = $(this).attr("token");

    var request2 = $.ajax({
        url: "/ajax/deleteCollaboration.php",
        method: "POST",
        data: {id: id, token: token},
        dataType: "html"
    });

    request2.done(function (msg) {
        swal(
            'Spolupráce smazána',
            null,
            'success'
        );
        $('#idCollaboration' + id).remove();
    });

    request2.fail(function (jqXHR, textStatus) {
        swal(
            'Chyba při zpracování požadavku.',
            null,
            'error'
        );
    });
});

$(document).on('click','.edit-collaboration',function() {
    console.log("opened");
    $("#collaboratorId").val($(this).attr('collaborator-username'));
    $("#expiry").val($(this).attr("collaboration-expiry"));
    $("#begin").val($(this).attr("collaboration-begin"));
    $("#idCollaboration").val($(this).attr("id-collaboration"));
    setTimeout(() => {
    $('.selectpicker').selectpicker('refresh');
    }, 300);
    console.log("edit");
});

$("#newCollaborator").click(function() {
    $("#collaboratorId").val("");
    $("#expiry").val("");
    $("#begin").val("");
    $("#idCollaboration").val("neni");
    setTimeout(() => {
        $('.selectpicker').selectpicker('refresh');
    }, 300);
});

$('[data-toggle="tooltip"]').tooltip();