<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 31.07.2018
 * Time: 9:41
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";

if(isset($_POST['editProfile']) && isset($_POST['username']) && ($_POST['username'] == $_SESSION['username'])){
    $result = updateUsersInfo($_POST['username'],$_POST);
    if($result == 1){
        $db = new DatabaseConnector();
        $stmt = $db->getDbLink()->prepare("SELECT users.*, ou.name AS skupina FROM users JOIN ou USING (idOu) WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();

        $vysledek = $stmt->fetch();

        $_SESSION['email'] = $vysledek['email'];
        $_SESSION['jmeno'] = $vysledek['name'];
        $_SESSION['ou'] = $vysledek['skupina'];

    }
    echo $result;
}