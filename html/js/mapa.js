$(document).ready(function () {

    const url = URI(window.location.href);
    $("#startFilter").bind('click', function () {
        $('select.filterSelect').each(function(){
            uri.removeSearch($(this).attr('id'));
            if ($(this).val()!="") {
                uri.addSearch($(this).attr('id'), $(this).val().join(','));
            }
            var stateObj = {foo: "bar"};
            history.pushState(stateObj, "page 2", uri);
        });
        var checkedBoxes = $('.phaseCheckbox:checked').map(function () {
            return $(this).val();
        }).toArray();
        uri.removeSearch('idPhase');
        console.log("checked boxes: "+checkedBoxes);
        if (checkedBoxes!="") {
            uri.addSearch('idPhase', checkedBoxes.join(','));
        }
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "page 2", uri);
        location.reload();
    });

    $(".phaseCheckbox").change(function (e) {
        var checkedBoxes = $('.phaseCheckbox:checked').map(function () {
            return $(this).val();
        }).toArray();
        url.removeSearch('idPhase');
        url.addSearch('idPhase', checkedBoxes.join(','));
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "page 2", url);
    });


    $("#startFilter").bind('click', function () {
        location.reload();
    });

    $("#resetFilter").bind('click', function () {
        url.removeSearch('supervisorCompanyId');
        url.removeSearch('buildCompanyId');
        url.removeSearch('projectCompanyId');
        url.removeSearch('idComunication');
        url.removeSearch('idTypeProject');
        url.removeSearch('idProject');
        url.removeSearch('idArea');
        // uri.removeSearch('contactSupervisor');
        //uri.removeSearch('contactBuildManager');
        // uri.removeSearch('contactDesigner');
        url.removeSearch('idFinSource');
        url.removeSearch('idPhase');
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "page 2", url);
        location.reload();
    });


    var filters = url.search(true);
    $.each(filters, function (k, v) {
        var values = v.split(',');
        if (k == 'idPhase') {
            $('.phaseCheckbox').prop("checked", false);
            $.each(values, function (a, b) {
                $('.phaseCheckbox:checkbox[value=' + b + ']').prop("checked", true);
            })
        } else {
            $("#" + k).selectpicker('val', values);
        }
    });


    const uri = URI(window.location.href);
    const center = SMap.Coords.fromWGS84(14.41790, 50.12655);
    const m = new SMap(JAK.gel("mapSeznam"), center, 13);
    m.addDefaultControls();

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

    const layer1 = new SMap.Layer.Geometry('cesta');
    m.addLayer(layer1);
    const layer2 = new SMap.Layer.Geometry('spojnice');
    m.addLayer(layer2).enable();
    const layerMarkers = new SMap.Layer.Marker();
    m.addLayer(layerMarkers);
    layerMarkers.enable();
    pointsAll = [];

    $("input[name='route']").bind('click',function () {
        let a = $("input[name='route']:checked").attr('id');
        if(a === "checboxRoadRoute"){
            layer1.enable();
            layer2.disable();
        } else if (a === "checboxFlyRoute"){
            layer1.disable();
            layer2.enable();
        }
    });


    let full;
    $.ajax({
        url: '/ajax/mapa.php',
        type: "POST",
        data: {
            filtr: uri.query()
        },
        async: false,
        success: function (data) {
            $projects = $.parseJSON(data);
            full = $.parseJSON(data);


        },
        error: function () {
            alert('CHYBA');
        }
    });

    $.each(full, function( key, value ) {
        console.log();
        let lineColor = "#e53935";
        let markerImg = "https://cdn.mapmarker.io/api/v1/pin?&size=40&background=43a047&color=FFF&hoffset=-1";

        switch ($projects[key].idPhase) {
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

        let options = {
            color: lineColor,
            width: 5,
            opacity: 1,
            outlineWidth: 0
        };

        let markerOptions = {
            url:markerImg,
            anchor: {left:20, bottom: 1}
        };

        for (const [i,coomunication] of $projects[key].communication.entries()) {
            let c = new SMap.Card();

            c.setSize(450, 350);
            c.getHeader().innerHTML = "<h4 class='font-weight-bold'>"+$projects[key].name +" (ID "+$projects[key].idProject + ")</h4>";
            c.getFooter().innerHTML = "<a class='btn btn-rose w-100' href='detail.php?idProject="+$projects[key].idProject+"'>Přejít na projekt ID "+$projects[key].idProject+" <i class='fa fa-sign-in' data-toggle='tooltip' data-placement='left' data-original-title='Přejít na detail projektu ID "+$projects[key].idProject+"'></i></a>";
            c.getBody().innerHTML = "<div>Řešitel:</div><p>"+$projects[key].editorName+"</p><div>Předmět stavby:</div> "+$projects[key].subject+"<div>Úkoly:</div> "+$projects[key].assignments+"<p>"+$projects[key].nextTerm+"</p><p>"+$projects[key].change+"</p>";

            let x = SMap.Coords.fromWGS84(coomunication.gpsE1, coomunication.gpsN1);
            let y = SMap.Coords.fromWGS84(coomunication.gpsE2, coomunication.gpsN2);
            points = [x, y];
            pointsAll.push(x);
            pointsAll.push(y);

            let marker1 = new SMap.Marker(x, key+"x_"+i, markerOptions);
            let marker2 = new SMap.Marker(y, key+"y_"+i, markerOptions);

            marker1.decorate(SMap.Marker.Feature.Card, c);
            marker2.decorate(SMap.Marker.Feature.Card, c);
            layerMarkers.addMarker(marker1);
            layerMarkers.addMarker(marker2);
            if((coomunication.gpsN1 != coomunication.gpsN2) && (coomunication.gpsE1 != coomunication.gpsE2)){
                var a = new SMap.Geometry(SMap.GEOMETRY_POLYLINE, value.idProject+"_"+i, points, options);
                layer2.addGeometry(a);
                oznacCestu(value.idProject+"_"+i,coomunication.gpsN1,coomunication.gpsE1,coomunication.gpsN2,coomunication.gpsE2,options,c, layer1);

            }

        }

    });

    a = m.computeCenterZoom(pointsAll, true);
    m.setCenter(a[0]);
    m.setZoom(a[1]);



    m.getSignals().addListener(this, "geometry-click", function(e) {
        // vybrany marker
        let polyline = e.target;
        let id = polyline.getId();
        // zobrazime jeho jmeno - parovani vybraneho markeru pomoci jeho id a nasich vstupnich dat
        //window.location.replace("https://admis.fd.cvut.cz/vip/detail.php?idProject="+id);
    });

    function oznacCestu(id, odN, odE,  doN, doE, options,c, layer){
        var cesta = function(route) {
            var body = route.getResults().geometry;
            var g = new SMap.Geometry(SMap.GEOMETRY_POLYLINE, id, body, options);
            layer.addGeometry(g);
            g.decorate(SMap.Geometry.Feature.Card, c);
        };

        var body1 = [
            SMap.Coords.fromWGS84(odE, odN),
            SMap.Coords.fromWGS84(doE, doN)
        ];

        new SMap.Route(body1, cesta);

    }

    $('[data-toggle="tooltip"]').on('mouseleave', function () {
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('.tooltip').tooltip('dispose');
    });
    $('[data-toggle="tooltip"]').tooltip();


});



