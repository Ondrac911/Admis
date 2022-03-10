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

if (isset($_POST['data'])) {

    $tagColor = getNotUsedColorForTag();
    $arr = json_decode($_POST['data']);
    $dbh = new DatabaseConnector();
    $stmt0 = $dbh->getDbLink()->prepare('DELETE FROM `tags2documents` WHERE idDocument = :idDocument');
    $stmt0->bindParam(':idDocument', $_POST['idDocument'], PDO::PARAM_STR);
    $stmt0->execute();
    foreach ($arr as $tag) {
        if ($tag->text === $tag->id) {
            $stmt = $dbh->getDbLink()->prepare('INSERT INTO `rangeTags` (tagName, author, tagColor) VALUES (:title, :username, :tagColor)');
            $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
            $stmt->bindParam(':title', $tag->text, PDO::PARAM_STR);
            $stmt->bindParam(':tagColor', $tagColor, PDO::PARAM_STR);
            $stmt->execute();
            $idTag = $dbh->getDbLink()->lastInsertId();
        } else {
            $idTag = (int)$tag->id;
        }
        $stmt2 = $dbh->getDbLink()->prepare('INSERT INTO `tags2documents` (idTag, idDocument) VALUES (:idTag, :idDocument)');
        $stmt2->bindParam(':idDocument', $_POST['idDocument'], PDO::PARAM_STR);
        $stmt2->bindParam(':idTag', $idTag, PDO::PARAM_INT);
        $stmt2->execute();
    }
}
