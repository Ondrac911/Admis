$('#projectSuspensionsModal').on('show.bs.modal', function(e) {
    $('#suspensionForm')[0].reset();
    const id = $(e.relatedTarget).data('id');
    $("#suspensionForm input[name='idProject']").val(id);
    getSuspensionTable(id)

});

function getSuspensionTable(id){
    $.ajax({
        url: '/ajax/getSuspensions.php',
        type: "POST",
        cache: false,
        data: {id: id},
        success: function (data, status) {
            if(status === 'success' && typeof(data) != "undefined" && data !== null){
                const suspensions = JSON.parse(data);
                let html = '';
                suspensions.forEach(function(suspension, index){
                    html +=`
                        <tr>
                            <td rowspan="2">${index + 1}</td>
                            <td>${suspension.suspensionSourceName}</td>
                            <td>${suspension.suspensionReasonName}</td>
                            <td>${suspension.dateFrom}</td>
                            <td>${suspension.dateTo}</td>
                            <td rowspan="2" class="text-center">
                                <button class="btn btn-link btn-just-icon" >
                                    <i data-id="${suspension.idSuspension}" class="deleteRelation material-icons" data-toggle="tooltip" data-placement="top" data-original-title="Smazat odstávku">delete</i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">${suspension.comment}</td>
                        </tr>`
                });
                document.querySelector('#suspensionTable tbody').innerHTML = html;

                $('.deleteRelation').on('click',function (e) {
                    e.preventDefault();
                    console.log(id);
                    const idSuspension = e.target.dataset.id;
                    $.ajax({
                        url: '/submits/deleteSuspension.php',
                        type: "POST",
                        cache: false,
                        data: {idSuspension: idSuspension,
                               idProject: id},
                        success: function (data, status) {
                            console.log(data);
                            if(data == 1){
                                notify('bottom','right','success','Odstávka byla smazána');
                                getSuspensionTable(id)
                            }else{
                                notify('bottom','right','danger','Odstávka nebyla smazána');
                            }

                        }, error: function () {
                            alert('CHYBA');
                        }
                    });
                });
            }
        }, error: function () {
            alert('CHYBA aaa');
        }
    });
}

$('#suspensionForm').on('submit',function(e){
    e.preventDefault();
    let formData = new FormData($('#suspensionForm')[0]);
    $.ajax({
        url: '/submits/suspensionSubmit.php',
        type: "POST",
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        success: function (data, status) {
            if (status === 'success') {
                console.log(data);
                if(data == 1){
                    notify('bottom','right','success','Odstávka byla uložena');
                    const idProject = $("#suspensionForm input[name='idProject']").val();
                    getSuspensionTable(idProject)
                }else{
                    notify('bottom','right','danger','Odstávka nebyla uložena');
                }


                // notify('bottom','right','success','Projekt byl uložen pod ID '+ data);
            } else {
                notify('bottom','right','danger','Někde se stala chyba, relace nebyly uloženy');
            }
        }, error: function () {
            alert('CHYBA aaa');
        }
    });
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