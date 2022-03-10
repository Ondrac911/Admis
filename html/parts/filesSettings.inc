<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">file_copy</i>
                </div>
                <div class="row">
                    <h4 class="card-title"> Správa souborů</h4>
                    <button class="btn btn-primary ml-auto mt-3 new-file-type"><i class="fa fa-plus"></i>  Přidat nový typ souborů</button>
                </div>
                <div>
                    <h5 class="card-subtitle text-muted">Seznam povolených typů souborů pro nahrávání v aplikaci ADMIS a jejich přípon.</h5>
                </div>
            </div>
            <div class="card-body" id="filesTypeTable">
                <?php
                  getFileTypesTable();
                ?>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

<!-- Modal for Files Uploading -->
<div class="modal fade" id="filesTypesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="filesTypesModalTitle">Vyberte parametry povoleného typu souborů</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="fileTypeExtension">* Přípona souborů:</label>
                <input class="form-control" id="fileTypeExtension" name="fileTypeExtension" type="text" placeholder=".txt"><br>
                <label for="fileTypeDescription">* Popis souboru:</label>
                <input class="form-control" id="fileTypeDescription" name="fileTypeDescription" type="text" placeholder="Textový dokument"><br>
                <label for="fileMIME">* Označení MIME:</label>
                <input class="form-control" id="fileMIME" name="fileMIME" type="text" placeholder="text/plain"><br>
                <input id="hiddenFileTypeId" type="hidden" name="hiddenFileTypeId" value="0">
                <input id="hiddenToken" type="hidden" name="hiddenToken" value="<?php echo generateHash(date('H')); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Zavřít bez uložení</button>
                <button type="button" class="btn btn-success" id="saveFileType">Uložit</button>
            </div>
        </div>
    </div>
</div>