<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 31.07.2018
 * Time: 9:41
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";
print_r($_POST);
createRelationArr($_POST);

