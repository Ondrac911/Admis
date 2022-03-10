<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.12.2019
 * Time: 9:34
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";

if(isset($_POST['id']) && is_numeric($_POST['id'])){
    $project = new Project($_POST['id']);

    $suspensions = $project->getSuspensions();
    foreach ($suspensions as $suspension){
        $suspension['dateFrom'] = new DateTime($suspension['dateFrom']);
        $suspension['dateFrom']->format('d. m. Y');
        $suspension['dateTo'] = new DateTime($suspension['dateTo']);
        $suspension['dateTo']->format('d. m. Y');
    }
    print_r(json_encode($suspensions));
}