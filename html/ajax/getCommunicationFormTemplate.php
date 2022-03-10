<?php
/**
 * Created by PhpStorm.
 * User: Pham Son Tung
 * Date: 30.07.2019
 * Time: 9:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

$cyclistCommunicationTemplate ="<div class='communicationFormGroup'>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                        <span class='input-group-text'>
                                          <i class='material-icons'>theaters</i>
                                        </span>
                                        </div>
                                        <div class='form-group col'>
                                            <div class='dropdown bootstrap-select show-tick dropup'>
                                                <label for='assignments' class='bmd-label-floating'>Název cyklostezky</label>
                                                <input type='text' rows='5' class='form-control' id='' name='communication[0][comment]'></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                        <span class='input-group-text'>
                                          <i class='material-icons'>theaters</i>
                                        </span>
                                        </div>
                                        <div class='form-group col'>
                                            <div class='dropdown bootstrap-select show-tick dropup'>
                                                <select class='selectCommunication' data-style='select-with-transition' name='communication[0][idCommunication]' required data-live-search='true' title='Vyberte páteřní cyklostezku' tabindex='-98'>
                                                    ". selectRoads(null,"3") ."
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>
                                              <i class='material-icons'>gps_fixed</i>
                                            </span>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS E 1</label>
                                            <input type='number' id='gpsE_0' class='form-control gpsE1' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsE1]' required>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS N 1</label>
                                            <input type='number' id='gpsN_0' class='form-control gpsN1' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsN1]' required>
                                        </div>
    
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>
                                              <i class='material-icons'>gps_fixed</i>
                                            </span>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS E 2</label>
                                            <input type='number' id='gpsE2_0' class='form-control gpsE2' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsE2]' required>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS N 2</label>
                                            <input type='number' id='gpsN2_0' class='form-control gpsN2' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsN2]' required>
                                        </div>
                                    </div>
                                    <div class='m-4 btn btn-danger modalMapButton' data-toggle='modal' data-idOrderCommunication=0 data-num='0' data-target='#modalMapa'>
                                        Mapa
                                    </div>
                                </div>";

$roadCommunicationTemplate ="<div class='communicationFormGroup'>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                        <span class='input-group-text'>
                                          <i class='material-icons'>theaters</i>
                                        </span>
                                        </div>
                                        <div class='form-group col'>
                                            <div class='dropdown bootstrap-select show-tick dropup'>
                                                <select class='selectCommunication' data-style='select-with-transition' name='communication[0][idCommunication]' required data-live-search='true' title='Vyberte komunikaci' tabindex='-98'>
                                                    ". selectRoads(null,"1,2")."
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                        <span class='input-group-text'>
                                          <i class='material-icons'>navigation</i>
                                        </span>
                                        </div>
                                        <div class='form-group col'>
                                            <label for='stationingFrom' class='bmd-label-floating'>Staničení od</label>
                                            <input type='number' step='any' class='form-control stationingFrom' name='communication[0][stationingFrom]' required>
                                        </div>
                                        <div class='form-group col'>
                                            <label for='stationingTo' class='bmd-label-floating'>Staničení do</label>
                                            <input type='number' step='any' class='form-control stationingTo' name='communication[0][stationingTo]' required>
                                        </div>
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>
                                              <i class='material-icons'>gps_fixed</i>
                                            </span>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS E 1</label>
                                            <input type='number' id='gpsE_0' class='form-control gpsE1' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsE1]' required>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS N 1</label>
                                            <input type='number' id='gpsN_0' class='form-control gpsN1' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsN1]' required>
                                        </div>
                                    </div>
                                    <div class='input-group form-control-md'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text'>
                                              <i class='material-icons'>gps_fixed</i>
                                            </span>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS E 2</label>
                                            <input type='number' id='gpsE2_0' class='form-control gpsE2' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsE2]' required>
                                        </div>
                                        <div class='form-group col'>
                                            <label class='bmd-label-floating'>GPS N 2</label>
                                            <input type='number' id='gpsN2_0' class='form-control gpsN2' pattern='[0-9]+([\.,][0-9]+)?' step='any' name='communication[0][gpsN2]' required>
                                        </div>
                                    </div>
                                    <div class='m-4 btn btn-danger modalMapButton' data-toggle='modal' data-idOrderCommunication=0 data-num='0' data-target='#modalMapa'>
                                        Mapa
                                    </div>
                                </div>";

echo json_encode(array(
    'cyclistCommunicationTemplate' => $cyclistCommunicationTemplate,
    'roadtCommunicationTemplate' => $roadCommunicationTemplate
));