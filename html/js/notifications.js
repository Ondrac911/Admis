
$(document).on('click','#switchModalTitle',function() {
    if ($("#switchModalTitle").html()=="zobrazit jen moje stavby")
        moje = 1;
    else
        moje = 0;

    $("#termsModalTable").dataTable().fnDestroy();

    var request = $.ajax({
        url: "/ajax/getTermsOverview.php",
        method: "GET",
        data: {moje: moje},
        dataType: "html"
    });

    request.done(function (msg) {
        if ($("#switchModalTitle").html()=="zobrazit jen moje stavby") {
            $("#termsModalTitle").html('Přehled termínů <b>u mých projektů</b> v příštích 30 dnech (<a id="switchModalTitle" href="#">zobrazit všechny stavby</a>)')
        } else {
            $("#termsModalTitle").html('Přehled termínů <b>u všech projektů</b> v příštích 30 dnech (<a id="switchModalTitle" href="#">zobrazit jen moje stavby</a>)')
        }
        var request2 = $.ajax({
            url: "/ajax/getTermsOverviewText.php",
            method: "GET",
            dataType: "html"
        });

        request2.done(function (msg) {
            $("#nextWeekNotification").attr('data-original-title', msg);
            $("#nextWeekNotification").next("span").html(msg.substring(3, 1));
        });

        request2.fail(function (jqXHR, textStatus) {
            $("#nextWeekNotification").attr('data-original-title',"Nepodařilo se načíst termíny projektů :( Chyba: " + textStatus);
        });
        $("#termsModalTable").html(msg).DataTable({
            "language": {
                "url": "/dashboard/assets/js/plugins/locale/Czech.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
        if($("#switchMyAllEvents").length) {
            if ($("#switchMyAllEvents").html()=="zobrazit jen moje stavby") {
                $("#infoMyAllEvents").html('Přehled termínů <b>u mých projektů</b> (<a id="switchMyAllEvents" href="#">zobrazit všechny stavby</a>)');
            } else {
                $("#infoMyAllEvents").html('Přehled termínů <b>u všech projektů</b> (<a id="switchMyAllEvents" href="#">zobrazit jen moje stavby</a>)');
            }
            $calendar.fullCalendar('removeEvents');
            $calendar.fullCalendar('refetchEvents');
        }
    });

    request.fail(function (jqXHR, textStatus) {
        $("#termsModalTable").html("Nepodařilo se načíst termíny projektů :( Chyba: " + textStatus);
    });
});

$(document).on('click','.notification-exit',function() {
    var idAction = $(this).attr('notification-id');
    var destination = $(this).attr('destination');
    var request = $.ajax({
        url: "/ajax/setActionAsViewed.php",
        method: "POST",
        data: { idAction: idAction },
        dataType: "html"
    });
    request.done(function( msg ) {
        location.href="detail.php?idProject="+destination;
    });
});

$(document).on('click','.notification-hide',function() {
    var idAction = $(this).attr('notification-id');
    var tr = $(this).closest("tr");
    var request = $.ajax({
        url: "/ajax/setActionAsViewed.php",
        method: "POST",
        data: { idAction: idAction },
        dataType: "html"
    });
    request.done(function( msg ) {
        tr.children('td')
            .animate({ padding: 0 })
            .wrapInner('<div />')
            .children()
            .slideUp(function() { $(this).closest('tr').remove(); });
        //tr.hide();
        var notification = parseInt($("#notificationNumber").html());
        if (notification>1){
            $("#notificationNumber").html(notification-1);
        } else {
            $("#notificationNumber").hide();
            $("#notificationsModal").modal('hide');
            $("#notificationsModalTable").html('<thead>\n' +
                '                    <tr>\n' +
                '                        <th scope="col">Datum a čas</th>\n' +
                '                        <th scope="col">Projekt</th>\n' +
                '                        <th scope="col">Událost</th>\n' +
                '                        <th scope="col">Operace</th>\n' +
                '                    </tr></thead><tbody><tr><td></td><td><h3 class=\'text-center\'>Žádné nové změny v projektech</h3></td><td></td><td></td></tr></tbody>');
        }
    });
});

$("#hideAll").bind('click', function () {
    $('.notification-hide').each(function(index, obj){
        var idAction = $(this).attr('notification-id');
        var tr = $(this).closest("tr");
        var request = $.ajax({
            url: "/ajax/setActionAsViewed.php",
            method: "POST",
            data: { idAction: idAction },
            dataType: "html"
        });
        request.done(function( msg ) {
            tr.children('td')
                .animate({ padding: 0 })
                .wrapInner('<div />')
                .children()
                .slideUp(function() { $(this).closest('tr').remove(); });
            //tr.hide();
            var notification = parseInt($("#notificationNumber").html());
            if (notification>1){
                $("#notificationNumber").html(notification-1);
            } else {
                $("#notificationNumber").hide();
                $("#notificationsModal").modal('hide');
                $("#notificationsModalTable").html('<thead>\n' +
                    '                    <tr>\n' +
                    '                        <th scope="col">Datum a čas</th>\n' +
                    '                        <th scope="col">Projekt</th>\n' +
                    '                        <th scope="col">Událost</th>\n' +
                    '                        <th scope="col">Operace</th>\n' +
                    '                    </tr></thead><tbody><tr><td></td><td><h3 class=\'text-center\'>Žádné nové změny v projektech</h3></td><td></td><td></td></tr></tbody>');
            }
        });
    });
});

$("#termsModalTable").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "columnDefs": [
        { "orderable": false, "targets": 4 }
    ]
});