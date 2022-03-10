<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 2020-03-15
 * Time: 11:01
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."function.php";
require_once SYSTEMINCLUDES."authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";
overUzivatele($pristup_zakazan);


for ($i = 2; $i < 90; $i++) {
    if(file_exists("/var/www/newAdmis.fd.cvut.cz/migrate/projects/$i.json")) {
        $json = file_get_contents("/var/www/newAdmis.fd.cvut.cz/migrate/projects/$i.json");
//$json = str_replace("idSubtypeProject","idProjectSubtype",$json);
        $phpArr = json_decode($json, true);
        $phpArr['mergePricePDAD'] = "0";
//print_r($phpArr);
//print_r(json_encode($phpArr));
        try {
            echo $i . "<br>";
            //Project::insertProject($phpArr);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}