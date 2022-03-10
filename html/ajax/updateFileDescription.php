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

if (isset($_POST['idDocument'])&&isset($_POST['description'])) {
    $dbh = new DatabaseConnector();
    $stmt = $dbh->getDbLink()->prepare('UPDATE `projects2documents` a  SET description=:description WHERE idDocument=:idDocument AND version=(SELECT * FROM (select max(version) from `projects2documents` b where b.idDocument=:idDocument) c)');
    $stmt->bindParam(':idDocument', $_POST['idDocument'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
    $stmt->execute();
}