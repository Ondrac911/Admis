<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 14.05.2018
 * Time: 9:13
 */
function getBaseUrl()
{
    $baseUrl = "https://newadmis.fd.cvut.cz";
    return $baseUrl;
}

function getConnection(){
    $connectionDb = ["server" => "localhost",
        "userDb" => "admis",
        "passDb" => "wxeZif846Vz45W8q",
        "dbName" => "admis_new"];
    
    return $connectionDb;
}

function getSalt(){
    $salt = 'admisek2019';
    
    return $salt;
}

function getVat(){
    $vat = 0.21;
    return $vat;
}

function getUploadStorage(){
    $uploadDir = "/../uploads";
    $fileSizeLimit = 5000000000;

    return ['uploadDir' => $uploadDir, 'fileSizeLimit' => $fileSizeLimit];
}

