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
$title = 'Výpis';



$numberProjectsPage = (isset($_GET['projectsPerPage']))? $_GET['projectsPerPage'] : 10;
$numberOfProjects = getNumberOgFilteredProjects($_GET);
$numberOfPages = numberOfPages(getNumberOgFilteredProjects($_GET)[0], $numberProjectsPage);
if (isset($_GET['active'])){
    $active = $_GET['active'];
}else{
    $active = 1;
}
$strankovacEcho = strankovac(10, $active, $numberOfPages);

?>
<?php include PARTS."startPage.inc"; ?>




                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger card-header-text">
                                <div class="card-text">
                                    <h4 class="card-title">Filtrační parametry</h4>
                                </div>
                            </div>
                            <div class="card-body ">
                                <form method="get" id="filterForm" action="/" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Stavba</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idProjectType" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte druh stavby" tabindex="-98">
                                                           <?php echo selectFilterProjectTypes();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Název</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idProject" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte projekty" tabindex="-98">
                                                            <?php echo selectProjects();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Komunikace</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idCommunication" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte komunikace" tabindex="-98">
                                                            <?php echo selectFilterRoads();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Okres</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idArea" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte okres" tabindex="-98">
                                                            <?php echo selectFilterAreas();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label label-checkbox">Fáze</label>
                                                <?php echo generateCheckboxes(); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Dozor</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="supervisorCompanyId" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte dozor" tabindex="-98">
                                                            <?php echo selectFilterCompaniesByType('supervisor');?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Zhotovitel stavby</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id='buildCompanyId' class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte firmu zhotovitele stavby" tabindex="-98">
                                                            <?php echo selectFilterCompaniesByType('build');?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Zhotovitel projektu</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id='projectCompanyId' class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte firmu zhotovitele projektu" tabindex="-98">
                                                            <?php echo selectFilterCompaniesByType('project');?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Financování</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idFinSource" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte zdroj financování" tabindex="-98">
                                                            <?php echo selectFilterFinSource();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Odpovědná osoba KSÚS</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="editor" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte odpovědnou osobu" tabindex="-98">
                                                            <?php echo selectActiveEditors();?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="dropdown bootstrap-select show-tick dropup col-md-3">
                                    <select form="filterForm" class="selectpicker filterSelect" id="projectsPerPage" name="numberProjectsPerPage" multiple data-max-options="1" title="Vyberte počet projektů na stránku" data-style="select-with-transition">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                    </select>
                                </div>
                                <div>
                                    <button id="myProjectsFilter" class="btn btn-primary ml-auto">Zobrazit moje</button>
                                    <button id="resetFilter" class="btn btn-light">Zobrazit vše</button>
                                    <button id="spreadsheet" class="btn btn-danger">Vygenerovat excel</button>
                                    <button id="startFilter" class="btn btn-danger">Hledat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="d-flex justify-content-center">
                            <a href="newProject.php" class="btn btn-danger">
                                Nový projekt
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 mt-2">
                        <nav class="d-flex justify-content-center">
                            <ul class="pagination ">
                                <?php
                                    echo $strankovacEcho;
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div id="projectList" class="col-lg-12 col-md-12">
                        <?php
                        print_r(generateProjectsListing(getFilteredProjects($_GET,$numberProjectsPage,$active)));
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php
                                    echo $strankovacEcho;
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>

<div class="skupinaModalu">

    <?php  includeFilesFromDirectory(PARTS."/modals/vypis/*.inc",TRUE) ?>

</div>


<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/relationModal.js\"></script>
<script src=\"/js/suspensionModal.js\"></script>
<script src=\"/js/vypis.js\"></script>
<script src=\"/js/files.js\"></script>



";
?>



<?php include PARTS."endPage.inc"; ?>

