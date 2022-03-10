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
$title = 'Detail';
$idProject = NULL;
$project = "";
$mapa = "";
/*$history = "
        <div class='col-lg-12 col-md-12'>
            <div class='card'>
                <div class='card-header card-header-icon card-header-rose'>
                    <div class='card-icon'>
                        <i class='material-icons'>assignment</i>
                    </div>
                    <h4 class='card-title '>Poslední změny</h4>
                </div>
                <div class='card-body'>
                    <div>
                        ".createHistoryTable(getArrActionsLogByInterval())."
                    </div>
                </div>
            </div>
        </div>";
$historyTable = createHistoryTable(getArrActionsLogByInterval());*/
if(isset($_GET['idProject']) && is_numeric($_GET['idProject'])){
    $idProject = $_GET['idProject'];

    if(Project::isActive($idProject)){
        $projectPhase = getProjectPhase($idProject)[0];
        $project = generateProjectsListing(getProject($projectPhase['idLocalProject']));
        $mapa = "
        <div class='col-lg-6 col-md-6'>
            <div class='card'>
                <div class='card-header card-header-icon card-header-success'>
                    <div class='card-icon'>
                        <i class='material-icons'>navigation</i>
                    </div>
                    <h4 class='card-title'>Mapa</h4>
                </div>
                <div class='card-body'>
                    <div id='mapSeznam' style='height:475px'>
                        <div class='box-mapa'>
                            <form>
                                <input type='radio' id='checboxFlyRoute' name='route' checked> Vzdušná čára<br>
                                <input type='radio' id='checboxRoadRoute' name='route' > Trasa<br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        $history = "
        <div class='col-lg-6 col-md-6'>
            <div class='card'>
                <div class='card-header card-header-icon card-header-rose'>
                    <div class='card-icon'>
                        <i class='material-icons'>assignment</i>
                    </div>
                    <h4 class='card-title '>Poslední změny</h4>
                </div>
                <div class='card-body'>
                    <div >
                        ".createHistoryTable(getArrActionsLogByLimit4Project($idProject))."
                    </div>
                </div>
            </div>
        </div>";
    }else{
        $project = " ";
        $mapa = " ";
        $history = "
        <div class='col-lg-12 col-md-12'>
            <div class='card'>
                <div class='card-header card-header-icon card-header-rose'>
                    <div class='card-icon'>
                        <i class='material-icons'>assignment</i>
                    </div>
                    <h4 class='card-title '>Poslední změny</h4>
                </div>
                <div class='card-body'>
                    <div >
                    <h4>Nebyl nalezen žádný projekt</h4>                    
                    </div>
                </div>
            </div>
        </div>";
    }
} else {
    $history = "";
}

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

        <div class="row">
            <div class="col-md-12">
                <form id="TypeValidation" class="form-horizontal" action="detail.php" method="GET">
                    <div class="card ">
                        <div class="card-header card-header-danger card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Hledat detail stavby</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">ID stavby</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="idProject" number="true" required="true" value="<?php echo $idProject ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-danger">Hledat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">

            <?php
                print_r($project);
            ?>

        </div>
        <div class="row">
            <?php
                print_r($history);
            ?>


            <?php
                print_r($mapa);
            ?>
        </div>

<div class="skupinaModalu">

    <?php  includeFilesFromDirectory(PARTS."/modals/vypis/*.inc",TRUE) ?>

</div>

<?php
$customScripts = "";
$customScripts .= "";
?>


<?php include PARTS."endPage.inc"; ?>
<script src="/js/files.js"></script>
<script src="/js/detail.js"></script>
<script src="/js/relationModal.js"></script>
<script src="/js/suspensionModal.js"></script>

<script type="text/javascript">Loader.load()</script>
<script>

$(document).ready(function() {

    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
    });
    $('[data-toggle="tooltip"]').tooltip();
    $("#blokStavbaNew").show('slow');





    if($("#mapSeznam").length) {


        let uri = URI(window.location.href);
        const center = SMap.Coords.fromWGS84(14.41790, 50.12655);
        const m = new SMap(JAK.gel("mapSeznam"), center, 13);
        m.addDefaultControls();

        const layer1 = new SMap.Layer.Geometry('cesta');
        m.addLayer(layer1);
        const layer2 = new SMap.Layer.Geometry('spojnice');
        m.addLayer(layer2).enable();
        $("input[name='route']").bind('click',function () {
            let a = $("input[name='route']:checked").attr('id');
            if(a === "checboxRoadRoute"){
                layer1.enable();
                layer2.disable();


                layer1.getGeometries()
            } else if (a === "checboxFlyRoute"){
                layer2.enable();
                layer1.disable();

            }
        });




        m.addDefaultLayer(SMap.DEF_OPHOTO);
        m.addDefaultLayer(SMap.DEF_TURIST);
        m.addDefaultLayer(SMap.DEF_HISTORIC);
        m.addDefaultLayer(SMap.DEF_BASE).enable();
        m.addDefaultLayer(SMap.DEF_SMART_OPHOTO);

        const layerSwitch = new SMap.Control.Layer();
        layerSwitch.addDefaultLayer(SMap.DEF_SMART_OPHOTO);
        layerSwitch.addDefaultLayer(SMap.DEF_BASE);
        layerSwitch.addDefaultLayer(SMap.DEF_TURIST);
        layerSwitch.addDefaultLayer(SMap.DEF_HISTORIC);
        m.addControl(layerSwitch, {left: "8px", top: "85px"});

        const layer = new SMap.Layer.Geometry();


        m.addLayer(layer);
        layer.enable();


        points1 = [];
        $.ajax({
            url: '/ajax/mapa.php',
            type: "POST",
            data: {
                idProject: uri.search(true).idProject
            },
            async: true,
            success: function (data) {
                const d = $.parseJSON(data);
                console.log(d);
                const layerMarkers = new SMap.Layer.Marker();
                m.addLayer(layerMarkers);
                layerMarkers.enable();
                let coords = [];
                for (const [i,coomunication] of d.communication.entries()) {
                    console.log(coomunication);

                    let cesta = function(route) {
                        try {
                            var body = route.getResults().geometry;
                            var vzhled = {
                                color: lineColor,
                                width: 8,
                                outlineWidth: 0
                            };
                            console.log(i);
                            var g = new SMap.Geometry(SMap.GEOMETRY_POLYLINE, i, body, vzhled);
                            layer1.addGeometry(g);

                        }
                        catch(err) {
                            console.log('krivka nejde')
                        }
                    };
                    let x = SMap.Coords.fromWGS84(coomunication.gpsE1, coomunication.gpsN1);
                    let y = SMap.Coords.fromWGS84(coomunication.gpsE2, coomunication.gpsN2);
                    var body = [x,y];
                    coords.push(x);
                    coords.push(y);
                    console.log(x);
                    console.log(y);



                    let lineColor = "#e53935";

                    switch (d.idPhase) {
                        case '1':
                            lineColor = "#43a047";
                            markerImg = "https://cdn.mapmarker.io/api/v1/pin?&icon=fa-star&size=40&background=43a047&color=FFF";
                            break;
                        case '2':
                            lineColor = "#00acc1";
                            markerImg = "https://cdn.mapmarker.io/api/v1/pin?&icon=fa-star&size=40&background=00acc1&color=FFF";
                            break;
                        case '3':
                            lineColor = "#fb8c00";
                            markerImg = "https://cdn.mapmarker.io/api/v1/pin?icon=fa-star&&size=40&background=fb8c00&color=FFF";
                            break;
                        case '4':
                            lineColor = "#d81b60";
                            markerImg = "https://cdn.mapmarker.io/api/v1/pin?icon=fa-star&&size=40&background=d81b60&color=FFF";
                            break;
                        case '5':
                            lineColor = "#e53935";
                            markerImg = "https://cdn.mapmarker.io/api/v1/pin?icon=fa-star&&size=40&background=e53935&color=FFF";
                            break;
                    }

                    const options1 = {
                        color: lineColor,
                        width: 5,
                        opacity: 1,
                        outlineWidth: 0
                    };
                    if( (body[0].x === body[1].x) && (body[0].y === body[1].y)){
                        let markerOptions = {
                            url:markerImg,
                            anchor: {left:20, bottom: 1}
                        };

                        let marker1 = new SMap.Marker(body[0], i, markerOptions);
                        layerMarkers.addMarker(marker1);

                        m.setCenter(body[0]);
                        m.setZoom(15);
                    }else{
                        new SMap.Route(body, cesta);
                        var a = new SMap.Geometry(SMap.GEOMETRY_POLYLINE, i, body, options1);
                        layer2.addGeometry(a);
                        c = a.computeCenterZoom(m, true);
                        m.setCenter(c[0]);
                        m.setZoom(c[1]);
                    }
                }

                const center = m.computeCenterZoom(coords);
                console.log(coords);
                m.setCenterZoom(center[0],center[1])



            },
            error: function () {
                alert('CHYBA');
            }
        });

    }

    $("#tableHistory").DataTable({
        "language": {
            "url": "/dashboard/assets/js/plugins/locale/Czech.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 7] }
        ],
        "order": [[ 4, "desc" ]]
    });

});


</script>


