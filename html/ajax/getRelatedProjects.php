<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 26.03.2019
 * Time: 16:19
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
require_once SYSTEMINCLUDES."function.php";
overUzivatele($pristup_zakazan);

if(isset($_POST['idProject']) && is_numeric($_POST['idProject'])){
    $project = new Project($_POST['idProject']);
    print json_encode($project->getRelations2());
}

