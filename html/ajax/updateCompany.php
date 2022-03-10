<?php

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

if(isset($_POST['name']) ) {
    if (isset($_POST['idCompany'])&&($_POST['idCompany']=='neni')) {
        $arr = ['name' => $_POST['name'],'address'=>$_POST['address'],'ic' => $_POST['ic'],'dic'=>$_POST['dic'],'www'=>$_POST['www']];
        echo insertCompany($arr);
    } else {
        $arr = ['name' => $_POST['name'],'address'=>$_POST['address'],'ic' => $_POST['ic'],'dic'=>$_POST['dic'],'www'=>$_POST['www'], 'idCompany'=>$_POST['idCompany']];
        echo editCompany($arr);
    }
}

