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
    $form = generateCurrentPhaseForm($project);
}

$title = "Editace projektu"





?>
<?php include PARTS."startPage.inc"; ?>


<div class="modal fade " id="modalMapa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h4 class="modal-title col text-center">Vyberte souřadnice</h4>
                </div>
                <div class="row">
                    <div class="form-group col mb-2">
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
        <?php print_r(generateProjectsListing(getProjectById($project->getId())));  ?>
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
<div class="skupinaModalu">

    <?php  includeFilesFromDirectory(PARTS."/modals/vypis/*.inc",TRUE) ?>
    <?php  includeFilesFromDirectory(PARTS."/modals/phaseChange/addDeadlineModal.inc",TRUE) ?>

</div>
<?php
$customScripts = "<script src=/js/files.js></script>";
$customScripts .= "<script src=/js/editProject.js></script>";
?>

<?php include PARTS."endPage.inc"; ?>



