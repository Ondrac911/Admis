$("#datatableCompanies").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "order": [[ 0, "desc" ]]
});

$("#datatableFiles").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "columnDefs": [
        { "orderable": false, "targets": [3] }
    ]
});

$("#datatableContacts").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "order": [[ 0, "desc" ]]
});
$("#tableHistory").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "columnDefs": [
        { "orderable": false, "targets": [0,7] }
    ],
    "order": [[ 4, "desc" ]]
});
$("#tableLoginLogs").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "order": [[ 2, "desc" ]]
});
$("#tableUsersOverview").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "order": [[ 0, "asc" ]],
    "pageLength": 50
});

$('[data-toggle="tooltip"]').tooltip();

$('#companyEditForm').submit(function(e) {
    e.preventDefault();
    var name = $("#name").val();
    var address = $("#address").val();
    var ic = $("#ic").val();
    var dic = $("#dic").val();
    var www = $("#www").val();
    var idCompany = $("#idCompany").val();

    var request = $.ajax({
        url: "/ajax/updateCompany.php",
        method: "POST",
        data: { name: name, address: address, ic: ic, dic: dic, www: www, idCompany: idCompany },
        dataType: "html"
    });

    request.done(function( msg ) {
        if (parseInt(msg)!==0) {
            swal(
                'Uloženo',
                'Údaje firmy jsme uložili do databáze.',
                'success'
            );

            if (idCompany === 0) {
                $("#idCompany").val(msg);
            }
        } else {
            swal(
                'Zůstalo to stejné',
                'Nedošlo ke změně záznamu.',
                'question'
            );
        }
    });

    request.fail(function( jqXHR, textStatus ) {
        swal(
            'Chyba',
            'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
            'error'
        );
    });
});

$(document).on('click','.remove-company',function() {
    swal({
        title: 'Opravdu máme firmu smazat?',
        text: 'Odstraněná firma neputuje do koše a není možné ji později obnovit, jedině vytvořit znovu!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano, smazat!',
        cancelButtonText: 'Nechat být'
    }).then((result) => {
        if (result) {

            var idCompany = $(this).attr('id-company');
            var token = $(this).attr("token");
            console.log(idCompany);
            console.log(token);

            var request2 = $.ajax({
                url: "/ajax/deleteCompany.php",
                method: "POST",
                data: { idCompany: idCompany, token: token },
                dataType: "html"
            });

            request2.done(function( msg ) {
                if (msg === "") {
                    swal(
                        'Firma smazána!',
                        null,
                        'success'
                    );
                    $('#company' + idCompany).remove();
                } else {
                    swal(
                        'Nevyšlo to!',
                        'Asi je firma vedena u některého z projektů a tím pádem ji nemůžeme smazat. Je potřeba ji nejprve odebrat od všech projektů.',
                        'question'
                    );
                }
            });


            request2.fail(function( jqXHR, textStatus ) {
                swal(
                    'Chyba při zpracování požadavku.',
                    null,
                    'error'
                );
            });

        }
    });
});

$(document).on('click','.remove-contact',function() {
    swal({
        title: 'Opravdu ho máme smazat?',
        text: 'Odstraněný kontakt bude smazán z databáze. Můžete jej však později opět vytvořit jako nový kontakt.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano, smazat!',
        cancelButtonText: 'Nechat být'
    }).then((result) => {
        if (result) {

            var idContact = $(this).attr('id-contact');
            var token = $(this).attr("token");
            console.log(idContact);
            console.log(token);

            var request2 = $.ajax({
                url: "/ajax/deleteContact.php",
                method: "POST",
                data: { idContact: idContact, token: token },
                dataType: "html"
            });

            request2.done(function( msg ) {
                swal(
                    'Kontakt smazán!',
                    null,
                    'success'
                );
                $('#idContact'+idContact).remove();
            });

            request2.fail(function( jqXHR, textStatus ) {
                swal(
                    'Chyba při zpracování požadavku.',
                    null,
                    'error'
                );
            });

        }
    });
});

$(document).on('click','.remove-file-type',function() {
    swal({
        title: 'Tento typ již nepůjde nahrávat',
        text: 'Chcete odebrat možnost nahrávat tento typ souborů?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano',
        cancelButtonText: 'Nechat být'
    }).then((result) => {
        if (result) {

            var idFileType = $(this).attr('id-file-type');
            var token = $(this).attr("token");
            console.log(idFileType);
            console.log(token);

            var request2 = $.ajax({
                url: "/ajax/deleteFileType.php",
                method: "POST",
                data: { idContact: idFileType, token: token },
                dataType: "html"
            });

            request2.done(function( msg ) {
                swal(
                    'Podpora typu souborů odebrána!',
                    null,
                    'success'
                );
                $('#fileType'+idFileType).remove();
            });

            request2.fail(function( jqXHR, textStatus ) {
                swal(
                    'Chyba při zpracování požadavku.',
                    null,
                    'error'
                );
            });

        }
    });
});

$(document).on('click','.edit-contact',function() {
    $("#contactName").val($(this).attr('contact-name'));
    $("#email").val($(this).attr("contact-email"));
    $("#phone").val($(this).attr("contact-phone"));
    $("#idContact").val($(this).attr("contact-id"));
});

$("#newContact").click(function() {
    $("#contactName").val("");
    $("#email").val("");
    $("#phone").val("");
    $("#idContact").val("neni");
});

$(document).on('click','.edit-file-type',function() {
    // var pfdLink = $(this).attr('file') + '&preview=TRUE';
    // $("#hiddenProjectId").val($(this).attr('project-id'));
    // PDFObject.embed(pfdLink, "#pdfVersionHere");
    $("#fileTypeExtension").val($(this).parent('td').parent('tr').children('.ext').html());
    $("#fileTypeDescription").val($(this).parent('td').parent('tr').children('.desc').html());
    $("#fileMIME").val($(this).parent('td').parent('tr').children('.mime').html());
    $("#hiddenFileTypeId").val($(this).parent('td').parent('tr').attr('id-file-type'));
    $("#filesTypesModal").modal("show");
});

$(document).on('click','.new-file-type',function() {
    // var pfdLink = $(this).attr('file') + '&preview=TRUE';
    // $("#hiddenProjectId").val($(this).attr('project-id'));
    // PDFObject.embed(pfdLink, "#pdfVersionHere");
    $("#fileTypeExtension").val('');
    $("#fileTypeDescription").val('');
    $("#fileMIME").val('');
    $("#hiddenFileTypeId").val('neni');
    $("#filesTypesModal").modal("show");
});

$('#fileTypeExtension').blur(function(e) {
    var ext = $("#fileTypeExtension").val();

    if ($('#fileMIME').val() === '') {
        var request = $.ajax({
            url: "/ajax/getFileTypeMime.php",
            method: "POST",
            data: {data: ext},
            dataType: "html"
        });

        request.done(function (msg) {
            $('#fileMIME').val(msg)
        });
    }

});

$('#saveFileType').click(function(e) {
    var id = $("#hiddenFileTypeId").val();
    var ext = $("#fileTypeExtension").val();
    var desc = $("#fileTypeDescription").val();
    var mime = $("#fileMIME").val();
    var hiddenToken = $("#hiddenToken").val();

    if ($('#fileMIME').val() !== '' && $('#fileTypeExtension').val() !== '') {
        var request = $.ajax({
            url: "/ajax/updateFileType.php",
            method: "POST",
            data: {idDocType: id, name: mime, description: desc, extension: ext, token: hiddenToken},
            dataType: "html"
        });

        request.done(function( msg ) {
            if (parseInt(msg)!==0 && msg !=='') {
                swal(
                    'Uloženo',
                    'Parametry typu souborů jsme uložili do datatbáze.',
                    'success'
                );

                $("#filesTypesModal").modal("hide");

                var request2 = $.ajax({
                    url: "/ajax/getFileTypesTable.php",
                    method: "POST",
                    dataType: "html"
                });

                request2.done(function( msg ) {
                    $("#filesTypeTable").html(msg);
                    $("#datatableFiles").DataTable({
                        "language": {
                            "url": "/dashboard/assets/js/plugins/locale/Czech.json"
                        },
                        "order": [[ 0, "asc" ]]
                    });
                });

                request2.fail(function( jqXHR, textStatus ) {
                    swal(
                        'Chyba',
                        'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
                        'error'
                    );
                });
            } else {
                if (parseInt(msg)===0) {
                    swal(
                        'Zůstalo to stejné',
                        'Nedošlo ke změně záznamu.',
                        'question'
                    );
                } else {
                    swal(
                        'Chyba',
                        'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
                        'error'
                    );
                }
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            swal(
                'Chyba',
                'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
                'error'
            );
        });
    }

});

$('#contactAddEditForm').submit(function(e) {
    e.preventDefault();
    var name = $("#contactName").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var idCompany = $("#idCompany").val();
    var idContact = $("#idContact").val();
    var token = $(this).attr("token");

    var request = $.ajax({
        url: "/ajax/updateContact.php",
        method: "POST",
        data: { name: name, email: email, phone: phone, idContact: idContact, idCompany: idCompany, token: token },
        dataType: "html"
    });

    request.done(function( msg ) {
        if (parseInt(msg)!==0) {
            swal(
                'Uloženo',
                'Údaje kontaktu jsme uložili do databáze.',
                'success'
            );

            $("#contact").modal("hide");

            var request2 = $.ajax({
                url: "/ajax/getContactsTable.php",
                method: "POST",
                data: { idCompany: idCompany },
                dataType: "html"
            });

            request2.done(function( msg ) {
                $("#contactsTable").html(msg);
                $("#datatableContacts").DataTable({
                    "language": {
                        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
                    },
                    "order": [[ 0, "desc" ]]
                });
            });

            request2.fail(function( jqXHR, textStatus ) {
                swal(
                    'Chyba',
                    'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
                    'error'
                );
            });
        } else {
            swal(
                'Zůstalo to stejné',
                'Nedošlo ke změně záznamu.',
                'question'
            );
        }
    });

    request.fail(function( jqXHR, textStatus ) {
        swal(
            'Chyba',
            'Chyba komunikace s databází, zkuste to později, příp. kontaktujte administrátory aplikace ADMIS.',
            'error'
        );
    });
});

$(document).on('click', '.allow-user', function () {
    var button = $(this);
    var username = $(this).attr('username');
    var accessDenied = $(this).attr('access-denied');
    var token = $(this).attr("token");

    var request2 = $.ajax({
        url: "/ajax/updateAccessDeniedUser.php",
        method: "POST",
        data: {username: username, accessDenied: accessDenied, token: token},
        dataType: "html"
    });

    request2.done(function (msg) {
        if (msg === 'chyba') {
            swal(
                'Chyba při zpracování požadavku.',
                null,
                'error'
            );
        } else if (parseInt(msg) === 1) {
            swal(
                'Uživatel zablokován!',
                null,
                'success'
            );
            button.removeClass("btn-danger").addClass("btn-success").attr('access-denied','1').attr('data-original-title','Odblokovat uživatele').children("i").removeClass("fa-user-times").addClass("fa-user-check");
            button.parent("td").prev().prev().prev().prev().html("zablokován");
            $('.tooltip').tooltip('dispose');
            $('[data-toggle="tooltip"]').tooltip();
        } else if (parseInt(msg) === 0) {
            swal(
                'Uživatel odblokován!',
                null,
                'success'
            );
            button.removeClass("btn-success").addClass("btn-danger").attr('access-denied','0').attr('data-original-title','Zablokovat uživatele').children("i").removeClass("fa-user-check").addClass("fa-user-times");
            button.parent("td").prev().prev().prev().prev().html("aktivní");
            $('.tooltip').tooltip('dispose');
            $('[data-toggle="tooltip"]').tooltip();
        } else {
            swal(
                'Chyba při zpracování požadavku (AJAX).',
                null,
                'error'
            );
        }
    });

    request2.fail(function (jqXHR, textStatus) {
        swal(
            'Chyba při zpracování požadavku.',
            null,
            'error'
        );
    });
});