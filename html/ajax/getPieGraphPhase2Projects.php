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
$dataChart = getPieGraphPhase2Projects();
$editor = [];
$series = [];
$colors = [];

$peklo = [];
foreach ($dataChart as $chartColumn) {
    array_push($editor, $chartColumn['name']);
    switch ($chartColumn['name']) {
        case "Záměr":
            $color = "chart-danger";
            break;
        case "V přípravě":
            $color = "chart-rose";
            break;
        case "Připraveno":
            $color = "chart-warning";
            break;
        case "V realizaci":
            $color = "chart-info";
            break;
        case "Zrealizováno":
            $color = "chart-success";
            break;
    }
    array_push($series, array("value" => $chartColumn['countProjektu'], "className" => $color, "meta" => $chartColumn['name']));
}
$peklo = [ "series" => $series];
echo json_encode($peklo);