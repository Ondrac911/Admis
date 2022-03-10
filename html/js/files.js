var preventor3 = function (e) {
    if ($("#fileDescription").val()=="") {
        e.preventDefault();
        $('#fileDescription').tooltip({'trigger':'focus', 'title': 'Popis souboru je povinný'}).focus();
        // e.stopImmediatePropagation();
        return false;
    } else {
        $('#uploadFileModal').off('hide.bs.modal', preventor3);
        // restore upload bar
        //$("#uploadProgress").attr("aria-valuenow", 0).width(0).removeClass("bg-success").addClass("progress-bar-striped").addClass("progress-bar-animated").addClass("bg-rose");
    }
};

$(document).on('click','.tag-in-table',function() {
    var fileCategoryId = $("#hiddenFileCategoryId").val();
    var idProject = $(this).parent('td').parent('tr').attr('project-id');
    var table = $('#datatablesFiles'+idProject+'_'+fileCategoryId).DataTable();
    table.search($(this).html()).draw();
});

Dropzone.options.newFileUploadDropzone = {
    maxFilesize: 1024,
    uploadMultiple: false,
    maxFiles: 1,
    createImageThumbnails: false,
    selectedUnit: "MB",
    init: function() {
        this.on("addedfile", function(file) {

                        // Create the remove button
                        var removeButton = Dropzone.createElement("<btn class='btn btn-danger' id='removeButton'>Odebrat</btn>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        console.log("soubor vytvoren");
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            console.log("Mazu soubor");
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            $("#uploadProgress").attr("aria-valuenow", 0).width(0).removeClass("bg-success").addClass("progress-bar-striped").addClass("progress-bar-animated").addClass("bg-rose");
                            $('#uploadFileModal').off('hide.bs.modal', preventor3);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.

                            var idDocumentLocal = $("#hiddenDocumentId").val();
                            var token = $("#hiddenToken").val();
                            console.log(idDocumentLocal);
                            console.log(token);

                            /*
                            var request2 = $.ajax({
                                url: "/ajax/deleteFile.php",
                                method: "POST",
                                data: { idDocumentLocal: idDocumentLocal, token: token },
                                dataType: "html"
                            });

                            request2.done(function( msg ) {
                                console.log("smazan soubor tlacitkem pri nahravani");
                            });

                            request2.fail(function( jqXHR, textStatus ) {
                            });
                             */

                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

        });
        this.on("sending", function(file, xhr, data) {
            console.log($("#hiddenDocumentId").val());
            data.append("projectId", $("#hiddenProjectId").val());
            data.append("idDocumentCategory", $("#hiddenFileCategoryId").val());
            data.append("idDocument", $("#hiddenDocumentId").val());
        });
    },
    accept: function(file, done) {
        console.log(file);
        $.get('/ajax/fileAttr.php', function (data) {
            fileTypes = JSON.parse(data);
            console.log(file.type);
            if ($.inArray(file.type, fileTypes) !== -1) {
                done();
            } else { done("Tento typ souboru neni podporovan");
                //console.log(response);
                //location.reload();
            }
        });
    },
    totaluploadprogress: function(progress) {
        console.log(progress);
        $("#uploadProgress").attr("aria-valuenow", progress).width(progress + "%");
        if (progress===100) {
            $("#uploadProgress").removeClass("bg-rose").removeClass("progress-bar-striped").removeClass("progress-bar-animated").addClass("bg-success");
        }
        var preventor = function (e) {
            if ($("#uploadProgress").attr("aria-valuenow")<100 && progress<100) {
                console.log("not finished");
                console.log(progress);
                e.preventDefault();
                $('#uploadProgress').tooltip({'title': 'Upload souboru ještě nebyl dokončen'}).tooltip('show');
                // e.stopImmediatePropagation();
                return false;
            } else {
                $('#uploadFileModal').off('hide.bs.modal', preventor);
            }
        };
        $('#uploadFileModal').on('hide.bs.modal', preventor);
    },
    success: function(file, response){
        //alert(response);
        console.log(file.name);
        $("#hiddenFileName").attr("value", file.name);
        $("#hiddenDocumentId").val(response);
        $("#fileDescription").focus();
        $('#uploadProgress').tooltip('dispose');
        $('#uploadFileModal').on('hide.bs.modal', preventor3);
    }
};

$(document).on('click','.plusButton',function() {
    var idProject = $(this).attr('id').substring(13);
    $("#hiddenProjectId").val(idProject);
    $("#hiddenDocumentId").val("0");
    $("#fileDescription").val("");
    Dropzone.forElement('#newFileUploadDropzone').removeAllFiles(true);
    // restore upload bar
    $("#uploadProgress").attr("aria-valuenow", 0).width(0).removeClass("bg-success").addClass("progress-bar-striped").addClass("progress-bar-animated").addClass("bg-rose");
});
$(document).on('click','.fileCategory',function() {
    $("#hiddenFileCategoryId").val($(this).attr('file-category-id'));
});

$(document).on('click','.update-file-version',function() {
    $("#hiddenDocumentId").val($(this).attr('document-id'));
    $("#hiddenProjectId").val($(this).attr('project-id'));
    $("#fileDescription").val($(this).attr('document-description'));
    Dropzone.forElement('#newFileUploadDropzone').removeAllFiles(true);
    // restore upload bar
    $("#uploadProgress").attr("aria-valuenow", 0).width(0).removeClass("bg-success").addClass("progress-bar-striped").addClass("progress-bar-animated").addClass("bg-rose");
});

$(document).on('click','.update-tags',function() {
    var idDocument = $(this).attr('document-id');
    $("#hiddenTagsUpdateFileId").val(idDocument);
    $("#tagsUpdateFileId").html(idDocument);
    $("#hiddenTagsUpdateProjectId").val($(this).attr('project-id'));

    var tagSelect = $('#tagsBox');
    tagSelect.empty().trigger("change");
    $.ajax({
        type: 'POST',
        url: '/ajax/getSelectedTags.php',
        data: { idDocument: idDocument },
        processResults: function (data) {
            return {
                results: data
            };
        }
    }).then(function (data) {
        // create the option and append to Select2
        var dat2 = JSON.parse(data);
        console.log(dat2);
        dat2.forEach(function(d) {
            var option = new Option(d.text, d.id, true, true);
            tagSelect.append(option).trigger('change');
        });

        // manually trigger the `select2:select` event
        tagSelect.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
    });
});

$(document).on('click','.file-version-browser',function() {
    var idDocument = $(this).attr('document-id');
    $("#hiddenProjectId").val($(this).attr('project-id'));
    $("#fileIdTitle").html(idDocument);
    var request2 = $.ajax({
        url: "/ajax/getVersionsTable.php",
        method: "POST",
        data: { idDocument: idDocument },
        dataType: "html"
    });

    request2.done(function( msg ) {
        $("#fileVersionsHere").html(msg);
        $('#datatablesFilesVersion'+idDocument).DataTable({
            "pagingType": "full_numbers",
            "aaSorting": [0,'desc'],
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
    });

    request2.fail(function( jqXHR, textStatus ) {
        $("#fileVersionsHere").html('Nepodařilo se načíst tabulku verzí. Chyba: '+textStatus);
    });

    //$("#hiddenProjectId").val($(this).attr('project-id'));
});

$(document).on('click','.preview',function() {
    var pfdLink = $(this).attr('file') + '&preview=TRUE';
    if ($(this).attr('file-type')==="pdf") {
        $("#hiddenProjectId").val($(this).attr('project-id'));
        PDFObject.embed(pfdLink, "#pdfVersionHere");
        $("#pdfVersionPreviewModal").modal("show");
    }
    if ($(this).attr('file-type')==="jpg") {
        $("#pdfVersionHere").removeClass('pdfobject-container').html("<img src='"+pfdLink+"' class='img img-fluid'>");
        $("#pdfVersionPreviewModal").modal("show");
    }
    if ($(this).attr('file-type')==="png") {
        $("#pdfVersionHere").removeClass('pdfobject-container').html("<img src='"+pfdLink+"' class='img img-fluid'>");
        $("#pdfVersionPreviewModal").modal("show");
    }

    /*
    var request2 = $.ajax({
        url: "/ajax/getVersionsTable.php",
        method: "POST",
        data: { idDocument: idDocument },
        dataType: "html"
    });

    request2.done(function( msg ) {
        $("#fileVersionsHere").html(msg);
        $('#datatablesFilesVersion'+idDocument).DataTable({
            "pagingType": "full_numbers",
            "aaSorting": [0,'desc'],
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
    });

    request2.fail(function( jqXHR, textStatus ) {
        $("#fileVersionsHere").html('Nepodařilo se načíst tabulku verzí. Chyba: '+textStatus);
    });
     */

    //$("#hiddenProjectId").val($(this).attr('project-id'));
});

$(document).on('click','.document-restore',function() {
    swal({
        title: 'Opravdu ho máme obnovit?',
        text: 'Z této verze uděláme novou aktuální verzi!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano, obnovit!',
        cancelButtonText: 'Nechat být'
    }).then((result) => {
        if (result) {

            var idDocumentLocal = $(this).attr('document-restore');
            var idDocument = $(this).attr('file-id');

            var request2 = $.ajax({
                url: "/ajax/restoreFileVersion.php",
                method: "POST",
                data: { idDocumentLocal: idDocumentLocal},
                dataType: "html"
            });

            request2.done(function( msg ) {
                swal(
                    'Soubor obnoven!',
                    null,
                    'success'
                );

                console.log(idDocument);

                var request3 = $.ajax({
                    url: "/ajax/getVersionsTable.php",
                    method: "POST",
                    data: { idDocument: idDocument },
                    dataType: "html"
                });

                request3.done(function( msg ) {
                    $("#fileVersionsHere").html(msg);
                    $('#datatablesFilesVersion'+idDocument).DataTable({
                        "pagingType": "full_numbers",
                        "aaSorting": [0,'desc'],
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
                });

                request3.fail(function( jqXHR, textStatus ) {
                    $("#fileVersionsHere").html('Nepodařilo se načíst tabulku verzí. Chyba: '+textStatus);
                });

                var fileCategoryId = $("#hiddenFileCategoryId").val();
                var idProject = $("#hiddenProjectId").val();
                var tab = 'TRUE';

                console.log(fileCategoryId+" "+idProject);

                var request4 = $.ajax({
                    url: "/ajax/getFiles.php",
                    method: "GET",
                    data: { id: idProject, tab: tab },
                    dataType: "html"
                });

                request4.done(function( msg ) {
                    $("#tabContent"+idProject).html(msg);
                    if (fileCategoryId==0) {
                        $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==0) {
                        $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==1) {
                        $('.nav-tabs a[href="#filesStavba'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==2) {
                        $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==3) {
                        $('.nav-tabs a[href="#filesZapisky'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==4) {
                        $('.nav-tabs a[href="#filesDokumentace'+idProject+'"]').tab('show');
                    }
                    if (fileCategoryId==5) {
                        $('.nav-tabs a[href="#filesDalsi'+idProject+'"]').tab('show');
                    }

                    for (i=0; i<6; i++) {
                        $('#datatablesFiles'+idProject+'_'+i).DataTable({
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
                    }
                });

                request4.fail(function( jqXHR, textStatus ) {
                    $("#tabContent"+idProject).html("Nepodařilo se obnovit panel souborů :( Chyba: "+textStatus);
                });
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

    //$("#hiddenProjectId").val($(this).attr('project-id'));
});

$(document).on('blur','#fileDescription',function() {
    var textik = $(this).parent('span');
    var idDocument = $("#hiddenDocumentId").val();
    var description = $(this).val();

    if (idDocument != 0) {

        if (description) {

            var request = $.ajax({
                url: "/ajax/updateFileDescription.php",
                method: "POST",
                data: {idDocument: idDocument, description: description},
                dataType: "html"
            });

            request.done(function (msg) {
                textik.append("<span class='hotovo uspech'><i class='fa fa-check'></i></span>");
                $('.hotovo').show('fast').delay(2000).hide('fast');
                setTimeout(function () {
                    $('.hotovo').remove();
                }, 2500);
            });

            request.fail(function (jqXHR, textStatus) {
                textik.append("<span class='hotovo neuspech'><i class='fa fa-times'></i></span>");
                $('.hotovo').show('fast').delay(2000).hide('fast');
                setTimeout(function () {
                    $('.hotovo').remove();
                }, 2500);
            });
        }
    }
});

$('#uploadFileModal').on('hidden.bs.modal', function () {
    // REGENERATE FILES TAB
    var fileCategoryId = $("#hiddenFileCategoryId").val();
    var idProject = $("#hiddenProjectId").val();
    var tab = 'TRUE';

    var request = $.ajax({
        url: "/ajax/getFiles.php",
        method: "GET",
        data: { id: idProject, tab: tab },
        dataType: "html"
    });

    request.done(function( msg ) {
        $("#tabContent"+idProject).html(msg);
        if (fileCategoryId==0) {
            $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
        } else {
            $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==0) {
            $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==1) {
            $('.nav-tabs a[href="#filesStavba'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==2) {
            $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==3) {
            $('.nav-tabs a[href="#filesZapisky'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==4) {
            $('.nav-tabs a[href="#filesDokumentace'+idProject+'"]').tab('show');
        }
        if (fileCategoryId==5) {
            $('.nav-tabs a[href="#filesDalsi'+idProject+'"]').tab('show');
        }

        for (i=0; i<6; i++) {
            $('#datatablesFiles'+idProject+'_'+i).DataTable({
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
        }
    });

    request.fail(function( jqXHR, textStatus ) {
        $("#tabContent"+idProject).html("Nepodařilo se obnovit panel souborů :( Chyba: "+textStatus);
    });

    // UPDATE OF FILE DESCRIPTION
    var idDocument = $("#hiddenDocumentId").val();
    var description = $("#fileDescription").val();

    var request2 = $.ajax({
        url: "/ajax/updateFileDescription.php",
        method: "POST",
        data: { idDocument: idDocument, description: description },
        dataType: "html"
    });

    request2.done(function( msg ) {

    });

    request2.fail(function( jqXHR, textStatus ) {

    });

    $('#removeButton').click();

});

$(document).on('click','.remove-file',function() {
    swal({
        title: 'Opravdu ho máme smazat?',
        text: 'Odstraněný soubor neputuje do koše a není možné jej později obnovit!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ano, smazat!',
        cancelButtonText: 'Nechat být'
    }).then((result) => {
        if (result) {

            var idDocumentLocal = $(this).attr('document-id-local');
            var idTable = $(this).attr("table-target");
            var token = $(this).attr("token");
            console.log(idDocumentLocal);
            console.log(idTable);
            console.log(token);

            var request2 = $.ajax({
                url: "/ajax/deleteFile.php",
                method: "POST",
                data: { idDocumentLocal: idDocumentLocal, token: token },
                dataType: "html"
            });

            var magicTable = $("#"+idTable).DataTable();

            request2.done(function( msg ) {
                swal(
                    'Soubor smazán!',
                    null,
                    'success'
                );
                $('#idDocumentLocal'+idDocumentLocal).remove();
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

// Tags Search - result format
function formatResultTagsBox (data) {
    if (data.loading) return data.text;
    tag = '<span class="sys">'+ data.text+"</span>";
    return tag;
}

(function() {
    function modelMatcher(params, data) {
        data.parentText = data.parentText || "";

        // Always return the object if there is nothing to compare
        if ($.trim(params.term) === '') {
            return data;
        }

        // Do a recursive check for options with children
        if (data.children && data.children.length > 0) {
            // Clone the data object if there are children
            // This is required as we modify the object to remove any non-matches
            var match = $.extend(true, {}, data);

            // Check each child of the option
            for (var c = data.children.length - 1; c >= 0; c--) {
                var child = data.children[c];
                child.parentText += data.parentText + " " + data.text;

                var matches = modelMatcher(params, child);

                // If there wasn't a match, remove the object in the array
                if (matches == null) {
                    match.children.splice(c, 1);
                }
            }

            // If any children matched, return the new object
            if (match.children.length > 0) {
                return match;
            }

            // If there were no matching children, check just the plain object
            return modelMatcher(params, match);
        }

        // If the typed-in term matches the text of this term, or the text from any
        // parent term, then it's a match.
        var original = (data.parentText + ' ' + data.text).toUpperCase();
        var term = params.term.toUpperCase();

        // Check if the text contains the term
        if (original.indexOf(term) > -1) {
            return data;
        }

        // If it doesn't contain the term, don't return anything
        return null;
    }


    // Gallery Search
    $("#tagsBox").select2({
        placeholder: "Vyberte štítky",
        minimumInputLength: 1,
        tags: true,
        multiple: true,
        width: '100%',
        language: "cs",
        matcher: modelMatcher,
        ajax: {
            url: "/ajax/searchTags.php",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function (data) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (html) { return html; },
        templateResult: formatResultTagsBox
    });
})();

$("#saveTags").click(function () {
    var data = $('#tagsBox').select2('data');
    var idDocument = $('#hiddenTagsUpdateFileId').val();
    $('#test').html(data);
    console.log(data);

    var request2 = $.ajax({
        url: "/ajax/saveTags2document.php",
        method: "POST",
        data: {data: JSON.stringify(data), idDocument: idDocument},
        dataType: "html"
    });

    request2.done(function( msg ) {
        $("#test").html(msg);
        // REGENERATE FILES TAB
        var fileCategoryId = $("#hiddenFileCategoryId").val();
        var idProject = $("#hiddenTagsUpdateProjectId").val();
        var tab = 'TRUE';

        var request = $.ajax({
            url: "/ajax/getFiles.php",
            method: "GET",
            data: { id: idProject, tab: tab },
            dataType: "html"
        });

        request.done(function( msg ) {
            $("#tabContent"+idProject).html(msg);
            if (fileCategoryId==0) {
                $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
            } else {
                $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==0) {
                $('.nav-tabs a[href="#filesVsechno'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==1) {
                $('.nav-tabs a[href="#filesStavba'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==2) {
                $('.nav-tabs a[href="#filesDodavatel'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==3) {
                $('.nav-tabs a[href="#filesZapisky'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==4) {
                $('.nav-tabs a[href="#filesDokumentace'+idProject+'"]').tab('show');
            }
            if (fileCategoryId==5) {
                $('.nav-tabs a[href="#filesDalsi'+idProject+'"]').tab('show');
            }

            for (i=0; i<6; i++) {
                $('#datatablesFiles'+idProject+'_'+i).DataTable({
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
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            $("#tabContent"+idProject).html("Nepodařilo se obnovit panel souborů :( Chyba: "+textStatus);
        });

    });

    request2.fail(function( jqXHR, textStatus ) {
        $("#test").html('Nepodařilo se načíst tabulku verzí. Chyba: '+textStatus);
    });

    $("#tagsUpdateModal").modal('hide');

});