window.load = function () {
    Loader.async = true;
    Loader.load(null, {suggest: true}, createMap);
};

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});

let numCommunications = ($('.selectCommunication').length) - 1;
console.log(numCommunications);
let numAreas = ($('.selectArea').length) - 1;
console.log(numAreas);
let openCommunicationModal = 0;

createMap = function () {
    const center = SMap.Coords.fromWGS84(14.4783250, 50.0490114);
    const map = new SMap(JAK.gel("mapaSeznam"), center, 10);
    const vrstva = new SMap.Layer.Marker();
    //map.getSignals().addListener(window, "map-click", moveMarker);
    map.addDefaultLayer(SMap.DEF_OPHOTO);
    map.addDefaultLayer(SMap.DEF_TURIST);
    map.addDefaultLayer(SMap.DEF_HISTORIC);
    map.addDefaultLayer(SMap.DEF_BASE).enable();
    map.addDefaultLayer(SMap.DEF_SMART_OPHOTO);

    const layerSwitch = new SMap.Control.Layer();
    layerSwitch.addDefaultLayer(SMap.DEF_SMART_OPHOTO);
    layerSwitch.addDefaultLayer(SMap.DEF_BASE);
    layerSwitch.addDefaultLayer(SMap.DEF_TURIST);
    layerSwitch.addDefaultLayer(SMap.DEF_HISTORIC);
    map.addControl(layerSwitch, {left: "8px", top: "9px"});
    map.addLayer(vrstva);
    vrstva.enable();

    const msOpt = SMap.MOUSE_PAN | SMap.MOUSE_WHEEL | SMap.MOUSE_ZOOM;
    map.addDefaultControls();
    map.addControl(new SMap.Control.Mouse(msOpt));


    let inputEl = $('#mapSearch')[0];
    let suggest = new SMap.Suggest(inputEl, {
        provider: new SMap.SuggestProvider({
            updateParams: params => {

                //        tato fce se vola pred kazdym zavolanim naseptavace,
                //     params je objekt, staci prepsat/pridat klic a ten se prida
                //      do url

                let c = map.getCenter().toWGS84();
                params.lon = c[0].toFixed(5);
                params.lat = c[1].toFixed(5);
                params.zoom = map.getZoom();
                params.enableCategories = 1;
                params.lang = "cs,en";
            }
        })
    });

    suggest.addListener("suggest", suggestData => {
        // vyber polozky z naseptavace
        map.setCenter(SMap.Coords.fromWGS84(suggestData.data['longitude'], suggestData.data['latitude']));
        map.setZoom(12);
        console.log(suggestData.data);
    });

    const znacka1 = JAK.mel("div");
    const obrazek1 = JAK.mel("img", {src: SMap.CONFIG.img + "/marker/drop-red.png"});
    const znacka2 = JAK.mel("div");
    const obrazek2 = JAK.mel("img", {src: SMap.CONFIG.img + "/marker/drop-red.png"});
    znacka1.appendChild(obrazek1);
    znacka2.appendChild(obrazek2);

    const popisek1 = JAK.mel("div", {}, {
        position: "absolute",
        left: "0px",
        top: "2px",
        textAlign: "center",
        width: "22px",
        color: "white",
        fontWeight: "bold"
    });
    popisek1.innerHTML = "1";
    znacka1.appendChild(popisek1);


    popisek2 = JAK.mel("div", {}, {
        position: "absolute",
        left: "0px",
        top: "2px",
        textAlign: "center",
        width: "22px",
        color: "white",
        fontWeight: "bold"
    });
    popisek2.innerHTML = "2";
    znacka2.appendChild(popisek2);

    let $gpsE = $('#gpsE_' + openCommunicationModal);
    let $gpsN = $('#gpsN_' + openCommunicationModal);
    let $gpsE2 = $('#gpsE2_' + openCommunicationModal);
    let $gpsN2 = $('#gpsN2_' + openCommunicationModal);

    let gpsEVal = ($gpsE.val() != '') ? $gpsE.val() : 14.2943039;
    let gpsNVal = ($gpsN.val() != '') ? $gpsN.val() : 50.0349000;
    let gpsE2Val = ($gpsE2.val() != '') ? $gpsE2.val() : 14.6019211;
    let gpsN2Val = ($gpsN2.val() != '') ? $gpsN2.val() : 49.9801789;

    const marker1 = new SMap.Marker(SMap.Coords.fromWGS84(gpsEVal, gpsNVal), 1, {url: znacka1});
    const marker2 = new SMap.Marker(SMap.Coords.fromWGS84(gpsE2Val, gpsN2Val), 2, {url: znacka2});

    const modalGps1 = $('#souradniceMapa1');
    const modalGps2 = $('#souradniceMapa2');
    modalGps1.html('');
    modalGps2.html('');

    marker2.decorate(SMap.Marker.Feature.Draggable);
    vrstva.addMarker(marker2);

    marker1.decorate(SMap.Marker.Feature.Draggable);
    vrstva.addMarker(marker1);

    let signals = map.getSignals();
    signals.addListener(window, "marker-drag-stop", stop);
    let markerSwitcher = 0;
    signals.addListener(window, "map-click", function (e) {
        console.log(markerSwitcher);
        let coords = SMap.Coords.fromEvent(e.data.event, map);
        if (parseInt(markerSwitcher) === 0) {
            marker1.setCoords(coords);
            markerSwitcher = 1;
            modalGps1.html(coords.toWGS84(0).toString().replace(/°/g, ''));
            coords = coords.toWGS84(0).toString().split(",");
            $gpsE.val(coords[0].slice(0, -2)).change();
            $gpsN.val(coords[1].slice(0, -2)).change();
        } else if (parseInt(markerSwitcher) === 1) {
            marker2.setCoords(coords);
            markerSwitcher = 0;
            console.log(markerSwitcher);
            modalGps2.html(coords.toWGS84(0).toString().replace(/°/g, ''));
            coords = coords.toWGS84(0).toString().split(",");
            $gpsE2.val(coords[0].slice(0, -2)).change();
            $gpsN2.val(coords[1].slice(0, -2)).change();
        }
    });


    function stop(e) {
        let marker = e.target;
        let id = marker.getId();
        let node = e.target.getContainer();
        node[SMap.LAYER_MARKER].style.cursor = "";
        let coords = e.target.getCoords();
        if (id === 1) {
            modalGps1.html(coords.toWGS84(0).toString().replace(/°/g, ''));
            coords = coords.toWGS84(0).toString().split(",");
            $gpsE.val(coords[0].slice(0, -2)).change();
            $gpsN.val(coords[1].slice(0, -2)).change();
        } else if (id === 2) {
            modalGps2.html(coords.toWGS84(0).toString().replace(/°/g, ''));
            coords = coords.toWGS84(0).toString().split(",");
            $gpsE2.val(coords[0].slice(0, -2)).change();
            $gpsN2.val(coords[1].slice(0, -2)).change();
        }
    }

    /*
    function moveMarker(e, elm){
        let coords = SMap.Coords.fromEvent(e.data.event, map);
        marker.setCoords(coords);
        $('#souradniceMapa').html(coords.toWGS84(0).toString().replace(/°/g,''));
        coords = coords.toWGS84(0).toString().split(",");
        $gpsN.val(coords[0].slice(0,-2));
        $gpsE.val(coords[1].slice(0,-2));
    }
    */
};


tinymce.init({
    selector: '#assignments',
    plugins: "lists",
    toolbar: "undo redo | styleselect | bullist numlist | bold italic ",
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});


$("select[name='idRelationType']").bind('change', function () {
    const $idRelProject = $("select[name='idProjectOrigin']");
    if ($(this).val() == 0) {
        $idRelProject.prop('disabled', true);
        $idRelProject.selectpicker("refresh");
    } else {
        $idRelProject.prop('disabled', false);
        $idRelProject.selectpicker("refresh");
    }
});

$('#postNewProject').bind('click', function (e) {
    e.preventDefault();
    let formData = new FormData($('#newProjectForm')[0]);
    console.log(formData);
    console.log($('form').valid());
    if ($('form').valid()) {
        $.ajax({
            url: '/submits/newProjectSubmit.php',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data, status) {
                console.log(data);
                console.log(status);
                if (status === 'success' && $.isNumeric(data) == true) {
                    swal({
                        title: 'Projekt uložen',
                        text: 'Projekt byl uložen pod ID' + data + '. Chcete přejít do výpisu nebo zůstat na této stránce ?',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Přejít na výpis',
                        cancelButtonText: 'Zůstat zde'
                    }).then(
                        result => {
                            window.location.href = 'vypis.php?idProject=' + data;
                        },
                        dismiss => {
                            window.location.href = 'newProject.php';
                        }
                    );

                    // notify('bottom','right','success','Projekt byl uložen pod ID '+ data);
                } else {
                    notify('bottom', 'right', 'danger', 'Někde se stala chyba, projekt nebyl uložen');
                }
            }, error: function () {
                alert('CHYBA aaa');
            }
        });
    }
});


$('#mapCopyGps').bind('click', function () {
    $('#modalMapa').modal('toggle');
});

let uri = URI(window.location.href);

const $projectType = $("select[name='idProjectType']");
const $projectSubtype = $("#idProjectSubtype");
let areaSelectTemplate = $(".areaSelectWrap").first().clone();
let $roadCommunicationTemplate = $(".communicationFormGroup").first().clone();
let $cyclistCommunicationTemplate = null;

$.ajax({
    url: '/ajax/getCommunicationFormTemplate.php',
    type: "POST",
    cache: false,
    success: function (data) {
        const templates = $.parseJSON(data);
        $roadCommunicationTemplate = $($.parseHTML(templates['roadtCommunicationTemplate']));
        $cyclistCommunicationTemplate = $($.parseHTML(templates['cyclistCommunicationTemplate']));
    }, error: function () {
        alert('CHYBA');
    }
});

let previous = null;
const $communicationWrapper = $('#communicationWrapper');
$projectType.bind('change', function () {
    if ($(this).val() === '3') {
        if (previous !== '3') {
            $communicationWrapper.html($cyclistCommunicationTemplate.clone());
            $(".selectCommunication").last().selectpicker()
        }
        previous = $(this).val();

    } else {
        if (previous === '3') {
            $communicationWrapper.html($roadCommunicationTemplate.clone());
            $(".selectCommunication").last().selectpicker()
        }
        previous = $(this).val();
    }
});


const $objectSelect = $('#objectSelect');
$removeArea = $('#removeArea');
$removeCommunication = $('#removeCommunication');
const $selectArea = $(".selectArea");
$selectArea.selectpicker();
$(".selectCommunication").selectpicker();

$("#addArea").bind('click', function () {
    $("#areaForm").append(areaSelectTemplate.clone());
    numAreas++;
    $(".selectArea").last().val(null);
    $(".selectArea").last().selectpicker();


    if (numAreas > 0) {
        $removeArea.addClass('active');
        $removeArea.removeClass('not-active');
    } else {
        $removeArea.removeClass('active');
        $removeArea.addClass('not-active');
    }

});

if (numAreas > 0) {
    $removeArea.addClass('active');
    $removeArea.removeClass('not-active');
} else {
    $removeArea.removeClass('active');
    $removeArea.addClass('not-active');
}

if (numCommunications > 0) {
    $removeCommunication.addClass('active');
    $removeCommunication.removeClass('not-active');
} else {
    $removeCommunication.removeClass('active');
    $removeCommunication.addClass('not-active');
}


$removeArea.bind('click', function () {
    if (numAreas === 0) {
        e.preventDefault()
    } else {
        $(".areaSelectWrap").last().remove();
        numAreas--;
    }

    if (numAreas > 0) {
        $removeArea.addClass('active');
        $removeArea.removeClass('not-active');
    } else {
        $removeArea.removeClass('active');
        $removeArea.addClass('not-active');
    }
});

$("#addCommunication").bind('click', function () {
    if ($projectType.val() === '3') {
        numCommunications++;
        $communicationWrapper.append($cyclistCommunicationTemplate.clone());
        $(".selectCommunication").last().selectpicker().attr('name', 'communication[' + numCommunications + '][idCommunication]');
        $(".gpsN1").last().attr('name', 'communication[' + numCommunications + '][gpsN1]');
        $(".gpsN1").last().attr('id', 'gpsN_' + numCommunications);
        $(".gpsE1").last().attr('name', 'communication[' + numCommunications + '][gpsE1]');
        $(".gpsE1").last().attr('id', 'gpsE_' + numCommunications);
        $(".gpsN2").last().attr('name', 'communication[' + numCommunications + '][gpsN2]');
        $(".gpsN2").last().attr('id', 'gpsN2_' + numCommunications);
        $(".gpsE2").last().attr('name', 'communication[' + numCommunications + '][gpsE2]');
        $(".gpsE2").last().attr('id', 'gpsE2_' + numCommunications);
        $(".modalMapButton").last().attr('data-idOrderCommunication', numCommunications);

    } else {
        numCommunications++;
        $(".communicationFormGroup").last().after($roadCommunicationTemplate.clone());
        $(".selectCommunication").last().selectpicker().attr('name', 'communication[' + numCommunications + '][idCommunication]');
        $(".stationingFrom").last().selectpicker().attr('name', 'communication[' + numCommunications + '][stationingFrom]');
        $(".stationingTo").last().selectpicker().attr('name', 'communication[' + numCommunications + '][stationingTo]');
        $(".gpsN1").last().attr('name', 'communication[' + numCommunications + '][gpsN1]');
        $(".gpsN1").last().attr('id', 'gpsN_' + numCommunications);
        $(".gpsE1").last().attr('name', 'communication[' + numCommunications + '][gpsE1]');
        $(".gpsE1").last().attr('id', 'gpsE_' + numCommunications);
        $(".gpsN2").last().attr('name', 'communication[' + numCommunications + '][gpsN2]');
        $(".gpsN2").last().attr('id', 'gpsN2_' + numCommunications);
        $(".gpsE2").last().attr('name', 'communication[' + numCommunications + '][gpsE2]');
        $(".gpsE2").last().attr('id', 'gpsE2_' + numCommunications);
        $(".modalMapButton").last().attr('data-idOrderCommunication', numCommunications);
    }

    if (numCommunications > 0) {
        $removeCommunication.addClass('active');
        $removeCommunication.removeClass('not-active');
    } else {
        $removeCommunication.removeClass('active');
        $removeCommunication.addClass('not-active');
    }

});


$removeCommunication.bind('click', function (e) {
    if (numCommunications === 0) {
        e.preventDefault()
    } else {
        $(".communicationFormGroup").last().remove();
        numCommunications--;
    }

    if (numCommunications > 0) {
        $removeCommunication.addClass('active');
        $removeCommunication.removeClass('not-active');
    } else {
        $removeCommunication.removeClass('active');
        $removeCommunication.addClass('not-active')
    }
});

const $addObject = $('#addObject');
$objectSelect.bind('change', function () {
    if ($(this).val() != '') {
        $addObject.addClass('active');
        $addObject.removeClass('not-active');
    } else {
        $addObject.removeClass('active');
        $addObject.addClass('not-active')
    }
});

let numObjects = ($('.objectWrapper').length) - 1;
$addObject.bind('click', function () {
    numObjects++;
    if ($objectSelect.val() != '') {
        $.ajax({
            url: '/ajax/getObjectFormTemplate.php',
            type: "POST",
            cache: false,
            data: {
                objectType: $objectSelect.val(),
                idPhase: $("input[name='idPhase']").val(),
                numObjects: numObjects
            },
            success: function (data, status) {
                const $objectTemplate = $($.parseHTML(data));
                $('#objectWrapper').append($objectTemplate.clone());

            }, error: function () {
                alert('CHYBA');
            }
        });
    }
});


$('#objectWrapper').on('click','.removeObject', function () {
    console.log('bla');
    $(this).parent().parent().remove();
});

$('#modalMapa').on('show.bs.modal', function (e) {
    openCommunicationModal = $(e.relatedTarget).attr('data-idOrderCommunication');
    setTimeout(function () {
        load();
    }, 400);
});


$projectType.bind('change', function () {
    console.log($projectSubtype.attr('name'));
    const val = $(this).val();

    console.log(val);
    //TODO - MP - make it general if it returns empty string...
    if (val == 1 || val == 2 || val == 4) {
        $projectSubtype.val(null);

        $.ajax({
            url: '/ajax/getSubtypesProject.php',
            type: "POST",
            cache: false,
            data: {
                projectType: val
            },
            success: function (data, status) {
                if (status === 'success') {
                    $projectSubtype.prop('disabled', false);
                    $projectSubtype.html(data);
                    $projectSubtype.selectpicker("refresh");
                }
            }, error: function () {
                alert('CHYBA');
            }
        });
    } else {
        $projectSubtype.val(null);
        $projectSubtype.prop('disabled', true);
        $projectSubtype.selectpicker("refresh");
    }
});

$projectSubtype.bind('change', function () {
    const val = $projectSubtype.val();
    console.log(val);
    $.ajax({
        url: '/ajax/getObjects.php',
        type: "POST",
        cache: false,
        data: {
            idSubtype: val
        },
        success: function (data, status) {
            if (data != '') {
                $objectSelect.prop('disabled', false);

                $objectSelect.html(data);
                $objectSelect.selectpicker();
                $objectSelect.selectpicker("refresh");
            } else {
                $objectSelect.prop('disabled', true);
                $objectSelect.selectpicker("refresh");
            }
        }, error: function () {
            alert('CHYBA');
        }
    });
});

$projectSubtype.trigger("change");

const $togglePrePricePDAD = $('#togglePrePricePDAD');
const $mergedPrePricePDAD = $('.prePricePDAD');
const $toMerge = $('.mergedPrice');

$togglePrePricePDAD.on('change',function (){
    if($(this).is(':checked')){
        $toMerge.prop('disabled', true);
        $toMerge.val(null);
        $toMerge.parent().parent().hide(100);
        $mergedPrePricePDAD.prop('disabled', false);
        $mergedPrePricePDAD.parent().parent().show(100);
        //$toMerge.parent().parent().addClass('d-none');
    }else{
        $toMerge.prop('disabled', false);
        $toMerge.parent().parent().show(100);
        $mergedPrePricePDAD.prop('disabled', true);
        $mergedPrePricePDAD.val(null);
        $mergedPrePricePDAD.parent().parent().hide(100);
        //$toMerge.parent().parent().removeClass('d-none');
    }
});


$('.togglePrice').on('change',function() {
    if($(this).is(':checked')){
        $(this).closest('.togglebutton').find("input[type='hidden']").val(1);
    }else{
        $(this).closest('.togglebutton').find("input[type='hidden']").val(0);
    }
});



$togglePrePricePDAD.trigger('change');