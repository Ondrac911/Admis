<?php
/**
 * Created by PhpStorm.
 * User: petros
 * Date: 26.11.2018
 * Time: 9:24
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

if (isset($_POST['idDocument'])) {
    $tags = getTagsForDocumentId($_POST['idDocument']);
    $arr = array();
    foreach ($tags as $tag) {
        array_push($arr, array('id' => $tag['idTag'], 'text' => $tag['tagName']));
    }
    $data = $arr;
    echo json_encode($data);
}
