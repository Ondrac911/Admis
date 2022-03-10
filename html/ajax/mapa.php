<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 26.11.2018
 * Time: 14:06
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

if(isset($_POST['idProject']) && is_numeric($_POST['idProject'])){
    $project = New Project($_POST['idProject']);
    echo json_encode($project->dumpProject());
}

if(isset($_POST['filtr'])){
    parse_str($_POST['filtr'],$filtr);
    $projects = getFilteredProjects($filtr,10000,1);
    $projectsReturn = [];

    foreach ($projects as $key => $project){
        $projectReturn = [];
        $projectObject = new Project($project['idProject']);
        $projectFull = $projectObject->dumpProject();
        unset($projectFull["company"]);
        unset($projectFull["price"]);
        unset($projectFull["contacts"]);
        unset($projectFull["relations"]);
        unset($projectFull["objects"]);
        unset($projectFull["idArea"]);
        unset($projectFull["deadlines"]);
        $projectFull['subject'] = html_entity_decode($projectFull['subject']);
        $projectFull['change'] = projectLastChangesText($projectFull['idProject']);
        $projectFull['nextTerm'] = showNearestTerm($projectFull['idProject']);

        array_push($projectsReturn,$projectFull);
    }
    print_r(json_encode($projectsReturn));
}