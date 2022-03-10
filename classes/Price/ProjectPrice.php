<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.01.2020
 * Time: 14:07
 */

namespace Price;


class ProjectPrice extends Price
{
    protected $idProject;

    public function __construct($value, $type, $tax, $idProject)
    {
        parent::__construct($value, $type, $tax);
        $this->idProject = $idProject;
    }

    public static function flushPrice($idPriceType, $idProject, $dbh = null)
    {
        if (is_null($dbh)) {
            $dbh = new \DatabaseConnector();
        }
        $lastId = false;
        if (is_numeric($idProject)) {
            $stmt = $dbh->getDbLink()->prepare("
            DELETE FROM `prices` WHERE idProject = :idProject AND idPriceType = :idPriceType;
            ");
            $stmt->bindValue(':idPriceType', $idPriceType, \PDO::PARAM_INT);
            $stmt->bindValue(':idProject', $idProject, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $lastId = true;
            }
        }
        return $lastId;
    }
}