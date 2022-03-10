<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."function.php";
require_once SYSTEMINCLUDES."authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";
overUzivatele($pristup_zakazan);

if (!empty($_FILES)) {
// echo sys_get_temp_dir();
    if (((int)$_POST['idDocument'] != 0)) {
        updateFileUpload($_FILES, (int)$_POST['projectId'], $_POST['idDocument'], (int)$_POST['idDocumentCategory']);
    }
    else {
        newFileUpload($_FILES, (int)$_POST['projectId'], (int)$_POST['idDocumentCategory']);
    }
}

?>