<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$events = selectProjectTermsForFullCalendar($_POST['start'],$_POST['end']);
if (empty($events)) {
    $data[] = [];
}
foreach ($events as $project)
{
    $user = getUserAll($project['editor']);
    $data[] = [
        'id' => $project["idProject"] . 'deadlineProject',
        'title' => $project['termName'] . " (ID " . $project['idProject'] . ")",
        'start' => date('Y-m-d', strtotime($project['value'])),
        'description' => $project['name'] . "<br>řešitel: " . $user[0]['name'],
        'allDay' => true,
        'url' => 'detail.php?idProject=' . $project["idProject"],
        'color' => colorByPhase($project['idPhase'])
    ];
}
echo json_encode($data);
?>