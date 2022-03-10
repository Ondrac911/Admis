<?php
/**
 * Created by PhpStorm.
 * User: petros
 * Date: 26.11.2018
 * Time: 9:24
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
require_once SYSTEMINCLUDES . "function.php";

overUzivatele($pristup_zakazan);
if (isset($_POST['token']) && validateHash($_POST['token'], date('H')) && isset($_POST['username'])) {
    if ((int)$_POST['accessDenied']==0)
        $newStatus = 1;
    else
        $newStatus = 0;
    echo changeAccessDeniedUser($_POST['username'],$newStatus);
}