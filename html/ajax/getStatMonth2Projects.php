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
$dataChart = getStatMonth2Projects();
$editor = [];
$series = [];
$series[0] = [];
$peklo = [];
foreach ($dataChart as $chartColumn) {
    array_push($editor, cesky_mesic($chartColumn['mesic']));
    array_push($series[0], $chartColumn['countProjektu']);
}
$peklo = ["labels" => $editor, "series" => $series];
echo json_encode($peklo);