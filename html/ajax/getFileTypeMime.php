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

if (isset($_POST['data'])&&!empty($_POST['data'])) {
    if (substr($_POST['data'],0,1) !== '.')
        $ext = '.'.$_POST['data'];
    else
        $ext = $_POST['data'];
    $dbh = new DatabaseConnector();
    $stmt0 = $dbh->getDbLink()->prepare('SELECT mime FROM `rangeDocumentMimeTypes` WHERE extension = :extension');
    $stmt0->bindParam(':extension', $ext, PDO::PARAM_STR);
    $stmt0->execute();
    $mime = $stmt0->fetchAll();
    if (!empty($mime))
        echo $mime[0]['mime'];
}
