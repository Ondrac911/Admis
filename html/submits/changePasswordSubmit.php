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

if(isset($_POST['changePassword']) && isset($_POST['oldPass'])  && isset($_POST['newPass'])  && isset($_POST['newPassVerify']) && isset($_POST['username']) && ($_POST['newPass'] == $_POST['newPassVerify'])  && ($_POST['username'] == $_SESSION['username'])){
    if(updateUserPass($_POST['username'],$_POST['oldPass'],$_POST['newPass']) > 0){
        print_r(json_encode(Array('status' => true, 'baseUrl' => getBaseUrl() )));
    }
    else{
        print_r(json_encode(Array('status' => false)));
    }
}
else{
    print_r(json_encode(Array('status' => 'not_complet_post_2_trigger')));
}