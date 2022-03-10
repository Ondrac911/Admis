<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 16.08.2019
 * Time: 12:30
 */

namespace ProjectObject;
use \PDO as PDO;

class ObjectFactory
{
    //TODO tohle musí jít nějak líp, objekt s více atributy, jak?
    public static function createObject($idObject)
    {
        $dbh = new \DatabaseConnector();
        $stmt = $dbh->getDbLink()->prepare('SELECT idObjectType, name, idObject, idProject FROM objects WHERE idObject =:idObject LIMIT 1');
        $stmt->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $stmt->execute();
        $instance = $stmt->fetch(PDO::FETCH_ASSOC);
        switch ($instance['idObjectType']) {
            case 1:
                $stmt = $dbh->getDbLink()->prepare('SELECT idAttributeType, value FROM attributes WHERE idObject =:idObject');
                $stmt->bindParam(':idObject', $idObject, PDO::PARAM_INT);
                $stmt->execute();
                return new BridgeObject($instance['idObject'], $instance['idProject'], $instance['name'], $instance['idObjectType'],$stmt->fetchAll(PDO::FETCH_ASSOC));
                break;
        }
        return null;
    }
}
