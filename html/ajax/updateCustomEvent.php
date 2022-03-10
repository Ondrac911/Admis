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

if (isset($_POST['idEvent'])&&isset($_POST['delete'])&&($_POST['delete']==0)) {
    $dbh = new DatabaseConnector();
    $stmt = $dbh->getDbLink()->prepare('INSERT INTO `calendarEvents` (username, title, description, eventStart, eventEnd, idOu) VALUES (:username, :title, :description, :eventStart, :eventEnd, :idOu)');
    $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
    $stmt->bindParam(':eventStart', $_POST['eventStart'], PDO::PARAM_STR);
    $stmt->bindParam(':eventEnd', $_POST['eventEnd'], PDO::PARAM_STR);
    $stmt->bindParam(':idOu', $_POST['idOu'], PDO::PARAM_INT);
    $stmt->execute();
    $lastId = $dbh->getDbLink()->lastInsertId();
    $dbh = new DatabaseConnector();
    $stmt2 = $dbh->getDbLink()->prepare('UPDATE `calendarEvents` SET deleted=1,deletedTimestamp=NOW(),deletedAuthor=:username,idEventUpdated=:idEventUpdated WHERE idEvent=:idEvent');
    $stmt2->bindParam(':idEvent', $_POST['idEvent'], PDO::PARAM_INT);
    $stmt2->bindParam(':idEventUpdated', $lastId, PDO::PARAM_INT);
    $stmt2->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $stmt2->execute();
} elseif (isset($_POST['idEvent'])&&isset($_POST['delete'])&&($_POST['delete']==1)) {
    $dbh = new DatabaseConnector();
    $stmt2 = $dbh->getDbLink()->prepare('UPDATE `calendarEvents` SET deleted=1,deletedTimestamp=NOW(),deletedAuthor=:username WHERE idEvent=:idEvent');
    $stmt2->bindParam(':idEvent', $_POST['idEvent'], PDO::PARAM_INT);
    $stmt2->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $stmt2->execute();
}