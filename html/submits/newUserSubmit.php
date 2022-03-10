<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 03.01.2020
 * Time: 10:54
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
require_once SYSTEMINCLUDES . "function.php";


if(isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] == $_POST['passwordConfirm'])){
    $escapesValuesArr = htmlspecialcharsArr($_POST);
    $user = new User($escapesValuesArr['username'], $escapesValuesArr['name'],$escapesValuesArr['email'],$escapesValuesArr['idRoleType'],$escapesValuesArr['idOu'],User::encryptPassword($_POST['password']));
    echo $user->toDb();
}