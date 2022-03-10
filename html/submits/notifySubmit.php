<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 02.07.2018
 * Time: 10:08
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES.'autoLoader.php';
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);

$_SESSION['notify'] = date('Y-m-d H:i:s');

