<!-- Modal for Files Uploading -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="uploadFileModalTitle">Nahrajte soubor</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated bg-rose" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
                </div>
                <form action="../../../ajax/fileUploadDropzone.php" class="dropzone" id="newFileUploadDropzone" method="post" enctype="multipart/form-data"></form>
                <label for="fileDescription">* Popis souboru:</label>
                <input class="form-control" id="fileDescription" name="fileDescription" type="text" placeholder="Smlouva s ďáblem"><br>
                <input id="hiddenFileName" type="hidden" name="hiddenFileName" value="noimg">
                <input id="hiddenProjectId" type="hidden" name="hiddenProjectId" value="0">
                <input id="hiddenFileCategoryId" type="hidden" name="hiddenFileCategoryId" value="0">
                <input id="hiddenDocumentId" type="hidden" name="hiddenDocumentId" value="0">
                <input id="hiddenToken" type="hidden" name="hiddenToken" value="<?php echo generateHash(date('H')); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Hotovo</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Version Browsing -->
<div class="modal fade" id="fileVersionBrowsingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg hugeModal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="uploadFileModalTitle">Verze souboru ID <span id="fileIdTitle"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="fileVersionsHere">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for PDF Preview -->
<div class="modal fade" id="pdfVersionPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg hugeModal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pdfVersionPreviewModalTitle">Náhled souboru</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pdfVersionHere" style="height: 70vh">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Assignments Update -->
<div class="modal fade" id="assignmentsUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="assignmentsUpdateTitle">Upravit úkoly projektu ID <span id="assignmentsUpdateProjectId"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="assignmentsUpdateData">Úkoly:</label>
                    <textarea class="form-control" id="assignmentsUpdateData" rows="3"></textarea>
                    <input id="hiddenAssignmentsUpdateProjectId" type="hidden" name="hiddenAssignmentsUpdateProjectId" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít bez uložení</button>
                <button type="button" id="saveAssignment" class="btn btn-success">Uložit</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Tags Update -->
<div class="modal fade" id="tagsUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="tagsUpdateTitle">Upravit štítky souboru ID <span id="tagsUpdateFileId"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <span id="test"></span>
                    <label for="tagsBox">Štítky:</label>
                    <select id="tagsBox" type="text" class="custom-select"></select>
                    <input id="hiddenTagsUpdateFileId" type="hidden" name="hiddenTagsUpdateFileId" value="0">
                    <input id="hiddenTagsUpdateProjectId" type="hidden" name="hiddenTagsUpdateProjectId" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít bez uložení</button>
                <button type="button" id="saveTags" class="btn btn-success">Uložit</button>
            </div>
        </div>
    </div>
</div>