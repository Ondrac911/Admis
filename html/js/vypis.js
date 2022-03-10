$(document).ajaxComplete(function () {
    /*  $(".tooltip").tooltip("hide");
      $('.tooltip').tooltip('dispose');*/
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
    });
});


$(document).ready(function () {
    // $("#loading").modal();
    let uri = URI(window.location.href);


    $("#startFilter").bind('click', function () {
        $('select.filterSelect').each(function(){
            uri.removeSearch($(this).attr('id'));
            if ($(this).val()!="") {
                uri.addSearch($(this).attr('id'), $(this).val().join(','));
            }
            var stateObj = {foo: "bar"};
            history.pushState(stateObj, "page 2", uri);
        });
        var checkedBoxes = $('.phaseCheckbox:checked').map(function () {
            return $(this).val();
        }).toArray();
        uri.removeSearch('idPhase');
        console.log("checked boxes: "+checkedBoxes);
        if (checkedBoxes!="") {
            uri.addSearch('idPhase', checkedBoxes.join(','));
        }
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "page 2", uri);
        location.reload();
    });

    $('#spreadsheet').bind('click',function () {
        $('select.filterSelect').each(function(){
            uri.removeSearch($(this).attr('id'));
            if ($(this).val()!="") {
                uri.addSearch($(this).attr('id'), $(this).val().join(','));
            }
        });
        const checkedBoxes = $('.phaseCheckbox:checked').map(function () {
            return $(this).val();
        }).toArray();

        if (checkedBoxes!="") {
            uri.addSearch('idPhase', checkedBoxes.join(','));
        }
        window.open('spreadsheet.php?'+uri.query())
    });

    $("#myProjectsFilter").bind('click', function () {
        var request = $.ajax({
            url: "/ajax/getUsername.php",
            method: "POST",
            dataType: "html"
        });
        request.done(function( msg ) {
            uri.removeSearch('supervisorCompanyId');
            uri.removeSearch('buildCompanyId');
            uri.removeSearch('projectCompanyId');
            uri.removeSearch('idCommunication');
            uri.removeSearch('idProjectType');
            uri.removeSearch('idProject');
            uri.removeSearch('idArea');
            uri.removeSearch('contactSupervisor');
            uri.removeSearch('contactBuildManager');
            uri.removeSearch('contactDesigner');
            uri.removeSearch('idFinSource');
            uri.removeSearch('idPhase');
            uri.removeSearch('editor');
            uri.addSearch('editor', msg);
            var stateObj = {foo: "bar"};
            history.pushState(stateObj, "page 2", uri);
            location.reload();
        });
    });

    $("#resetFilter").bind('click', function () {
        uri.removeSearch('supervisorCompanyId');
        uri.removeSearch('buildCompanyId');
        uri.removeSearch('projectCompanyId');
        uri.removeSearch('idCommunication');
        uri.removeSearch('idProjectType');
        uri.removeSearch('idProject');
        uri.removeSearch('idArea');
        uri.removeSearch('contactSupervisor');
        uri.removeSearch('contactBuildManager');
        uri.removeSearch('contactDesigner');
        uri.removeSearch('idFinSource');
        uri.removeSearch('idPhase');
        uri.removeSearch('editor');
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "page 2", uri);
        location.reload();
    });

    var filters = uri.search(true);
    $.each(filters, function (k, v) {
        var values = v.split(',');
        //console.log(k);
        if (k == 'idPhase') {
            $('.phaseCheckbox').prop("checked", false);
            $.each(values, function (a, b) {
                //console.log(b);
                $('.phaseCheckbox:checkbox[value=' + b + ']').prop("checked", true);
            })
        } else {
            $("#" + k).selectpicker('val', values);
        }
    });




    $(".deactivateProject").bind('click', function (e) {
        e.preventDefault();
        swal({
            title: 'Jste si jistý?',
            text: 'Chystáte se smazat projekt!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Deaktivovat',
            cancelButtonText: 'Ponechat'
        }).then((result) => {
            if (result) {
                $.get($(this).parent().attr('href'), function (data, status) {
                    if (data > 0) {
                        swal(
                            'Záznam smazán!',
                            null,
                            'success'
                        ).then(result => {
                            location.reload()
                        });
                    }
                    if (data == 0) {
                        swal(
                            'Nemáte oprávnění ke smazání tohoto záznamu!',
                            null,
                            'error'
                        )
                    }
                    if (!$.isNumeric(data) || data < 0 || status == 'error') {
                        swal(
                            'Chyba při zpracování požadavku',
                            null,
                            'error'
                        );
                        // alert(data);
                    }
                    //$('#projectList').load("/ajax/vypis.php");
                });

            }
        });
    });

    $('.deadlineSP').each(function () {
        initCalendar($(this))
    });

    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('[data-toggle="tooltip"]').tooltip();
    $("#blokStavbaNew").show('slow');




    $(document).on('click','.ukoly',function() {
        var idProject = $(this).attr('id').substring(5);
        $("#hiddenAssignmentsUpdateProjectId").val(idProject);
        $("#assignmentsUpdateData").val($(this).children("p").html());
        $("#assignmentsUpdateProjectId").html(idProject);
        $("#assignmentsUpdateModal").modal("show");
    });

    $(document).on('click','#saveAssignment',function() {
        var assignments = $("#assignmentsUpdateData").val();
        var idProject = $("#hiddenAssignmentsUpdateProjectId").val();
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
        var button = $(this);

        var request = $.ajax({
            url: "/ajax/updateAssignments.php",
            method: "POST",
            data: { idProject: idProject, assignments: assignments },
            dataType: "html"
        });

        request.done(function( msg ) {
            $("#ukoly"+idProject).children("p").html(assignments);
            button.html("<i class='fa fa-check'></i>");
            setTimeout(function() {
                $("#assignmentsUpdateModal").modal('hide');
                button.html("Uložit");
            }, 700);
        });

        request.fail(function( jqXHR, textStatus ) {
            button.html("<i class='fa fa-cross'></i>");
            setTimeout(function() {
                $("#assignmentsUpdateModal").modal('hide');
                button.html("Uložit");
            }, 1500);
        });
    });
});

