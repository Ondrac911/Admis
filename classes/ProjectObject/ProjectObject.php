<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 16.08.2019
 * Time: 10:07
 */
namespace ProjectObject;

class ProjectObject
{
    protected $name;
    protected $idObjectType;
    protected $idObject;
    protected $idProject;

    public function __construct($idObject, $idProject, $name, $idObjectType)
    {
        $this->name = $name;
        $this->idObjectType = $idObjectType;
        $this->idObject = $idObject;
        $this->idProject = $idProject;
    }

    public function getName(){
        return $this->name;
    }

    public function getIdObjectType(){
        return $this->idObjectType;
    }

    public function getId(){
        return $this->idObject;
    }

    public function getIdProject(){
        return $this->idProject;
    }
}
