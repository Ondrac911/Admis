<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 20.06.2018
 * Time: 15:37
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if(isset($_POST['token']) && validateHash($_POST['token'], date('H')) && isset($_POST['idDocumentLocal']) ) {
    if (strpos($_POST['idDocumentLocal'], '-') !== false) {
        $file = getFileInfoArr(NULL,$_POST['idDocumentLocal']);
        deleteFile($file['idDocumentLocal']);
    } else
        deleteFile($_POST['idDocumentLocal']);
}