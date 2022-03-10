<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 20.06.2018
 * Time: 15:37
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if(isset($_GET['idProject'])){
    $project = new Project($_GET['idProject']);
    //$projectPhase = getProjectPhase($idProject)[0];
    //$form = generateCurrentPhaseForm($idProject);
}

$title = "Editace projektu"





?>
<?php include PARTS."startPage.inc"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="modal fade " id="modalMapa" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <h4 class="modal-title col text-center">Vyberte souřadnice</h4>
                                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">clear</i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="form-group col mb-3">
                                        <input id="mapSearch" class="col form-control" type="text" value="" placeholder="Vyhledávání"/>
                                    </div>
                                </div>
                                <div id="mapaSeznam" style="height: 600px"></div>
                                <div class="col-md-12 mt-2 text-center">
                                    <button id="mapCopyGps" class="btn btn-danger">Kopírovat GPS</button>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="d-flex justify-content-center">
                                        <h5><span id="souradniceMapa1"></span></h5>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center">
                                        <h5><span id="souradniceMapa2"></span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <?php print_r(generateProjectsListing(getProject($project->baseInformation['idLocalProject'])));  ?>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger card-header-text">
                                <div class="card-text">
                                    <h4 class="card-title">Editace projektu</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method='post' id='projectForm' action='../submits/editProjectSubmit.php'>
                                    <?php echo $form ?>
                                    <input type="hidden" name="edit" value="1">
                                    <div class="d-flex flex-row-reverse">
                                        <input type='submit' id='formSubmit' class='btn btn-danger btn-wd' value='Uložit změny'>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Modal for Files Uploading -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="Nahrajte soubor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="uploadFileModalTitle">Nahrajte soubor</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../ajax/fileUploadDropzone.php" class="dropzone" id="newFileUploadDropzone" method="post" enctype="multipart/form-data"></form>
                <label for="fileDescription">Popis souboru:</label>
                <input class="form-control" id="fileDescription" name="fileDescription" type="text" placeholder="Smlouva s ďáblem"><br>
                <input id="hiddenFileName" type="hidden" name="hiddenFileName" value="noimg">
                <input id="hiddenProjectId" type="hidden" name="hiddenProjectId" value="0">
                <input id="hiddenFileCategoryId" type="hidden" name="hiddenFileCategoryId" value="0">
                <input id="hiddenDocumentId" type="hidden" name="hiddenDocumentId" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Hotovo</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Version Browsing -->
<div class="modal fade" id="fileVersionBrowsingModal" tabindex="-1" role="dialog" aria-labelledby="Verze souboru" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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

<?php
$customScripts = "";
$customScripts .= "";
?>
<script src="/js/phaseChange.js"></script>
<script src="/js/files.js"></script>

<?php include PARTS."endPage.inc"; ?>
<script type="text/javascript">



</script>

