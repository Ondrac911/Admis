<?php
/**
 * Created by PhpStorm.
 * User: Pham Son Tung
 * Date: 30.07.2019
 * Time: 9:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

if(isset($_POST['objectType']) && is_numeric($_POST['objectType']) && isset($_POST['numObjects']) && is_numeric($_POST['numObjects']) && isset($_POST['idPhase'])){
    if($_POST['objectType'] == 1){
        $html = ProjectObject\BridgeObject::htmlFormEmpty($_POST['numObjects'],$_POST['idPhase']);
    }
}

echo $html;