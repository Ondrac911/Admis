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
$fileTypesFce = getFileTypeArr();
$fileTypes = [];
//print_r($fileTypesFce);
foreach ($fileTypesFce as $fileType) {
    array_push($fileTypes , $fileType['name']);
}
echo (json_encode($fileTypes));
