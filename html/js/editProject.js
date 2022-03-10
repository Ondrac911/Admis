$(document).ready(function(){

    $.getScript('../js/newProject.js');
    $.getScript('../js/formControls.js');


    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
    });
    $('[data-toggle="tooltip"]').tooltip();


    $('#projectForm').submit(function (e) {
        e.preventDefault();
        console.log($('#projectForm')[0].checkValidity());
        if($('#projectForm')[0].checkValidity()){
            let formData = new FormData($('#projectForm')[0]);
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]);
            }
            $.ajax({
                url: '/submits/editProjectSubmit.php',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data,status) {
                    if (status === 'success' && $.isNumeric(data) == true) {
                        console.log(data);
                        swal({
                            title: "Hotovo",
                            text: "Změny byly úspěšně uloženy ",
                            type: "success"
                        })
                            .then(function(){
                                window.location = 'editProject.php?idProject='+ formData.get('idProject');
                            });
                    } else {
                        notify('bottom', 'right', 'danger', 'Někde se stala chyba, projekt nebyl uložen');
                    }
                }, error: function () {
                    alert('CHYBA');
                }
            });
        }
    });

    var datesCounter = 0;

    $("#addDeadlineType").click(function(e) {
        var deadlineName = $("#deadlineTypesBox option:selected").text();
        var deadlineId = $("#deadlineTypesBox option:selected").val();
        $("#deadlines").append('     <div class="col-md-6" id="deadline'+datesCounter+'">\n' +
            '                            <div class="input-group form-control-lg">\n' +
            '                                <div class="input-group-prepend">\n' +
            '                                    <span class="input-group-text">\n' +
            '                                      <i class="material-icons">date_range</i>\n' +
            '                                    </span>\n' +
            '                                </div>\n' +
            '                                <div class="form-group col bmd-form-group">\n' +
            '                                    <span><span id="removedeadline'+datesCounter+'" deadline-id="'+datesCounter+'" deadline-type="'+deadlineId+'" deadline-name="'+deadlineName+'" class="close-button float-right">X\n' +
            '                                    </span></a>                                       \n' +
            '                                    <label class="bmd-label-static">'+deadlineName+'\n' +
            '                                    </label>                                       \n' +
            '                                    <input type="text" name="deadlines['+datesCounter+'][value]" required="" class="form-control datetimepicker dateEvidence" value="" style="">\n' +
            '                                    <input type="text" name="deadlines['+datesCounter+'][note]" placeholder="Poznámka" class="form-control dateEvidence" value="">\n' +
            '                                    <input type="hidden" name="deadlines['+datesCounter+'][idDeadlineType]" value="'+deadlineId+'">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>');
        $("#removedeadline"+datesCounter).click(function(e) {
            var deadlineId = $(this).attr("deadline-id");
            $("#deadline"+deadlineId).remove();
        })
        datesCounter++;
        $("#noDeadline").hide();
        $('.datetimepicker').datetimepicker({format:'DD/MM/YYYY'});
    });
});