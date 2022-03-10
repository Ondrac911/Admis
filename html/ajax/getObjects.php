<?php
/**
 * Created by PhpStorm.
 * User: Pham Son Tung
 * Date: 30.07.2019
 * Time: 9:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

$html = '';
if(isset($_POST['idSubtype']) && is_numeric($_POST['idSubtype'])){
    $objects = getObjectsByProjectSubtype($_POST['idSubtype']);
    foreach ($objects as $object){
        $html .="<option value='$object[idObjectType]'>$object[name]</option>";
    }
    echo $html;
}

