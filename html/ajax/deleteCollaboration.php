<?php
/**
 * Created by PhpStorm.
 * User: petros
 * Date: 10.05.2019
 * Time: 14:35
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if(isset($_POST['token']) && validateHash($_POST['token'], date('H')) && isset($_POST['id']) ) {
    deleteCollaboration($_POST['id']);
}