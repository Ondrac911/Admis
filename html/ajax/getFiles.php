<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 12.10.18
 * Time: 9:42
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";
if(isset($_GET['panel']) && $_GET['panel'] == 'TRUE' && isset($_GET['id']) && is_numeric($_GET['id'])){
    generateFilesPanel($_GET['id'],'panel');
}
elseif(isset($_GET['tab']) && $_GET['tab'] == 'TRUE' && isset($_GET['id']) && is_numeric($_GET['id'])){
    generateFilesPanel($_GET['id'],'tab');
}
else{
    echo 'Chyba proměnných';
}
