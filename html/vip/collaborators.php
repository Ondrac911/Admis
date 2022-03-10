<?php
$title = "Spolupracovníci";
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 20.06.2018
 * Time: 15:37
 */
require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
//$userInfo = getUserDetails($_SESSION['username']);
?>
<?php include PARTS."startPage.inc"; ?>


<div class="row">
    <div class="col-md-12">
        <div class="card card-profile">
            <div class="card-avatar">
                <a href="#pablo">
                    <img
                        src="data:image/png;base64,<?php print createAvatar(getInitialsFromName($_SESSION['jmeno'])) ?>"/>
                </a>
            </div>
            <div class="card-body">
                <h6 class="card-category text-gray"><?php echo $_SESSION['ou']; ?></h6>
                <h2 class="card-title"><?php echo $_SESSION['jmeno']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-primary">
                <div class="card-icon">
                    <i class="material-icons">info</i>
                </div>
                <h4 class="card-title">Kdo je to spolupracovník?
                </h4>
            </div>
            <div class="card-body">
                Spolupracovník je osoba, kterou si uživatel zvolil jako svého zástupce a umožnil mu editovat a spravovat jemu svěřené projekty a úkoly po určitou dobu. Volí se primárně na období dovolené či pracovní neschopnosti, aby projekty vázané na jeho osobu mohly být v zástupu řešeny.
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon">
                    <i class="material-icons">people</i>
                </div>
                <h4 class="card-title">Přehled mnou zvolených spolupracovníků
                    <btn class="btn btn-primary float-right plusButton" id="newCollaborator" data-toggle="modal" data-target="#collaborator"><i class="fa fa-plus"></i>Vybrat nového spolupracovníka<div class="ripple-container"></div></btn>
                </h4>
            </div>
            <div class="card-body" id="collaboratorTableHere">
                <?php
                getCollaboratorsTable($_SESSION['username']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon">
                    <i class="material-icons">people</i>
                </div>
                <h4 class="card-title">Přehled zastupovaných kolegů <small>(kolegové, kteří si mě nastavili jako spolupracovníka)</small>
                </h4>
            </div>
            <div class="card-body" id="collaboratorTableHere">
                <?php
                getCollaboratorsTableForMe($_SESSION['username']);
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Collaboration -->
<div class="modal fade" id="collaborator" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="uploadFileModalTitle">Vyberte nového spolupracovníka</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newCollaboratorForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="collaborator" class="bmd-label">Jméno spolupracovníka</label>
                                <select name="collaborator" id="collaboratorId" class="selectpicker" data-style="select-with-transition"

                                        title="Vyberte spolupracovníka" tabindex="-98">
                                    <?php echo selectTeammates($_SESSION['username']); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="begin" class="bmd-label-floating">Od</label>
                                <input name="begin" id="begin" type="text" class="form-control datetimepicker" style="margin-left: 20px" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry" class="bmd-label-floating">Do </label>
                                <input name="expiry" id="expiry" type="text" class="form-control datetimepicker" style="margin-left: 20px" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="idCollaboration" id="idCollaboration" value="neni">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="errorMsg" style="color: red; width: 100%;" class="float-right"></div>
                            <button class="btn btn-secondary" data-dismiss="modal">Zavřít bez uložení</button>
                            <button type="submit" id="submitNewCollaborator" class="btn btn-success float-right">Uložit</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>


    <?php
    $customScripts = "";
    $customScripts .= "
<script src=\"/js/collaborators.js\"></script>
";
    ?>


    <?php include PARTS."endPage.inc"; ?>
