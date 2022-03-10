<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 26.07.2018
 * Time: 13:40
 */
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

echo generateProjectsListing(getFilteredProjects());