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

if (isset($_POST['idAction'])) {
    insertViewedNotification($_POST['idAction']);
}