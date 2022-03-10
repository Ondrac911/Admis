<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 24.07.2018
 * Time: 15:21
 */
require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if (isset($_POST['name']) && isset($_POST['idProjectType']) && isset($_POST['idPhase'])) {
    logPost($_POST);
    try {
        echo Project::insertProject($_POST,2);
    } catch (Exception $e) {
        $stmt = $dbh->getDbLink()->rollBack();
        $lastId = 'Chyba pri volani funkce insertProject' . $e;
        writeError2Log('submit calling insertProject while editing', $_POST, $e);
    }
}

?>