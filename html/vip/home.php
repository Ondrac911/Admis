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
$dataDashboard = getDashboardStatsNonGraph();
$title = 'Dashboard';
?>
<?php include PARTS."startPage.inc"; ?>

                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>

                <!-- <button type="button" class="btn btn-round btn-default dropdown-toggle btn-link" data-toggle="dropdown">
                    7 days
                </button> -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-rose">
                                <div class="ct-chart" id="statsEditor2Projects"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Četnost staveb na osobu</h4>
                                <p class="card-category">Graf zobrazuje četnosti jednotlivých staveb na investičního technika KSUS</p>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-success">
                                <div class="ct-chart" id="statMonth2Projects"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Počet přidaných staveb v čase</h4>
                                <p class="card-category">Graf zobrazuje vývoj přidaných staveb v čase za poslední rok</p>

                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-chart">
                            <div class="card-header card-header-info">
                                <div id="statYear2Projects" class="ct-chart"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title ">Počet realizovaných staveb dle roků</h4>
                                <p class="card-category">Vývoj ukončených realizací rozložené v roce</p>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header card-header-icon card-header-danger">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <h4 class="card-title">Počet staveb dle fáze</h4>
                            </div>
                            <div class="card-body">
                                <div id="PieGraphPhase2Projects" class="ct-chart"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-category">Legenda</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <i class="fa fa-circle text-danger"></i> Záměr
                                        <i class="fa fa-circle text-rose"></i> V přípravě
                                        <i class="fa fa-circle text-warning"></i> Připraveno
                                        <i class="fa fa-circle text-info"></i> V realizaci
                                        <i class="fa fa-circle text-success"></i> Zrealizováno
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <p class="card-category">Celková cena staveb - mosty</p>
                                <h3 class="card-title"><?php echo number_format($dataDashboard['cenaMostu'],0,","," "); ?> Kč</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Informace z DB
                                </div>
                            </div>
                        </div>
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <p class="card-category">Celková cena projektů</p>
                                <h3 class="card-title"><?php echo number_format($dataDashboard['cenaStaveb'],0,","," "); ?> Kč </h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Informace z DB
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">store</i>
                                </div>
                                <p class="card-category">Počet novostaveb</p>
                                <h3 class="card-title"><?php echo $dataDashboard['countNovostavby']; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Informace z DB
                                </div>
                            </div>
                        </div>
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">store</i>
                                </div>
                                <p class="card-category">Počet projektů</p>
                                <h3 class="card-title"><?php echo $dataDashboard['countStavebCelkem']; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Informace z DB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-info  ">
                                <div class="card-icon">
                                    <i class="material-icons">calendar_today</i>
                                </div>
                                <h4 class="card-title">Kalendář <small id="infoMyAllEvents" class="float-right"><?php if ((isset($_SESSION['jenMojeProjekty']))&&($_SESSION['jenMojeProjekty']==1)) echo "Přehled termínů <b>u mých projektů</b> (<a id=\"switchMyAllEvents\" href=\"#\">zobrazit všechny stavby</a>)"; else  echo "Přehled termínů <b>u všech projektů</b> (<a id=\"switchMyAllEvents\" href=\"#\">zobrazit jen moje stavby</a>)"; ?></small></h4>
                            </div>
                            <div class="card-body">
                                <div id="fullCalendar"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-category">Legenda</h6>
                                    </div>
                                    <div class="col-md-12">
                                        Termíny projektů:
                                        <i class="fa fa-circle text-danger"></i> Záměr
                                        <i class="fa fa-circle text-rose"></i> V přípravě
                                        <i class="fa fa-circle text-warning"></i> Připraveno
                                        <i class="fa fa-circle text-info"></i> V realizaci
                                        <i class="fa fa-circle text-success"></i> Zrealizováno
                                        <span class="float-right"> Události:
                                        <i class="fa fa-circle text-heavyyellow"></i> Soukromá
                                        <i class="fa fa-circle text-heavyblue"></i> Celá KSÚS
                                        <i class="fa fa-circle text-purple"></i> Organizační jednotka</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-danger  ">
                                <div class="card-icon">
                                    <i class="material-icons">build</i>
                                </div>
                                <h4 class="card-title">Mé stavby</h4>
                            </div>
                            <div class="card-body">
                                <div id="accordion" role="tablist">
                                    <?php echo showUserProjects(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='card'>
                            <div class='card-header card-header-icon card-header-rose'>
                                <div class='card-icon'>
                                    <i class='material-icons'>assignment</i>
                                </div>
                                <h4 class='card-title '>Poslední změny</h4>
                            </div>
                            <div class='card-body'>
                                <div>
                                    <?php echo createHistoryTable(getArrActionsLogByInterval());

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='card'>
                            <div class='card-header card-header-icon card-header-rose'>
                                <div class='card-icon'>
                                    <i class='material-icons'>query_builder</i>
                                </div>
                                <h4 class='card-title '>Projekty kterým vyprší záruka v následujících 3 měsících</h4>
                            </div>
                            <div class='card-body'>
                                <div>
                                    <?php echo createWarrantyTable(getProjectWithIncomingWarranty("MONTH", 3,5));

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<div id="calendarEventModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 class="modal-title">Úprava události</h4>
            </div>
            <div id="" class="modal-body">
                <div class="form-group">
                    <label for="calendarEventModalTitle">Název události</label>
                    <input type="text" class="form-control" id="calendarEventModalTitle" placeholder="Schůzka s pandou" required>
                </div>
                <div class="form-group">
                    <label for="calendarEventModalBody">Popis události</label>
                    <textarea type="text" class="form-control" id="calendarEventModalBody" placeholder="Vzít bambusové sušenky."></textarea>
                </div>
                <div class="form-group">
                    <label for="calendarEventStart">Začátek události</label>
                    <input type="datetime-local" class="form-control" id="calendarEventStart" required>
                </div>
                <div class="form-group">
                    <label for="calendarEventEnd">Konec události</label>
                    <input type="datetime-local" class="form-control" id="calendarEventEnd" required>
                </div>
                <input type="hidden" id="idEvent" value="0">
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button id="saveCustomEventChanges" type="button" class="btn btn-success" style="margin-left: auto; order: 2;">Uložit změny</button>
                        <button id="deleteCustomEvent" type="button" class="btn btn-danger" style="margin-left: auto; order: 2;">Smazat událost</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zavřít beze změn</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/home.js\"></script>
<script>

</script>
";
?>
<?php include PARTS."endPage.inc"; ?>

