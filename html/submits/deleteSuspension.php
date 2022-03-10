<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.12.2019
 * Time: 15:27
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";

overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if(isset($_POST) && isset($_POST['idSuspension']) && isset($_POST['idProject'])) {

    if(is_numeric(Project::insertProject($_POST,19))){
        echo Suspension::delete($_POST['idSuspension']);
    }


}
