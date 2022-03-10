$( document ).ajaxComplete(function() {
    $(".tooltip").tooltip("hide");
    $('.tooltip').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function(){

    $.getScript('../js/newProject.js');
    $.getScript('../js/formControls.js');

    $("#nextPhaseForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData($('#nextPhaseForm')[0]);
        if ($(document.activeElement).attr('id') == 'saveNoValidate') {
            formData.append('inConcept',1);
        } else if ($(document.activeElement).attr('id') == 'saveValidate') {
            formData.append('inConcept',0);
        }

        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }

        console.log(formData);

        $.ajax({
            url: '/submits/changeProjectPhaseSubmit.php',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data,status) {
                console.log(data);
                if(status === 'success' && $.isNumeric( data ) === true){
                    const idProject = $("input[name='idProject']").val();
                    swal({
                        title: "Hotovo",
                        text: "Fáze projektu byla uspěšně změněna",
                        type: "success"
                    }).then(function(){
                        window.location = 'vypis.php?idProject='+ idProject;
                    });
                }
                else{
                    notify('bottom','right','danger','Někde se stala chyba, projekt nebyl uložen');
                }
            }, error: function () {
                alert('CHYBA');
            }
        });
    });




    //$("#contractorProjectCompany").trigger('input');

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