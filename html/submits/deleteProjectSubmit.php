<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 25.07.2018
 * Time: 12:43
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if(isset($_GET['deleteProject']) && isset($_GET['idProject']) && isset($_GET['token']) && $_GET['deleteProject'] == 'true'){
        if(validateHash($_GET['token'], $_GET['idProject'])){
            $affectedRows = deleteProject($_GET['idProject']);
            echo (int)$affectedRows;
        }
    
}
else{
    echo "Tady nic neni a nic se nedeje";
}
