<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 25.04.18
 * Time: 18:55
 */

//Definice cest
define('ROOT', str_replace('\\', '/', __DIR__."/../"));

define("PARTS", ROOT."parts/");
define("SYSTEMINCLUDES", __DIR__."/../../includes/");
define("SYSTEMLOGS", __DIR__."/../../logs/");
define('SITETITLE','ADMIS');
define("TMP", ROOT."tmp/");
define("TMP_FILES_PREVIEWS", TMP."filesPreviews/");
define("TMP_FILES_PREVIEWS_JS", "/tmp/filesPreviews/");






//definice proměnných
$developerMode = false; //když probiha vyvojarsky rezim, nebere se zretel na promenou testingmode
//$developerMode = FALSE;
$testingMode = FALSE; //funguje jen, kdyz je developermode false
$testingBranch = FALSE;
//Prepis globalnich promennych
ini_set('display_errors', 'Off'); //ovlivnuje warningy, globalne jsou na serveru errory povoleny,
