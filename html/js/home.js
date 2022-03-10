$("#tableHistory").DataTable({
    "language": {
        "url": "/dashboard/assets/js/plugins/locale/Czech.json"
    },
    "columnDefs": [
        { "orderable": false, "targets": [0,7] }
    ],
    "order": [[ 4, "desc" ]],
});

$calendar = $('#fullCalendar');

today = new Date();
y = today.getFullYear();
m = today.getMonth();
d = today.getDate();

$calendar.fullCalendar({
    height: 550,
    viewRender: function(view, element) {
        // We make sure that we activate the perfect scrollbar when the view isn't on Month
        if (view.name != 'month'){
            $(element).find('.fc-scroller').perfectScrollbar();
        }
    },
    eventRender: function(eventObj, el) {
        el.popover({
            title: eventObj.title,
            content: eventObj.description,
            trigger: 'hover',
            placement: 'top',
            container: 'body',
            html: true
        });
    },
    defaultView: 'month',

    locale: 'cs',
    header: {
        left: 'title',
        center: 'month,agendaWeek,agendaDay,listYear',
        right: 'prev,next,today'
    },
    defaultDate: today,
    selectable: true,
    selectHelper: true,
    views: {
        month: { // name of view
            titleFormat: 'MMMM YYYY',
            // other view-specific options here
        },
        week: {
            titleFormat: " MMMM D YYYY"
        },
        day: {
            titleFormat: 'D MMM, YYYY'
        }
    },

    select: function(start, end) {

        var request = $.ajax({
            url: "/ajax/getNewEventForm.php"
        });

        request.done(function (msg) {
            swal({
                title: 'Nová událost',
                html: msg,
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Uložit',
                cancelButtonText: "Zrušit",
                buttonsStyling: false
            }).then(function(result) {

                var eventData;
                var event_title = $('#eventTitle').val();
                var event_description = $('#eventDescription').val();
                var ou = $('#ou').find('option:selected').text();
                var idOu = $('#ou').val();
                time = $('#time').val();
                if (time!="") {
                    time = time.split(':');
                    start = moment(start).add(time[0], "hours").add(time[1], "minutes");
                    end = moment(start).add(1, "hours");
                }

                var request2 = $.ajax({
                    url: "/ajax/insertCustomEvent.php",
                    method: "POST",
                    data: {title: event_title, description: event_description, idOu: idOu, eventStart: start.format('YYYY-MM-DD HH:mm'), eventEnd: end.format('YYYY-MM-DD HH:mm')},
                    dataType: "html"
                });

                request2.done(function (msg) {
                    if (event_title) {
                        $calendar.fullCalendar('removeEvents'); // stick? = true
                        $calendar.fullCalendar('refetchEvents');
                    }

                    $calendar.fullCalendar('unselect');
                });

            }, function(dismiss) {
                if (dismiss == 'cancel') {
                    console.log("inserting of new event canceled");
                }
            });
        });
        // on select we show the Sweet Alert modal with an input

    },

    eventLimit: true, // allow "more" link when too many events


    // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
    eventSources: [

        // your event source
        {
            url: '/ajax/getTermsToFullCalendar.php',
            type: 'POST',
            data: {
                //custom_param1: 'something',
                //custom_param2: 'somethingelse'
            },
            error: function() {
                //alert('there was an error while fetching events!');
            },
            color: '#00acc1',   // a non-ajax option
            textColor: 'black', // a non-ajax option
            eventSourceSuccess: function(content, xhr) {
                return content.eventArray;
            },
            editable: false
        },
        {
            url: '/ajax/getCustomTermsToCalendar.php',
            type: 'POST',
            data: {
                //custom_param1: 'something',
                //custom_param2: 'somethingelse'
            },
            error: function() {
                //alert('there was an error while fetching events!');
            },
            color: '#00acc1',   // a non-ajax option
            textColor: 'black', // a non-ajax option
            eventSourceSuccess: function(content, xhr) {
                return content.eventArray;
            },
            editable: false
        }

        // any other sources...

    ],
    eventClick: function(event) {
        if (!event.url) {
            var description = event.description.split('<hr>');
            $('#calendarEventModalTitle').val(event.title);
            $('#calendarEventModalBody').val(description[0]);
            $('#idEvent').val(event.id.substr(11));
            if (moment(event.start).format().length==10) {
                $('#calendarEventStart').attr("type", "date");
                $('#calendarEventEnd').attr("type", "date");
            } else {
                $('#calendarEventStart').attr("type", "datetime-local");
                $('#calendarEventEnd').attr("type", "datetime-local");
            }
            $('#calendarEventStart').val(moment(event.start).format());
            if (event.end) {
                $('#calendarEventEnd').val(moment(event.end).format());
            } else {
                $('#calendarEventEnd').val(moment(event.start).format());
            }
            $('#calendarEventModal').modal('show');
            return false;
        }
    },
    /* MAYBE ONE DAY THIS WILL ALLOW TO DRAG AND DROP CUSTOM EVENTS
    eventDrop: function(event, delta) {
        var descriptionAll = event.description.split('<hr>');
        var deltaDay = parseInt(delta/60/60/24/1000);
        var eventStart = event.start.add(deltaDay, "d");
        console.log(eventStart);
        var eventEnd = moment(event.end);
        eventEnd.add(deltaDay, "d");
        var title = event.title;
        var description = descriptionAll[0];
        var idEvent = event.id.substr(11);
        var request = $.ajax({
            url: "/ajax/updateCustomEvent.php",
            method: "POST",
            data: { eventStart: eventStart, eventEnd: eventEnd, title: title, description: description, idEvent: idEvent, delete: 0 },
            dataType: "html"
        });
        request.done(function( msg ) {
            $('#calendarEventModal').modal('hide');
            $calendar.fullCalendar('removeEvents');
            $calendar.fullCalendar('refetchEvents');
        });
    },*/
    timeFormat: 'H:mm'

});

$("#saveCustomEventChanges").bind('click', function () {
    var eventStart = $('#calendarEventStart').val();
    var eventEnd = $('#calendarEventEnd').val();
    var title = $('#calendarEventModalTitle').val();
    var description = $('#calendarEventModalBody').val();
    var idEvent = $('#idEvent').val();
    var request = $.ajax({
        url: "/ajax/updateCustomEvent.php",
        method: "POST",
        data: { eventStart: eventStart, eventEnd: eventEnd, title: title, description: description, idEvent: idEvent, delete: 0 },
        dataType: "html"
    });
    request.done(function( msg ) {
        $('#calendarEventModal').modal('hide');
        $calendar.fullCalendar('removeEvents');
        $calendar.fullCalendar('refetchEvents');
    });
});

$("#deleteCustomEvent").bind('click', function () {
    swal({
        title: 'Smazat?',
        html: "Opravdu chcete smazat událost <b>"+$('#calendarEventModalTitle').val()+"</b>?",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-primary',
        confirmButtonText: 'Smazat',
        cancelButtonText: "Zachovat",
        buttonsStyling: false
    }).then(function(result) {
        var eventStart = $('#calendarEventStart').val();
        var eventEnd = $('#calendarEventEnd').val();
        var title = $('#calendarEventModalTitle').val();
        var description = $('#calendarEventModalBody').val();
        var idEvent = $('#idEvent').val();
        var request = $.ajax({
            url: "/ajax/updateCustomEvent.php",
            method: "POST",
            data: { eventStart: eventStart, eventEnd: eventEnd, title: title, description: description, idEvent: idEvent, delete: 1 },
            dataType: "html"
        });
        request.done(function( msg ) {
            $('#calendarEventModal').modal('hide');
            $calendar.fullCalendar('removeEvents');
            $calendar.fullCalendar('refetchEvents');
        });

    });
});





/* DASHBOARD MAGIC comes alive here */

// activate collapse right menu when the windows is resized
$(window).resize(function() {


    // reset the seq for charts drawing animations
    seq3 = seq4 = 0;

    setTimeout(function() {
        dashboard.initDashboardPageCharts2();
    }, 500);
});

$( document ).ready(function() {
    setTimeout(function () {
        dashboard.initDashboardPageCharts2();
    }, 500);
});

dashboard = {
    misc: {
        navbar_menu_visible: 0,
        active_collapse: true,
        disabled_collapse_init: 0
    },

    initDashboardPageCharts2: function() {

        if ($('#statsEditor2Projects').length != 0 || $('#completedTasksChart').length != 0 || $('#websiteViewsChart').length != 0) {
            /* ----------==========     Chart initialization    ==========---------- */


            $.get("../ajax/getStatsEditor2Projects.php", function (data, status) {
                dataStatsEditor2Projects = JSON.parse(data);
                optionsStatsEditor2Projects = {
                    axisX: {
                        showGrid: false
                    },

                    low: 0,
                    onlyInteger: true,
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    chartPadding: {
                        top: 0,
                        right: 5,
                        bottom: 0,
                        left: 0
                    }
                };

                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ];

                var statsEditor2Projects = new Chartist.Bar('#statsEditor2Projects', dataStatsEditor2Projects, optionsStatsEditor2Projects, responsiveOptions);

                dashboard.startAnimationForBarChart(statsEditor2Projects);
            });


            $.get("../ajax/getStatMonth2Projects.php", function (data, status) {
                dataStatMonth2Projects = JSON.parse(data);

                optionsStatMonth2Projects = {
                    axisX: {
                        showGrid: false
                    },
                    low: 0,
                    onlyInteger: true,
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                };
                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ];

                var statMonth2Projects = new Chartist.Bar('#statMonth2Projects', dataStatMonth2Projects, optionsStatMonth2Projects, responsiveOptions);

                // start animation for the Completed Tasks Chart - Line Chart
                dashboard.startAnimationForBarChart(statMonth2Projects);
            });

            $.get("../ajax/getStatYear2Projects.php", function (data, status) {
                dataStatYear2Projects = JSON.parse(data);
                var optionsStatYear2Projects = {
                    axisX: {
                        showGrid: false
                    },
                    low: 0,
                    onlyInteger: true,
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    chartPadding: {
                        top: 0,
                        right: 5,
                        bottom: 0,
                        left: 0
                    }
                };
                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ];
                var statYear2Projects = Chartist.Bar('#statYear2Projects', dataStatYear2Projects, optionsStatYear2Projects, responsiveOptions);

                //start animation for the Emails Subscription Chart
                dashboard.startAnimationForBarChart(statYear2Projects);
            });

            $.get("../ajax/getPieGraphPhase2Projects.php", function (data, status) {
                dataPieGraphPhase2Projects = JSON.parse(data);

                var optionsPieGraphPhase2Projects = {
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    showPoint: false,
                    showLine: false,
                    showArea: true,
                    fullWidth: true,
                    showLabel: false,
                    axisX: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0
                    },
                    axisY: {
                        showGrid: false,
                        showLabel: false,
                        offset: 0
                    },
                    chartPadding: 0,
                    low: 0
                };

                var PieGraphPhase2Projects = Chartist.Pie('#PieGraphPhase2Projects', dataPieGraphPhase2Projects, optionsPieGraphPhase2Projects);

                //start animation for the Emails Subscription Chart
                dashboard.startAnimationForPieChart(PieGraphPhase2Projects);
            });

        }
    },



    startAnimationForLineChart: function(chart) {

        chart.on('draw', function(data) {
            if (data.type === 'line' || data.type === 'area') {
                data.element.animate({
                    d: {
                        begin: 600,
                        dur: 700,
                        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                        to: data.path.clone().stringify(),
                        easing: Chartist.Svg.Easing.easeOutQuint
                    }
                });
            } else if (data.type === 'point') {
                seq3++;
                data.element.animate({
                    opacity: {
                        begin: seq3 * delays,
                        dur: durations,
                        from: 0,
                        to: 1,
                        easing: 'ease'
                    }
                });
            }
        });

        seq3 = 0;
    },
    startAnimationForBarChart: function(chart) {

        chart.on('draw', function(data) {
            if (data.type === 'bar') {
                seq4++;
                data.element.animate({
                    opacity: {
                        begin: seq4 * delays2,
                        dur: durations2,
                        from: 0,
                        to: 1,
                        easing: 'ease'
                    }
                });
            }
            if(data.type === 'label' && data.axis === 'x') {

                // We just offset the label X position to be in the middle between the current and next axis grid
                data.element.attr({
                    dx: data.x + data.space / 2
                });
            }
        });

        seq4 = 0;
    },
    startAnimationForPieChart: function(chart) {
    }
};

$(document).ready(function () {
    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
    });
    $('[data-toggle="tooltip"]').tooltip();

});

$(document).on('click','#switchMyAllEvents',function() {
    if ($("#switchMyAllEvents").html()=="zobrazit jen moje stavby")
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
        if ($("#switchMyAllEvents").html()=="zobrazit jen moje stavby") {
            $("#infoMyAllEvents").html('Přehled termínů <b>u mých projektů</b> (<a id="switchMyAllEvents" href="#">zobrazit všechny stavby</a>)');
        } else {
            $("#infoMyAllEvents").html('Přehled termínů <b>u všech projektů</b> (<a id="switchMyAllEvents" href="#">zobrazit jen moje stavby</a>)');
        }
        $calendar.fullCalendar('removeEvents');
        $calendar.fullCalendar('refetchEvents');

        /* THIS PART UPDATE NOTIFICATIONS TO CURRENT VIEW SETTINGS */
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
    });

    request.fail(function (jqXHR, textStatus) {
        $("#infoMyAllEvents").html("Nepodařilo se načíst termíny projektů :( Chyba: " + textStatus);
    });
});

/* END OF DASHBOARD MAGIC */