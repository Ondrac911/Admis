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
$dataChart = getStatsEditor2Projects();
$editor = [];
$series = [];
$series[0] = [];
$peklo = [];
foreach ($dataChart as $chartColumn) {
    $user = getUserAll($chartColumn['editor']);
    array_push($editor, getInitialsFromName($user[0]['name']));
    array_push($series[0], array("value" => $chartColumn['countProjektu'], "meta" => $user[0]['name']));
}
$peklo = ["labels" => $editor, "series" => $series];
echo json_encode($peklo);