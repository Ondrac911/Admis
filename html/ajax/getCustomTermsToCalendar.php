<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$dbh = new DatabaseConnector();
    $stmt = $dbh->getDbLink()->prepare('SELECT * FROM calendarEvents WHERE username = :user AND `eventStart` >= :start AND `eventEnd` <= :endView AND deleted = 0 OR idOu IN (SELECT idOu FROM users WHERE username = :user) AND `eventStart` >= :start AND `eventEnd` <= :endView AND deleted = 0 OR idOu=-1 AND `eventStart` >= :start AND `eventEnd` <= :endView AND deleted = 0');
    $stmt->bindParam(':user', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->bindParam(':start', $_POST['start'], PDO::PARAM_STR);
    $stmt->bindParam(':endView', $_POST['end'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//return $result;
$events = $result;
$data = array();
//$events = selectProjectTermsForFullCalendar($_POST['start'],$_POST['end']);
foreach ($events as $project) {
    if ($project['idOu']==-1){
        $description = $project['description']."<hr>Událost pro celou KSÚS";
        $color = "#006bb3";
    } elseif ($project['idOu']==0) {
        $description = $project['description']."<hr>Soukromá událost";
        $color = "#999900";
    } else {
        $description = $project['description']."<hr>Událost pro skupinu: ".getOuNameById($project['idOu']);
        $color = "#9c27b0";
    }
    if ($_SESSION['username']!=$project['username']){
        $description .= "<br>Vytvořil: ".getUserAll($project['username'])[0][0];
    }

    if (date('H:i', strtotime($project['eventStart']))=="00:00"){
        $dayEvent = TRUE;
    } else {
        $dayEvent = FALSE;
    }

    $data[] = [
        'id'   => 'customEvent'.$project["idEvent"],
        'title' => $project['title'],
        'start' => date('Y-m-d H:i', strtotime($project['eventStart'])),
        'end' => date('Y-m-d H:i', strtotime($project['eventEnd'])),
        'description' => $description,
        'color' => $color,
        'allDay' => $dayEvent
    ];
}
echo json_encode($data);