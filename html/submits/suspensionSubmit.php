<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 13.11.2019
 * Time: 9:53
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";

overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if(isset($_POST) && isset($_POST['idSuspensionSource'])){


   echo Suspension::insertSuspension($_POST['idProject'],$_POST['idSuspensionSource'],$_POST['idSuspensionReason'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['comment']);

}