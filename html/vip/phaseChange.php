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
$title = 'Změna fáze projektu';
?>
<?php
if(isset($_GET['idLocalProject']) && is_numeric($_GET['idLocalProject']) && isset($_GET['idProject']) && is_numeric($_GET['idProject'])){
    $idLocalProject = $_GET['idLocalProject'];
    $project = new Project($_GET['idProject']);
    $nextPhase = ((int)$project->baseInformation['idPhase'] <= 5 && (int)$project->baseInformation['idPhase'] > 1)? (int)$project->baseInformation['idPhase'] - 1 : (int)$project->baseInformation['idPhase'];
    $form = generateNextPhaseForm($nextPhase,$project);
}else{
    die();
}
?>
<?php include PARTS."startPage.inc"; ?>


                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <?php print_r(generateProjectsListing(getProject($idLocalProject)));  ?>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger card-header-text">
                                <div class="card-text">
                                    <h4 class="card-title">Změna fáze projektu</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo $form ?>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="skupinaModalu">

                    <?php  includeFilesFromDirectory(PARTS."/modals/phaseChange/*.inc",TRUE) ?>
                    <?php  includeFilesFromDirectory(PARTS."/modals/vypis/*.inc",TRUE) ?>

                </div>
<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/phaseChange.js\"></script>
<script src=\"/js/files.js\"></script>

";
?>
        <?php include PARTS."endPage.inc"; ?>

