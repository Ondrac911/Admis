<?php
/**
 * Created by PhpStorm.
 * User: Pham Son Tung
 * Date: 09.08.2018
 * Time: 9:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

$dbh = new DatabaseConnector();
$project = new Project($_POST['idProject']);
$data = array();
foreach ($project->getDeadlines() as $deadline){
    $pom = $project->getDeadlineByType($deadline['idDeadlineType']);
    $note = (isset($pom['note'])) ? " - ".$pom['note'] : "";
    array_push($data,array(
        'id' => $deadline['idDeadlineType'],
        'title' => $pom['deadlineTypeName'].$note,
        'start' => $pom['value'],
        'allDay' => true
    ));
};

echo json_encode($data);