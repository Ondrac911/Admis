<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.07.2018
 * Time: 13:38
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$title = 'Mapa';
?>
<?php include PARTS."startPage.inc"; ?>
<style>
    .box-mapa{
        position: absolute;
        top:0px;
        z-index:500;
        margin: 8px;
        padding: 10px;
        box-sizing:border-box;
        background-color: white;
        font-size: 13px;
        border: 1px solid #E0E0E0;
        border-radius: 2px;
        color:#6b7580;
    }
</style>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger card-header-text">
                                <div class="card-text">
                                    <h4 class="card-title">Filtrační parametry</h4>
                                </div>
                            </div>
                            <div class="card-body ">
                                <form method="get" action="/" class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label">Stavba</label>
                                                <div class="col col-sm-offset-1">
                                                    <div class="dropdown bootstrap-select show-tick dropup">
                                                        <select id="idTypeProject" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte druh stavby" tabindex="-98">
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
                                                        <select id="idComunication" class="selectpicker filterSelect" data-style="select-with-transition" data-live-search="true" multiple="" title="Vyberte komunikace" tabindex="-98">
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

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button id="resetFilter" class="btn btn-light ml-auto">Zobrazit vše</button>
                                <button id="startFilter" class="btn btn-danger">Hledat</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-danger">
                                <div class="card-icon">
                                    <i class="material-icons">map</i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="mapSeznam" style="height: 80vh">
                                    <div class="box-mapa">
                                        <form>
                                            <input type='radio' id='checboxFlyRoute' name='route' checked> Vzdušná čára<br>
                                            <input type='radio' id='checboxRoadRoute' name='route' > Trasa<br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/mapa.js\"></script>
<script type=\"text/javascript\">Loader.load()</script>
";
?>

<?php include PARTS."endPage.inc"; ?>

