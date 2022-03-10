<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 06.08.2019
 * Time: 10:02
 */

class Project
{
    protected $idProject;
    protected $dbh;
    public $baseInformation;
    protected $newProject;

    public function __construct($idProject)
    {
        $this->idProject = $idProject;
        $this->dbh = new DatabaseConnector();
        $stmt = $this->dbh->getDbLink()->prepare('SELECT projects.*,rangeProjectTypes.name as projectTypeName,rangeProjectSubtypes.name as projectSubtypeName,rangePhases.name as phaseName,users.name as editorName 
                                                            FROM projects 
                                                            JOIN rangeProjectTypes USING (idProjectType)
                                                            LEFT JOIN rangeProjectSubtypes USING (idProjectSubtype) 
                                                            JOIN rangePhases USING (idPhase) 
                                                            JOIN users ON projects.editor = users.username
                                                            WHERE idProject =:idProject LIMIT 1');
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_STR);
        $stmt->execute();
        $this->baseInformation = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($this->baseInformation)) {
            //throw new Exception('Could not finish constructing, project doesnt exists');
            //print_r("fff");
            $this->newProject = true;
        } else {
            $this->baseInformation['subject'] = htmlspecialchars_decode($this->baseInformation['subject']);
            $this->newProject = false;

        }
    }

    public function dumpProject($dbh = null)
    {
        $arr2Bak = array();
        $arr2Bak = array_merge($arr2Bak, $this->baseInformation,
            array('idArea' => $this->getArea()),
            array("company" => $this->getCompanies()),
            array('communication' => $this->getCommunication()),
            array('assignments' => $this->getAssignments()),
            array('price' => $this->getPrices()),
            array('deadlines' => $this->getDeadlines()),
            array('contacts' => $this->getContacts()),
            array('relations' => $this->getRelations()),
            array('objects' => $this->getObjectSerialised()),
            array('suspensions' => $this->getSuspensionsDump()));
        return $arr2Bak;

    }

    public function flushProjectsAtts($dbh = null)
    {
        if (is_null($dbh)) {
            $dbh = new DatabaseConnector();
        }
        disableRelation($this->idProject, $dbh);
        $lastId = false;
        $stmt = $dbh->getDbLink()->prepare("
        DELETE FROM `project2area` WHERE idProject = :idProject ;
        DELETE FROM `project2communication` WHERE idProject = :idProject ;
        DELETE FROM `projectRelations` WHERE idProject = :idProject ;
");
        $stmt->bindValue(':idProject', $this->idProject, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $lastId = true;

        }
        return $lastId;
    }

    public function getArea()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT p2a.idArea, ra.name FROM project2area p2a JOIN rangeAreas ra USING (idArea) WHERE idProject =:idProject AND ra.hidden = 0");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCommunication()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT p2c.idCommunication, rc.name, stationingFrom, stationingTo, gpsN1, gpsN2, gpsE1, gpsE2, rc.idCommunicationType, comment	
                                                            FROM project2communication p2c JOIN rangeCommunications rc USING (idCommunication) WHERE idProject =:idProject AND rc.hidden = 0");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPrices()
    {
        $result = null;
        $stmt = $this->dbh->getDbLink()->prepare("SELECT idPriceType, value, rps.name
                                                            FROM prices JOIN rangePriceTypes rps USING(idPriceType) WHERE idProject =:idProject AND rps.hidden = 0");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function getEditor()
    {
        $result = null;
        $stmt = $this->dbh->getDbLink()->prepare("SELECT users.name FROM users JOIN projects ON users.username = projects.editor AND projects.idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC)['name'];
        return $result;
    }

    public function getPricesByType($idPriceType)
    {
        $result = null;
        $stmt = $this->dbh->getDbLink()->prepare("SELECT p.idPriceType, p.value, rpt.name 
                                                            FROM 
                                                            (SELECT idPriceType,name FROM rangePriceTypes WHERE idPriceType =:idPriceType AND hidden = 0) rpt 
                                                            LEFT JOIN prices p ON rpt.idPriceType = p.idPriceType AND idProject = :idProject LIMIT 1");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindValue(':idPriceType', $idPriceType, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Price\ProjectPrice($result['value'], $idPriceType, getVat(), $this->idProject);

    }

    public function getContactByType($idContactType)
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT rct.name as contactTypeName, rc.name, rc.phone, rc.email
                                                            FROM (SELECT idContactType,name FROM rangeContactTypes WHERE idContactType =:idContactType) rct
                                                            LEFT JOIN project2contact p2c ON rct.idContactType = p2c.idContactType AND idProject =:idProject
                                                            LEFT JOIN rangeContacts rc USING(idContact) LIMIT 1");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindValue(':idContactType', $idContactType, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDeadlineByType($idDeadlineType)
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT rdt.name as deadlineTypeName, d.value, rdt.idDeadlineType, note
                                                            FROM (SELECT idDeadlineType,name FROM rangeDeadlineTypes WHERE idDeadlineType =:idDeadlineType) rdt 
                                                            LEFT JOIN deadlines d ON rdt.idDeadlineType = d.idDeadlineType AND idProject =:idProject LIMIT 1");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindValue(':idDeadlineType', $idDeadlineType, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getConstructionDates($monthsOrWeeks = "w")
    {
        if($monthsOrWeeks == "w") {
            $stmt = $this->dbh->getDbLink()->prepare("SELECT projects.constructionTime, DATE(value) as constructionHandoverDate, 
      		CASE 
            	WHEN EXISTS (SELECT * FROM suspensions WHERE suspensions.idProject = deadlines.idProject)
                THEN DATE(DATE_ADD(DATE_ADD(value, INTERVAL (SELECT SUM(DATEDIFF(suspensions.dateTo, suspensions.dateFrom)) FROM suspensions  WHERE suspensions.idProject = deadlines.idProject) DAY), INTERVAL constructionTime WEEK))
                ELSE DATE(DATE_ADD(value, INTERVAL constructionTime WEEK))
              END as constructionDeadline
        
            FROM `deadlines` 
            JOIN projects USING(idProject) 
            WHERE `idProject` = :idProject
            AND deadlines.idDeadlineType = 12");
        }
        if($monthsOrWeeks == "m") {
            $stmt = $this->dbh->getDbLink()->prepare("SELECT projects.constructionTime, DATE(value) as constructionHandoverDate, 
      		CASE 
            	WHEN EXISTS (SELECT * FROM suspensions WHERE suspensions.idProject = deadlines.idProject)
                THEN DATE(DATE_ADD(DATE_ADD(value, INTERVAL (SELECT SUM(DATEDIFF(suspensions.dateTo, suspensions.dateFrom)) FROM suspensions  WHERE suspensions.idProject = deadlines.idProject) DAY), INTERVAL constructionTime MONTH))
                ELSE DATE(DATE_ADD(value, INTERVAL constructionTime WEEK))
              END as constructionDeadline
        
            FROM `deadlines` 
            JOIN projects USING(idProject) 
            WHERE `idProject` = :idProject
            AND deadlines.idDeadlineType = 12");
        }
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getDeadlines()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT * FROM deadlines WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWarrantiesDeadlines()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT deadlines.*, rangeDeadlineTypes.name as name FROM deadlines JOIN rangeDeadlineTypes USING(idDeadlineType) WHERE idProject = :idProject AND idDeadlineType IN (24,25,26) ORDER BY idDeadlineType ASC");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContacts()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT * FROM project2contact WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompanies()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT * FROM project2company WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getObjects()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT *  FROM objects WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $return = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $object) {
            array_push($return, \ProjectObject\ObjectFactory::createObject($object['idObject']));
        };
        return $return;
    }

    private function getObjectSerialised()
    {
        $returnArr = array();

        foreach ($this->getObjects() as $key => $object) {
            $returnArr[$key] = $object->serialise(false);
        }
        return $returnArr;
    }

    public function getAtt()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT attributes.*  FROM attributes JOIN objects USING(idObject) WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttByObj($idObject)
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT attributes.*  FROM attributes JOIN objects USING(idObject) WHERE idProject = :idProject AND idObject = :idObject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRelations()
    {
        $finalArr = [];
        $stmt = $this->dbh->getDbLink()->prepare("SELECT projectRelations.idRelationType, idProjectRelation FROM projectRelations JOIN rangeRelationTypes ON  projectRelations.idRelationType = rangeRelationTypes.idRelationType WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $return = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($return as $key => $eachRelation) {
            if (!array_key_exists($eachRelation['idRelationType'] - 1, $finalArr)) {
                $finalArr[$eachRelation['idRelationType'] - 1] = array(
                    'idRelationType' => $eachRelation['idRelationType'],
                    'idProjectRelation' => array($eachRelation['idProjectRelation'])
                );
            } else {
                array_push($finalArr[$eachRelation['idRelationType'] - 1]['idProjectRelation'],
                    $eachRelation['idProjectRelation']);
            }
        }
        return $finalArr;
    }

    public function getRelations2()
    {
        $finalArr = [];
        $stmt = $this->dbh->getDbLink()->prepare("SELECT projectRelations.idRelationType, idProjectRelation, idProject FROM projectRelations JOIN rangeRelationTypes ON  projectRelations.idRelationType = rangeRelationTypes.idRelationType WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $return1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->dbh->getDbLink()->prepare("SELECT projectRelations.idRelationType, idProjectRelation, idProject FROM projectRelations JOIN rangeRelationTypes ON  projectRelations.idRelationType = rangeRelationTypes.idRelationType WHERE idProjectRelation = :idProject AND relationFromProjectRelation = rangeRelationTypes.idRelationType AND idProject != :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $return2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($return1 as $key => $eachRelation) {
            if (!array_key_exists($eachRelation['idRelationType'], $finalArr)) {
                $finalArr[$eachRelation['idRelationType']] = array(
                    'idProjectRelation' => array($eachRelation['idProjectRelation'])
                );
            } else {
                array_push($finalArr[$eachRelation['idRelationType']]['idProjectRelation'], $eachRelation['idProjectRelation']);

            }
        }

        foreach ($return2 as $key => $eachRelation) {
            if (!array_key_exists($eachRelation['idRelationType'], $finalArr)) {
                $finalArr[$eachRelation['idRelationType']] = array(
                    'idProjectRelation' => array($eachRelation['idProject'])
                );
            } else {
                array_push($finalArr[$eachRelation['idRelationType']]['idProjectRelation'], $eachRelation['idProject']);

            }
        }
        return $finalArr;
    }

    public function getAssignments()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT assignments FROM projectVersions WHERE idProject =:idProject AND idLocalProject =:idLocalProject LIMIT 1");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindParam(':idLocalProject', $this->baseInformation['idLocalProject'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($result['assignments']) && !empty($result['assignments'])) {
            $result = htmlspecialchars_decode($result['assignments']);
        } else {
            $result = "Projekt nemá přiřazený žádný úkol";
        }
        return $result;
    }

    public function getCompanyByType($idCompanyType)
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT p2c.idCompany, rc.name FROM project2company p2c JOIN rangeCompanies rc ON p2c.idCompany = rc.idCompany WHERE idProject =:idProject AND idCompanyType =:idCompanyType LIMIT 1");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindParam(':idCompanyType', $idCompanyType, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result[0])) {
            return $result[0];
        } else {
            return array(
                'idCompany' => null,
                'name' => null
            );
        }
    }

    public function getFinSource()
    {
        if (isset($this->baseInformation['idFinSource'])) {
            $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM rangeFinancialSources WHERE idFinSource = :idFinSource LIMIT 1");
            $stmt->bindParam(':idFinSource', $this->baseInformation['idFinSource'], PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($result['name'])) {
                return $result['name'];
            } else {
                return null;
            }
        }
        return null;

    }

    public function getSuspensions()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT s.*, ss.name as suspensionSourceName, sr.name as suspensionReasonName FROM suspensions s JOIN rangeSuspensionReasons sr ON s.idSuspensionReason = sr.idSuspensionReason JOIN rangeSuspensionSources ss ON s.idSuspensionSource = ss.idSuspensionSource WHERE idProject = :idProject ORDER BY idSuspension");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSuspensionsDump()
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT * FROM suspensions WHERE idProject = :idProject");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRealationsByType($idRelationType)
    {
        $stmt = $this->dbh->getDbLink()->prepare("SELECT idProjectRelation FROM projectRelations WHERE idProject =:idProject AND idRelationType =:idRelationType");
        $stmt->bindParam(':idProject', $this->idProject, PDO::PARAM_INT);
        $stmt->bindParam(':idRelationType', $idRelationType, PDO::PARAM_INT);
        $stmt->execute();
        $return = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $realtion) {
            array_push($return, $realtion['idProjectRelation']);
        }
        return $return;
    }

    public static function insertProject($post, $idActionType = 1)
    {
        require_once "../../includes/function.php";

        if (isset($post) && is_array($post)) {
            //print("insert debug 1");
            require_once "../../includes/autoLoader.php";

            try {
                if (isset($post['inConcept']) && $post['inConcept'] == 1 && isset($post['idPhase'])) {
                    $post['idPhase'] = $post['idPhase'] + 1;
                }
                $dbh = new DatabaseConnector();
                $stmt = $dbh->getDbLink()->beginTransaction();
                if (isset($post['idProject'])) {
                    $newProjectId = $post['idProject'];
                    $existingProject = new Project($post['idProject']);
                    //print_r($existingProject->newProject);
                    if (!$existingProject->newProject) {
                        if (!isset($post['idPhase'])) {
                            $post['idPhase'] = $existingProject->baseInformation['idPhase'];
                        }
                        $jsonPost = json_encode($existingProject->dumpProject());
                        if (isset($post['edit']) && $post['edit'] == 1) {
                            if (!$existingProject->flushProjectsAtts($dbh)) {
                                throw new Exception("Chyba pri cisteni atributu projektu v prilehlych tabulkach DB.");
                            }
                        }
                    } else {
                        $jsonPost = json_encode($post);
                    }
                } else {
                    $newProjectId = lastProjectId() + 1;
                    $jsonPost = json_encode($post);
                }

                if (is_numeric($newProjectId)) {
                    $dumpArr = json_decode($jsonPost, true);

                    $idProjectSutbype = (isset($post['idProjectSubtype'])) ? $post['idProjectSubtype'] : null;
                    //nez se vklada projekt je treba vztvorit jeho prvni verzi abzch dsotal local id project
                    $stmt = $dbh->getDbLink()->prepare("INSERT INTO `projectVersions`(`idPhase`, `assignments`, `idProject`, `created`, `historyDump`,author) VALUES (:idPhase,:assignments,:idProject,NOW(),:historyDump,:author)");
                    $stmt->bindValue(':idPhase', $post['idPhase'], PDO::PARAM_INT);
                    $stmt->bindValue(':assignments', htmlspecialchars(isset($post['assignments']) ? $post['assignments'] : $dumpArr['assignments']), PDO::PARAM_STR);
                    $stmt->bindValue(':idProject', $newProjectId, PDO::PARAM_INT);
                    $stmt->bindValue(':historyDump', $jsonPost, PDO::PARAM_STR);
                    $stmt->bindValue(':author', $_SESSION['username'], PDO::PARAM_STR);

                    $stmt->execute();
                    $lastIdLocal = $dbh->getDbLink()->lastInsertId();
                    if (is_numeric($lastIdLocal) && $lastIdLocal > 0) {
                        //$stmt = $dbh->getDbLink()->beginTransaction();
                        $stmt = $dbh->getDbLink()->prepare("INSERT INTO `projects`(`idProject`, `idProjectType`, `idProjectSubtype`, `created`, `name`, `subject`, `editor`, `author`, `idPhase`, `idLocalProject`,inConcept,deadlineDurUrRequired, deadlineEIARequired,
 deadlineStudyRequired, deadlineTesRequired, mergedDeadlines, idFinSource, ginisOrAthena, noteGinisOrAthena,dateEvidence,constructionTime,constructionTimeWeeksOrMonths,mergePricePDAD, technologyWarrantyPeriod, constructionWarrantyPeriod) 
                    VALUES (:idProject,:idProjectType,:idProjectSubtype,NOW(),:name,:subject,:editor,:author, :idPhase,:idLocalProject,:inConcept, :deadlineDurUrRequired, :deadlineEIARequired, :deadlineStudyRequired, :deadlineTesRequired, :mergedDeadlines, :idFinSource,:ginisOrAthena,
                     :noteGinisOrAthena,:dateEvidence,:constructionTime,:constructionTimeWeeksOrMonths,:mergePricePDAD,:technologyWarrantyPeriod, :constructionWarrantyPeriod
                    
                     ) ON DUPLICATE KEY UPDATE editor = :editor,idProjectType =:idProjectType,idProjectSubtype = :idProjectSubtype, name=:name, subject = :subject, idLocalProject = :idLocalProject, inConcept = :inConcept,
                    deadlineDurUrRequired = :deadlineDurUrRequired, deadlineEIARequired = :deadlineEIARequired, deadlineStudyRequired = :deadlineStudyRequired, deadlineTesRequired = :deadlineTesRequired, mergedDeadlines = :mergedDeadlines,idPhase = :idPhase, idFinSource = :idFinSource,ginisOrAthena = :ginisOrAthena, 
                    noteGinisOrAthena = :noteGinisOrAthena,dateEvidence = :dateEvidence, constructionTime=:constructionTime,constructionTimeWeeksOrMonths = :constructionTimeWeeksOrMonths, mergePricePDAD=:mergePricePDAD, technologyWarrantyPeriod = :technologyWarrantyPeriod, constructionWarrantyPeriod = :constructionWarrantyPeriod");
                        $stmt->bindValue(':idProject', $newProjectId, PDO::PARAM_INT);
                        $stmt->bindValue(':idProjectType', (isset($post['idProjectType']) ? $post['idProjectType'] : $dumpArr['idProjectType']), PDO::PARAM_INT);
                        $stmt->bindValue(':idProjectSubtype', (isset($post['idProjectSubtype']) ? $post['idProjectSubtype'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['idProjectSubtype']))), PDO::PARAM_INT);
                        $stmt->bindValue(':name', (isset($post['name']) ? $post['name'] : $dumpArr['name']), PDO::PARAM_STR);
                        $stmt->bindValue(':subject', htmlspecialchars(isset($post['subject']) ? $post['subject'] : $dumpArr['subject']), PDO::PARAM_STR);
                        $stmt->bindValue(':editor', (isset($post['editor']) ? $post['editor'] : $_SESSION['username']), PDO::PARAM_STR);
                        $stmt->bindValue(':author', $_SESSION['username'], PDO::PARAM_STR);
                        $stmt->bindValue(':idPhase', $post['idPhase'], PDO::PARAM_INT);
                        $stmt->bindValue(':idLocalProject', $lastIdLocal, PDO::PARAM_INT);
                        $stmt->bindValue(':inConcept', (isset($post['inConcept']) ? $post['inConcept'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['inConcept']))), PDO::PARAM_INT);
                        $stmt->bindValue(':deadlineDurUrRequired', (isset($post['deadlineDurUrRequired']) ? $post['deadlineDurUrRequired'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['deadlineDurUrRequired']))), PDO::PARAM_INT);
                        $stmt->bindValue(':deadlineEIARequired', (isset($post['deadlineEIARequired']) ? $post['deadlineEIARequired'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['deadlineEIARequired']))), PDO::PARAM_INT);
                        $stmt->bindValue(':deadlineStudyRequired', (isset($post['deadlineStudyRequired']) ? $post['deadlineStudyRequired'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['deadlineStudyRequired']))), PDO::PARAM_INT);
                        $stmt->bindValue(':deadlineTesRequired', (isset($post['deadlineTesRequired']) ? $post['deadlineTesRequired'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['deadlineTesRequired']))), PDO::PARAM_INT);
                        $stmt->bindValue(':mergedDeadlines', (isset($post['mergedDeadlines']) ? $post['mergedDeadlines'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['mergedDeadlines']))), PDO::PARAM_INT);
                        $stmt->bindValue(':idFinSource', ((isset($post['idFinSource']) && $post['idFinSource'] != "") ? $post['idFinSource'] : ((((isset($post['idPhase']) && $post['idPhase'] == 5) ) ? NULL : $dumpArr['idFinSource']))), PDO::PARAM_INT);
                        $stmt->bindValue(':ginisOrAthena', (isset($post['ginisOrAthena']) ? $post['ginisOrAthena'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['ginisOrAthena']))), PDO::PARAM_STR);
                        $stmt->bindValue(':noteGinisOrAthena', (isset($post['noteGinisOrAthena']) ? $post['noteGinisOrAthena'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['noteGinisOrAthena']))), PDO::PARAM_STR);
                        $stmt->bindValue(':dateEvidence', (isset($post['dateEvidence']) ? $post['dateEvidence'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['dateEvidence']))), PDO::PARAM_INT);
                        $stmt->bindValue(':constructionTime', (isset($post['constructionTime']) ? $post['constructionTime'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['constructionTime']))), PDO::PARAM_INT);
                        $stmt->bindValue(':constructionTimeWeeksOrMonths', (isset($post['constructionTimeWeeksOrMonths']) ? $post['constructionTimeWeeksOrMonths'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['constructionTimeWeeksOrMonths']))), PDO::PARAM_STR);

                        $stmt->bindValue(':mergePricePDAD', (isset($post['mergePricePDAD']) ? $post['mergePricePDAD'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['mergePricePDAD']))), PDO::PARAM_INT);
                        $stmt->bindValue(':constructionWarrantyPeriod', (isset($post['constructionWarrantyPeriod']) ? $post['constructionWarrantyPeriod'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['constructionWarrantyPeriod']))), PDO::PARAM_INT);
                        $stmt->bindValue(':technologyWarrantyPeriod', (isset($post['technologyWarrantyPeriod']) ? $post['technologyWarrantyPeriod'] : ((isset($post['idPhase']) && !isset($post['idProject']) ? NULL : $dumpArr['technologyWarrantyPeriod']))), PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            //jdeme na komunikaci a objekty
                            if (isset($post['idArea']) && !empty($post['idArea']) && is_array($post['idArea'])) {

                                foreach ($post['idArea'] as $eachAreaId) {
                                    if (!insertArea2Project($newProjectId, $eachAreaId, $dbh)) {
                                        throw new Exception('Chyba pri vytvareni kraje');
                                    }
                                }
                            }
                            if (isset($post['communication']) && !empty($post['communication']) && is_array($post['communication'])) {
                                $stmt1 = $dbh->getDbLink()->prepare("DELETE FROM project2communication WHERE idProject = :idProject");
                                $stmt1->bindValue(":idProject", $newProjectId);
                                if ($stmt1->execute()){
                                    foreach ($post['communication'] as $singleRoadArr) {
                                        if (!insertCommunication2Project($newProjectId, $singleRoadArr, $dbh)) {
                                            throw new Exception('Chyba pri vytvareni komunikace');
                                        }
                                    }
                                }
                            }
                            if (isset($post['object']) && is_array($post['object']) && !empty($post['object'])) {
                                foreach ($post['object'] as $eachArrObj) {
                                    if (!insertObject($newProjectId, $eachArrObj, $dbh)) {
                                        throw new Exception('Chyba pri vytvareni objektu a atributu.');
                                    }
                                }
                            }
                            if (isset($post['price']) && is_array($post['price'])) {
                                foreach ($post['price'] as $arrEachPrice) {
                                    if (isset($arrEachPrice['value'])) {
                                        if (!insertPrice($arrEachPrice['idPriceType'], $newProjectId,
                                            $arrEachPrice['value'],
                                            $dbh)) {
                                            throw new Exception('Chyba pri vytvareni cen');
                                        }
                                    }
                                    if (!isset($arrEachPrice['value']) OR empty($arrEachPrice['value'])) {
                                        \Price\ProjectPrice::flushPrice($arrEachPrice['idPriceType'], $newProjectId, $dbh);
                                    }
                                }
                            }
                            if (isset($post['relation']) && is_array($post['relation'])) {
                                foreach ($post['relation'] as $eachRelation) {
                                    if (isset($eachRelation['idProject'])) {
                                        foreach ($eachRelation['idProject'] as $eachProjectIds) {
                                            if (!insertRelation($eachRelation['idRelationType'], $newProjectId,
                                                $eachProjectIds, $dbh)) {
                                                throw new Exception('Chyba pri vytvareni relaci');
                                            }
                                        }
                                    }
                                }
                            }

                            if (isset($post['company']) && is_array($post['company'])) {
                                foreach ($post['company'] as $eachCompanyArr) {
                                    if (is_numeric($eachCompanyArr['idCompany'])) {
                                        if (!insertCompany2Project($newProjectId, $eachCompanyArr['idCompany'], $eachCompanyArr['idCompanyType'], $dbh)) {
                                            throw new Exception('Chyba pri vytvareni firem');
                                        }
                                    }
                                }
                            }

                            if (isset($post['contact']) && is_array($post['contact'])) {
                                foreach ($post['contact'] as $eachContactArr) {
                                    if (!empty($eachContactArr['name'])) {
                                        if (!insertContacts2Project($newProjectId, createContact($eachContactArr['name'], $eachContactArr['email'], $eachContactArr['phone'], $eachContactArr['idCompany']), $eachContactArr['idContactType'], $dbh)) {
                                            throw new Exception('Chyba pri vytvareni kontaktu');
                                        }
                                    }
                                }
                            }

                            if (isset($post['deadlines']) && is_array($post['deadlines'])) {
                                foreach ($post['deadlines'] as $eachDeadlinesArr) {
                                    if (!empty($eachDeadlinesArr['value'])) {
                                        if(isset($post['technologyWarrantyPeriod']) && $eachDeadlinesArr['idDeadlineType'] == 24) {
                                            if (!insertDeadlines2Project($newProjectId, 25, getWarrantyDeadline(new DateTime(str_replace("/","-",$eachDeadlinesArr['value'])), $post['technologyWarrantyPeriod']), isset($eachDeadlinesArr['note']) ? $eachDeadlinesArr['note'] : NULL, $dbh)) {
                                                throw new Exception('Chyba pri vytvareni deadlinu zaruk');
                                            }
                                        }
                                        if(isset($post['constructionWarrantyPeriod']) && $eachDeadlinesArr['idDeadlineType'] == 24) {
                                            if (!insertDeadlines2Project($newProjectId, 26, getWarrantyDeadline(new DateTime(str_replace("/","-",$eachDeadlinesArr['value'])), $post['constructionWarrantyPeriod']), isset($eachDeadlinesArr['note']) ? $eachDeadlinesArr['note'] : NULL, $dbh)) {
                                                throw new Exception('Chyba pri vytvareni deadlinu zaruk');
                                            }
                                        }
                                        if (!insertDeadlines2Project($newProjectId, $eachDeadlinesArr['idDeadlineType'], isset($eachDeadlinesArr['value']) ? $eachDeadlinesArr['value'] : NULL, isset($eachDeadlinesArr['note']) ? $eachDeadlinesArr['note'] : NULL, $dbh)) {
                                            throw new Exception('Chyba pri vytvareni deadlinu');
                                        }
                                    }
                                    if (!isset($eachDeadlinesArr['value']) OR empty($eachDeadlinesArr['value'])) {
                                        flushDeadline($newProjectId, $eachDeadlinesArr['idDeadlineType'], $dbh);
                                    }
                                }
                            }
                        }
                    }
                    insertActionLog($lastIdLocal, $idActionType, $dbh);
                    $stmt = $dbh->getDbLink()->commit();
                    $id = $newProjectId;
                    return $id;
                }
            } catch
            (Exception $e) {
                $stmt = $dbh->getDbLink()->rollBack();
                $lastId = 'Chyba pri vkladani projektu Chyba: ' . $e;
                writeError2Log(__FUNCTION__, $post, $e);
                //  writeError2Log(__FUNCTION__, $dumpArr, $e);
                return false;
            }
        } else {
            return false;
        }

    }


    public
    static function fromIdLocal($idLocalProject)
    {
        $instance = null;
        try {
            $dbh = new DatabaseConnector();
            $stmt = $dbh->getDbLink()->prepare('SELECT idProject FROM projectVersions WHERE idLocalProject =:idLocalProject LIMIT 1');
            $stmt->bindParam(':idLocalProject', $idLocalProject, PDO::PARAM_STR);
            $stmt->execute();
            $instance = new self($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['idProject']);

        } catch (OutOfRangeException $e) {
            echo 'Unknown idLocalProject: ', $e->getMessage(), "\n";
        }

        return $instance;
    }

    public
    static function isActive($idProject)
    {
        $dbh = new DatabaseConnector();
        $stmt = $dbh->getDbLink()->prepare('SELECT idProject FROM viewProjectsActive WHERE idProject =:idProject LIMIT 1');
        $stmt->bindParam(':idProject', $idProject, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    public
    function getId()
    {
        return $this->idProject;
    }

    public
    function getCardTemplate()
    {
        $phases = array(
            "1" => array(
                "assignments",
                "subject",
                "pricePlaning",
                "priceConstruction",
                "projectContractor",
                "constructionOversight",
                "generalContractor",
                "constructionTime",
                "deadlines",
                "objects",
                "externalSystems",
                "warranties"
            ),
            "2" => array(
                "assignments",
                "subject",
                "pricePlaning",
                "priceConstruction",
                "projectContractor",
                "constructionOversight",
                "generalContractor",
                "constructionTime",
                "deadlines",
                "objects",
                "externalSystems"
            ),
            "3" => array(
                "assignments",
                "subject",
                "pricePlaning",
                "contractPriceConstruction",
                "projectContractor",
                "deadlines",
                "objects",
                "externalSystems"
            ),
            "4" => array(
                "assignments",
                "subject",
                "pricePlaning",
                "prePriceConstruction",
                "projectContractor",
                "objects",
                "deadlines"
            ),
            "5" => array(
                "assignments",
                "subject",
                "prePricePlaning",
                "prePriceConstruction",
                "objects"
            ),
        );
        return ($this->baseInformation['inConcept'] == 1) ?  $phases[($this->baseInformation['idPhase']-1)] : $phases[$this->baseInformation['idPhase']];
       // return $phases[$this->baseInformation['idPhase']];
    }
}