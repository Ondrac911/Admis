
const $eiaDedlines = $(".eia");
const $studiesDeadlines = $(".studies");
const $durDeadlines = $(".dur");
const $urDeadlines = $(".ur");
const $dspDeadlines = $(".dsp");
const $spDeadlines = $(".sp");
const $mergedDeadlines = $(".merged");
const $tesDeadlines = $(".tes");

/*
$mergedDeadlines.parent().parent().parent().addClass('d-none');
$mergedDeadlines.prop('disabled', true);
*/
const $toggleMerged = $('#toggleMerged');
const $toggleDURUR = $('#toggleDURUR');

$('#toggleStudies').on('change',function () {
    if($(this).is(':checked')){
        $studiesDeadlines.prop('disabled', false);
    }else{
        $studiesDeadlines.prop('disabled', true);
        $studiesDeadlines.val(null);
    }
});

$('#toggleEIA').on('change',function () {
    if($(this).is(':checked')){
        $eiaDedlines.prop('disabled', false);
    }else{
        $eiaDedlines.prop('disabled', true);
        $eiaDedlines.val(null);
    }
});

$('#toggleTes').on('change',function () {
    if($(this).is(':checked')){
        $tesDeadlines.prop('disabled', false);
    }else{
        $tesDeadlines.prop('disabled', true);
        $tesDeadlines.val(null);
    }
});

$toggleDURUR.on('change',function () {
    if($(this).is(':checked')){
        $durDeadlines.prop('disabled', false);
        $urDeadlines.prop('disabled', false);
    }else{
        $durDeadlines.prop('disabled', true);
        $durDeadlines.val(null);
        $urDeadlines.prop('disabled', true);
        $urDeadlines.val(null);
    }
});

$toggleMerged.on('change',function () {
    console.log($dspDeadlines);
    console.log($urDeadlines);
    if($(this).is(':checked')){
        $dspDeadlines.parent().parent().parent().addClass('d-none');
        $urDeadlines.parent().parent().parent().addClass('d-none');
        $durDeadlines.parent().parent().parent().addClass('d-none');
        $spDeadlines.parent().parent().parent().addClass('d-none');
        $mergedDeadlines.parent().parent().parent().removeClass('d-none');
        if($toggleDURUR.is(':checked')){
            $toggleDURUR.prop('checked', false);
            $toggleDURUR.trigger('change')
        }
        $dspDeadlines.prop('disabled', true);
        $dspDeadlines.val(null);
        $spDeadlines.prop('disabled', true);
        $spDeadlines.val(null);
        $mergedDeadlines.prop('disabled', false);
    }else{
        $dspDeadlines.parent().parent().parent().removeClass('d-none');
        $urDeadlines.parent().parent().parent().removeClass('d-none');
        $durDeadlines.parent().parent().parent().removeClass('d-none');
        $spDeadlines.parent().parent().parent().removeClass('d-none');
        $mergedDeadlines.parent().parent().parent().addClass('d-none');

        if($toggleDURUR.is(':checked')){
            $durDeadlines.prop('disabled', false);
            $urDeadlines.prop('disabled', false);
        }
        $dspDeadlines.prop('disabled', false);
        $spDeadlines.prop('disabled', false);
        $mergedDeadlines.prop('disabled', true);
        $mergedDeadlines.val(null);

    }
});

$('.toggleDeadline').on('change',function () {
    if($(this).is(':checked')){
        $(this).closest('.togglebutton').find("input[type='hidden']").val(1);
    }else{
        $(this).closest('.togglebutton').find("input[type='hidden']").val(0);
    }
});

const deadlineEvidence = $(".dateEvidence");

$('#toggleEvidence').bind('change',function(){
    if($(this).is(':checked')){
        deadlineEvidence.prop('disabled', false);
        $("input[name='dateEvidence']").val(1)
    }else{
        deadlineEvidence.prop('disabled', true);
        $("input[name='dateEvidence']").val(0);
        deadlineEvidence.val(null);
    }
});

$('.toggleDeadline').trigger('change');
$('#toggleEvidence').trigger('change');

$('.deadlineSP').each(function () {
    initCalendar($(this))
});

$("#contractorProjectCompany").on('change',function () {
    let id = $(this).find(":selected").data("value");

    $.post("/ajax/getContact.php",
        {
            idCompany: id,
            name: true
        },
        function(data, status){
            if(status === 'success' && typeof(data) != "undefined" && data !== null){
                console.log(data);
                $(".contactProjectContractorDataList").html(data);
                $(".contactProjectContractorIdCompany").val(id);

            }
        }
    );
    $(".contactProjectContractorEmail").val(null);
    $(".contactProjectContractorPhone").val(null);
    $(".contactProjectContractorName").val(null);
});

$("#generalContractorCompany").on('change',function () {
    let id = $(this).find(":selected").data("value");
    $.post("/ajax/getContact.php",
        {
            idCompany: id,
            name: true
        },
        function(data, status){
            if(status === 'success' && typeof(data) != "undefined" && data !== null){
                console.log(data);
                $(".contactGeneralContractorDataList").html(data);
                $(".contactGeneralContractorIdCompany").val(id);

            }
        }
    );
    $(".contactGeneralContractorEmail").val(null);
    $(".contactGeneralContractorPhone").val(null);
    $(".contactGeneralContractorName").val(null);
});

$("#constructionOversightCompany").on('change',function () {
    let id = $(this).find(":selected").data("value");
    $.post("/ajax/getContact.php",
        {
            idCompany: id,
            name: true
        },
        function(data, status){
            if(status === 'success' && typeof(data) != "undefined" && data !== null){
                console.log(data);
                $(".contactConstructionOversightDataList").html(data);
                $(".contactConstructionOversightIdCompany").val(id);

            }
        }
    );
    $(".contactConstructionOversightEmail").val(null);
    $(".contactConstructionOversightPhone").val(null);
    $(".contactConstructionOversightName").val(null);
});

$(".contactName").on('input',function () {
    $that = $(this);
    const selected = $that.val();
    console.log('neco');

    let option = $('#'+ $(this).attr('list')).find("[value='" + selected + "']");
    if (option.length > 0) {
        let id = option.data("value");

        //  alert(id);
        $.post("/ajax/getContact.php",
            {
                idContact: id,
                contactInformation: true
            },
            function(data, status){
                console.log(data);
                if(status === 'success' && typeof(data) != "undefined" && data !== null){
                    let obj = JSON.parse(data);
                    console.log(obj);
                    $that.closest('.contactWrapper').find('.contactPhone').val(obj[0]['phone']);
                    $that.closest('.contactWrapper').find('.contactEmail').val(obj[0]['email']);
                }
            });
    }
});


$('.contactToggle').bind('change',function () {
    if($(this).is(':checked')){
        $(this).closest('.contactWrapper').find('.contactName').val(null).prop('disabled',true);
        $(this).closest('.contactWrapper').find('.contactPhone').val(null).prop('disabled',true);
        $(this).closest('.contactWrapper').find('.contactEmail').val(null).prop('disabled',true);
    }else{
        $(this).closest('.contactWrapper').find('.contactName').prop('disabled',false);
        $(this).closest('.contactWrapper').find('.contactPhone').prop('disabled',false);
        $(this).closest('.contactWrapper').find('.contactEmail').prop('disabled',false);
    }
});


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
    format: 'DD/MM/YYYY',
    locale: 'cs'
});


