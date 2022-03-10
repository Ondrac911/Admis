$('#relationForm').on('submit',function(e){
    e.preventDefault();
    let formData = new FormData($('#relationForm')[0]);
    $.ajax({
        url: '/submits/editRelations.php',
        type: "POST",
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        success: function (data, status) {
            if (status === 'success') {
                console.log(data);
                var idProject = $("#relationForm input[name='projectId']").val();
                notify('bottom','right','success','Relace byly uloženy');
                $("#projectList div").each(function () {
                    if (typeof($(this).children(".nav-tabs-wrapper").attr('id')) !== "undefined" && ($(this).children(".nav-tabs-wrapper").attr('id')) !== null)
                        regenerateCardRelations(parseInt(($(this).children(".nav-tabs-wrapper").attr('id')).substr(10)));
                });

                // notify('bottom','right','success','Projekt byl uložen pod ID '+ data);
            } else {
                notify('bottom','right','danger','Někde se stala chyba, relace nebyly uloženy');
            }
        }, error: function () {
            alert('CHYBA aaa');
        }
    });
});



$('#projectRelationModal').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var projId = $(e.relatedTarget).data('id');
    $("#relationForm input[name='projectId']").val(projId);
    //populate the textbox
    $.ajax({
        url: '/ajax/getRelatedProjects.php',
        type: "POST",
        cache: false,
        data: {
            idProject:projId
        },
        success: function (data, status) {

            relations = $.parseJSON(data);
            console.log(relations);
            keys_ = Object.keys(relations);
            $('#relationForm select').each(function(){
                $(this).selectpicker('val', []);
            });

            $.each( keys_, function(index, value ){
                console.log(value);
                console.log(relations[value]);
                $('#relationTypeSelect'+value).selectpicker('val', relations[value]['idProjectRelation']).trigger('change');
            });


        }, error: function () {
            alert('CHYBA aaa');
        }
    });
    //$(e.currentTarget).find('input[name="bookId"]').val(bookId);
});

