<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 24.07.2018
 * Time: 15:21
 */
require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";

overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if (isset($_POST['name']) && isset($_POST['idProjectType']) && isset($_POST['idPhase'])) {
    $date = date('m/d/Y h:i:s a', time());
    $myfile = fopen(SYSTEMLOGS . "/lastInserted.log", "w");
    fwrite($myfile, '\n' . print_r($_POST, true));
    fclose($myfile);
    //print_r($_POST);
    try {
        echo Project::insertProject($_POST);
        //echo 'gay';
    } catch (Exception $e) {
        $stmt = $dbh->getDbLink()->rollBack();
        $lastId = 'Chyba pri volani funkce insertProject' . $e;
        writeError2Log('submit calling insertProject', $_POST, $e);
    }
}

?>