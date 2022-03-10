<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 01.06.2018
 * Time: 13:36
 */
spl_autoload_register('AutoLoader');
function AutoLoader($className)
{
    // What it does?
    // imports files based on the namespace as folder and class as filename.

    $file = str_replace('\\',DIRECTORY_SEPARATOR, $className);
    require_once __DIR__ . "/../classes/".$file . '.php';
}


