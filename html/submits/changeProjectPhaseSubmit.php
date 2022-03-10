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
//$_POST['inConcept'] = 0;
if(isset($_POST['inConcept'])) {
    if ($_POST['inConcept'] == 1 OR $_POST['inConcept'] == "1" OR ctype_lower($_POST['inConcept']) == "true") {
        $_POST['inConcept'] = 1;
        $actionType = 14;

    }

    if ($_POST['inConcept'] == 0 OR $_POST['inConcept'] == "0" OR ctype_lower($_POST['inConcept']) == "false") {
        $_POST['inConcept'] = 0;
        $actionType = 3;

    }
    if (isset($_POST['idPhase']) && is_numeric($_POST['idPhase']) && isset($_POST['idProject'])) {
        if (is_numeric($_POST['idProject'])) {
            logPost($_POST);
            //print_r($_POST);
            try {
                echo Project::insertProject($_POST, $actionType);
            } catch (Exception $e) {
                $stmt = $dbh->getDbLink()->rollBack();
                $lastId = 'Chyba pri volani funkce insertProject' . $e;
                writeError2Log('submit calling inssertProject changePHase', $_POST, $e);
            }
        }
    }
}
else {
    echo FALSE;
}


?>