function notify(from, align, color, message) {
    $.notify({
        icon: "notifications",
        message: message

    }, {
        type: color,
        timer: 3000,
        placement: {
            from: from,
            align: align
        }
    });
}

function initCalendar($element){
    today = new Date();
    $element.bind('click',function(){
        let idProject = $(this).data('id');
        $calendar = $('#fullCalendar'+idProject);
        $calendar.fullCalendar({
            height:830,
            header: {
                left: 'title',
                center: 'month,agendaWeek,agendaDay,listYear',
                right: 'prev,next,today'
            },
            locale: 'cs',
            lang: 'cs',
            defaultView: 'listYear',
            defaultDate: today,
            selectable: true,
            selectHelper: true,
            views: {
                month: { // name of view
                    titleFormat: 'MMMM YYYY'
                    // other view-specific options here
                },
                week: {
                    titleFormat: " MMMM D YYYY"
                },
                day: {
                    titleFormat: 'D MMM, YYYY'
                }
            },

            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: "/ajax/getDates.php",
                type: 'POST',
                data: {
                    idProject: idProject,
                    dates: true
                },
                error: function() {
                    alert('there was an error while fetching events!');
                }
            }
        });
    });
}

function showFilesPanel(id) {
    if (($("a[onclick='showFilesPanel(" + id + ")']").children("i").html()) == "folder") {
        $("a[onclick='showFilesPanel(" + id + ")']").children("i").html("info");
        $("a[onclick='showFilesPanel(" + id + ")']").children("i").attr("title", "Základní informace");
        var staticNameKarty = 'tabNavs';
        var staticNameTab = 'tabContent';
     // $("#" + staticNameKarty + id).empty();
     $("#" + staticNameTab + id).empty();

            //     $("#" + staticNameKarty + id).find('.2hide').toggle('slow');
            //   $("#" + staticNameTab + id).find('.2hide').toggle('slow');

            $.get("/ajax/getFiles.php?id=" + id + "&panel=TRUE", function (data, status) {
                if (status == 'success') {
                    $("#" + staticNameKarty + id).replaceWith(data);
                    $.get("/ajax/getFiles.php?id=" + id + "&tab=TRUE", function (data, status) {
                        if (status == 'success') {
                            $("#" + staticNameTab + id).append(data);
                            $(function () {
                                $('#datatablesFiles' + id + "_0").DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument"
                                    }
                                });
                                var table = $('#datatablesFiles' + id).DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });
                            $(function () {
                                $('#datatablesFiles' + id + "_1").DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument"
                                    }
                                });
                                var table = $('#datatablesFiles' + id).DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });

                            $(function () {
                                $('#datatablesFiles' + id + '_2').DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument"
                                    }
                                });
                                var table = $('#datatablesFiles' + id + '_2').DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });
                            $(function () {
                                $('#datatablesFiles' + id + '_3').DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument",
                                    }
                                });
                                var table = $('#datatablesFiles' + id + '_3').DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });
                            $(function () {
                                $('#datatablesFiles' + id + '_4').DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument"
                                    }
                                });
                                var table = $('#datatablesFiles' + id + '_4').DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });
                            $(function () {
                                $('#datatablesFiles' + id + '_5').DataTable({
                                    "pagingType": "full_numbers",
                                    "aaSorting": [3,'desc'],
                                    "lengthMenu": [
                                        [10, 25, 50, -1],
                                        [10, 25, 50, "All"]
                                    ],
                                    responsive: true,
                                    language: {
                                        search: "_INPUT_",
                                        searchPlaceholder: "Hledat dokument"
                                    }
                                });
                                var table = $('#datatablesFiles' + id + '_5').DataTable();
                                table.on('click', '.download', function () {
                                    $tr = $(this).closest('tr');
                                    var data = table.row($tr).data();
                                    alert('Stahuju: ' + data[0]);
                                });
                                /*table.on('click', '.remove', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });*/
                                table.on('click', '.restore', function () {
                                    var data = $(this).find("a").attr("href");
                                });
                                table.on('click', '.note_add', function (e) {
                                    $tr = $(this).closest('tr');
                                    table.row($tr).remove().draw();
                                    e.preventDefault();
                                });
                                $('.card .material-datatables label').addClass('form-group');
                            });
                        }
                    });
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                }
                else {
                    $("#" + staticNameKarty + id).append('Nepodařilo se získat informace o souborech');
                }

            });
        } else {
            $("a[onclick='showFilesPanel(" + id + ")']").children("i").html("folder");
            $("a[onclick='showFilesPanel(" + id + ")']").children("i").attr("title", "Soubory 2");
            var request = $.ajax({
                url: "/ajax/regenerateCard.php",
                method: "POST",
                data: {idProject: id},
                dataType: "html"
            });

            request.done(function (msg) {
                console.log(msg);
                $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html(msg);
            });

            request.fail(function (jqXHR, textStatus) {
                $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html("Nepodařilo se obnovit kartu. Chyba: " + textStatus);
            });
        }


}

function regenerateCard(id) {
    $("a[onclick='showFilesPanel(" + id + ")']").children("i").html("folder");
    $("a[onclick='showFilesPanel(" + id + ")']").children("i").attr("title", "Soubory 2");
    var request = $.ajax({
        url: "/ajax/regenerateCard.php",
        method: "POST",
        data: {idProject: id},
        dataType: "html"
    });

    request.done(function (msg) {
        $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html(msg);
        //$('#relace'+id).addClass('active');
    });

    request.fail(function (jqXHR, textStatus) {
        $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html("Nepodařilo se obnovit kartu. Chyba: " + textStatus);
    });
}

function regenerateCardRelations(id) {
    $("a[onclick='showFilesPanel(" + id + ")']").children("i").html("folder");
    $("a[onclick='showFilesPanel(" + id + ")']").children("i").attr("title", "Soubory 2");
    if ($('#relace'+id).hasClass( "active" )) {
        var active = true;
    } else {
        var active = false;
    }
    var request = $.ajax({
        url: "/ajax/regenerateCard.php",
        method: "POST",
        data: {idProject: id},
        dataType: "html"
    });

    request.done(function (msg) {
        $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html(msg);
        if (active) {
            $('#relace'+id).addClass('active');
        }
    });

    request.fail(function (jqXHR, textStatus) {
        $("a[onclick='showFilesPanel(" + id + ")']").parents("div[class='card']").html("Nepodařilo se obnovit kartu. Chyba: " + textStatus);
    });
}

/* UPOZORNENI NA KONEC PLATNOSTI PRIHLASENI (SESSION TIMEOUT) */
setTimeout(function(){
    swal({
        title: 'Jste dlouho neaktivní, za chvilku vás automaticky odhlásíme',
        text: 'Zbývá vám méně než 10 minut platnosti aktuálního přihlášení do aplikace ADMIS. Chcete obnovit stávájící přihlášení a zůstat přihlášen(a)?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano, zůstat přihlášen(a)',
        cancelButtonText: 'Odhlásit'
    }).then((result) => {
        console.log(result);
        if (result.value) {

            var request2 = $.ajax({
                url: "/ajax/restoreSession.php",
                method: "POST",
                dataType: "html"
            });

            request2.done(function( msg ) {
                swal(
                    'Přihlášení prodlouženo o dalších 60 minut!',
                    null,
                    'success'
                );
            });

            request2.fail(function( jqXHR, textStatus ) {
                swal(
                    'Chyba při zpracování požadavku.',
                    null,
                    'error'
                );
            });

        }
    }, (dismiss) => {
        if (dismiss === 'cancel') {
            location.href = "/";
        }
    });
}, 3000000);

setTimeout(function () {
    location.href = "/";
}, 3480000);

$('.remove-deadline').on('click', function() {
    $(this).closest(".deadline-col").remove();
});