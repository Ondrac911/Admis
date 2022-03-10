<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 20.06.2018
 * Time: 15:37
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if(isset($_GET['token']) && validateHash($_GET['token'], date('H')) ) {
    if(!isset($_GET['preview']) OR $_GET['preview'] == 'FALSE') {
        if (isset($_GET['idDocumentLocal']) && is_numeric($_GET['idDocumentLocal'])) {
            downloadFile($_GET['idDocumentLocal']); //prvni argument je pokud mas iddocument local, druhe kdyz mas jes id dcoumentu (stahne nejaktualnejsi verzi, a treti argument je pokud mas jen nazev souboru,
        } elseif (isset($_GET['idDocument'])) {
            $check = explode("-", $_GET['idDocument']);
            if (is_numeric($check[0]) && is_numeric($check[1]) && count($check) == 2) {
                downloadFile(null, $_GET['idDocument'], null); //prvni argument je pokud mas iddocument local, druhe kdyz mas jes id dcoumentu (stahne nejaktualnejsi verzi, a treti argument je pokud mas jen nazev souboru,
            }
        } elseif (isset($_GET['fileName'])) {
            downloadFile(null, null, $_GET['fileName']); //prvni argument je pokud mas iddocument local, druhe kdyz mas jes id dcoumentu (stahne nejaktualnejsi verzi, a treti argument je pokud mas jen nazev souboru,
        }
    }
    elseif (isset($_GET['preview']) && $_GET['preview'] == 'TRUE'){
        getPreviewFile($_GET['idDocumentLocal']);
    }
}
else{
    //getPreviewFile($_GET['idDocumentLocal']);
    echo "Chyba zabezpeceni, neplatny token.";
}
