<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 13.02.2019
 * Time: 10:03
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if(isset($_POST['projectType']) && is_numeric($_POST['projectType'])){
    print_r(selectProjectSubtypes($_POST['projectType'],null));
}