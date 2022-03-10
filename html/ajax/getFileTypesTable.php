<?php
/**
 * Created by PhpStorm.
 * User: Pham Son Tung
 * Date: 09.08.2018
 * Time: 9:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

getFileTypesTable();
