<?php

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);

if (isset($_POST['collaborator'])) {
    if (!empty($_POST['collaborator'])) {
        $begin = (!empty($_POST['begin'])) ? date("Y-m-d H:i:s", strtotime($_POST['begin'])) : null;
        $expiry = (!empty($_POST['expiry'])) ? date("Y-m-d H:i:s", strtotime($_POST['expiry'])) : null;
        if ($_POST['idCollaboration']!='neni') {
            editTeammate($_POST['idCollaboration'], $_POST['collaborator'], $expiry, $begin);
            getCollaboratorsTable($_SESSION['username']);
        } else {
            setTeammate($_POST['collaborator'], $expiry, $begin);
            getCollaboratorsTable($_SESSION['username']);
        }
    } else {
        echo "";
    }
}

?>

