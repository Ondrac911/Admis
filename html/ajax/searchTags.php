<?php
/**
 * Created by PhpStorm.
 * User: petros
 * Date: 10.05.2019
 * Time: 14:35
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$search = strip_tags(trim($_GET['q']));
$dbh = new DatabaseConnector();
$stmt = $dbh->getDbLink()->prepare("SELECT * FROM rangeTags WHERE tagName LIKE :search AND active = 1 LIMIT 20");
$stmt->execute(array(':search'=>"%".$search."%"));
// Do a quick fetchall on the results
$tagy = $stmt->fetchall(PDO::FETCH_ASSOC);

// Make sure we have a result
if ((count($tagy) > 0)) {
    $arr = array();
    foreach ($tagy as $key => $value) {
        array_push($arr, array('id' => $value['idTag'], 'text' => $value['tagName']));
    }
    $data = $arr;
} else {
    $data[] = array('id' => '0', 'text' => 'Tento štítek není v databázi - bude vytvořen nový štítek', 'disabled' => 'true');
}

// return the result in json
echo json_encode($data);
?>