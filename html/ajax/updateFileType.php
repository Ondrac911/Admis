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
if(isset($_POST['token']) && validateHash($_POST['token'], date('H')) && isset($_POST['idDocType']) ) {

    if (substr($_POST['extension'],0,1) !== '.')
        $ext = $_POST['extension'];
    else
        $ext = substr($_POST['extension'], 1);
    if ($_POST['idDocType']!='neni') {
        echo editDocType($_POST['idDocType'], $_POST['name'], $_POST['description'], $ext);
    } else {
        echo createDocType($_POST['name'], $_POST['description'], $ext);
    }
}