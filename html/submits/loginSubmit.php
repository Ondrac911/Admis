<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 02.07.2018
 * Time: 10:08
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES.'autoLoader.php';

if(isset($_POST['username']) && isset($_POST['pass']) ) {
    $login = new Login($_POST['username'], $_POST['pass']);
}