<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 12.12.2019
 * Time: 13:57
 */

class Suspension
{
    protected $dbh;
    /*
     *
     * @throws Exception
    */
    public function __construct($dateFrom, $dateTo, $resaon, $source, $comment, $idSuspension = NULL, $idProject = NULL)
    {
        $this->dbh = new DatabaseConnector();
        try{
            $this->dateFrom = new DateTime($dateFrom);
            $this->dateTo = new DateTime($dateTo);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        if($this->dateFrom > $this->dateTo){
            throw new Exception('Suspension date from must be before date to');
        }
        $this->resaonId = $resaon;
        $this->sourceId = $source;
        $this->comment = $comment;
        $this->idSuspension = $idSuspension;
        $this->idProject = $idProject;
    }

    public function getLength(){
        return $this->dateFrom->diff($this->dateTo)->format('%a');
    }

    public function getReason(){
        $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM rangeSuspensionReasons WHERE idSuspensionReason = :idSuspensionReason");
        $stmt->bindParam(':idSuspensionReason', $this->resaonId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
    }

    public function getSource(){
        $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM rangeSuspensionSources WHERE idSuspensionSource = :idSuspensionSource");
        $stmt->bindParam(':idSuspensionSource', $this->sourceId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
    }

    public function createTimeline($begin,$end){
        /*
         * Co když zadá začátek před předáním staveniště
        if($begin > $this->dateFrom){
            $this->dateFrom = $begin;
        }
        */
        $comple = $begin->diff($end)->format('%a');
        $fromBegin = ($begin->diff($this->dateFrom)->format('%a') / $comple) * 100;
        $toEnd = ($this->dateTo->diff($end)->format('%a') / $comple) * 100;
        $suspension = 100 - $fromBegin - $toEnd;
        $barHTML = "
            <div>
            Odstávka: {$this->dateFrom->format('d. m. Y')} - {$this->dateTo->format('d. m. Y')} ({$this->getLength()}) | důvod: {$this->getReason()} | zdroj: {$this->getSource()} | {$this->comment}
            </div>
            <div class='progress'>
                <div class='progress-bar progress-bar-striped bg-dark progress-bar-animated' role='progressbar' style='width: ".$fromBegin."%' aria-valuemin='0' aria-valuemax='100'></div>
                <div class='progress-bar progress-bar-striped bg-info progress-bar-animated' role='progressbar' style='width: ".$suspension."%' aria-valuemin='0' aria-valuemax='100'></div>
                <div class='progress-bar progress-bar-striped bg-dark progress-bar-animated' role='progressbar' style='width: ".$toEnd."%' aria-valuemin='0' aria-valuemax='100'></div>
            </div>";

        return $barHTML;
    }

    public function inInterval($begin, $end){
        return ($begin < $this->dateFrom AND $end > $this->dateTo);
    }

    public function __toString()
    {
        return "from: {$this->dateFrom->format('d/m/Y')}, to: {$this->dateTo->format('d/m/Y')}";
    }

    public static function fromDb($idSuspension){
        $instance = null;
        try {
            $dbh = new DatabaseConnector();
            $stmt = $dbh->getDbLink()->prepare('SELECT idSuspension, idProject, idSuspensionSource, idSuspensionReason, dateFrom, dateTo, comment FROM suspensions WHERE idSuspension =:idSuspension LIMIT 1');
            $stmt->bindParam(':idSuspension', $idSuspension, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $instance = new self($result['dateFrom'], $result['dateTo'], $result['idSuspensionReason'], $result['idSuspensionSource'], $result['comment'], $result['idSuspension'], $result['idProject']);

        } catch (OutOfRangeException $e) {
            echo 'Unknown idLocalProject: ', $e->getMessage(), "\n";
        }

        return $instance;
    }

    public static function insertSuspension($idProject, $idSuspensionSource,$idSuspensionReason,$dateFrom,$dateTo,$comment)
    {
        if(is_numeric($idSuspensionSource) && is_numeric($idSuspensionReason) && is_numeric($idProject)) {
            $dateFrom = strtotime(str_replace('/', '-', $dateFrom));
            $dateTo = strtotime(str_replace('/', '-', $dateTo));
            if ($dateTo > $dateFrom) {
                $dateFrom = date("Y-m-d", $dateFrom);
                $dateTo = date("Y-m-d", $dateTo);
                $comment = htmlspecialchars($comment);

                $dbh = new DatabaseConnector();
                $stmt = $dbh->getDbLink()->prepare('INSERT INTO `suspensions`(`idProject`, `idSuspensionSource`, `idSuspensionReason`, `comment`, `dateFrom`, `dateTo`,username) VALUES (:idProject,:idSuspensionSource,:idSuspensionReason,:comment,:dateFrom,:dateTo,:username)');
                $stmt->bindParam(':idProject', $idProject, PDO::PARAM_INT);
                $stmt->bindParam(':idSuspensionSource', $idSuspensionSource, PDO::PARAM_INT);
                $stmt->bindParam(':idSuspensionReason', $idSuspensionReason, PDO::PARAM_INT);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindValue(':dateFrom', $dateFrom, PDO::PARAM_STR);
                $stmt->bindValue(':dateTo', $dateTo, PDO::PARAM_STR);
                $stmt->bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);


                try {
                    if ($stmt->execute()) {
                        $lastId = true;
                    }
                } catch (exception $e) {
                    $lastId = false;
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                }
                return $lastId;
            }
        }
        return false;

    }

    public static function delete($idSuspension)
    {
        if (is_numeric($idSuspension)) {
            try {
                $dbh = new DatabaseConnector();
                $stmt = $dbh->getDbLink()->prepare('DELETE FROM `suspensions` WHERE idSuspension = :idSuspension');
                $stmt->bindParam(':idSuspension', $idSuspension, PDO::PARAM_INT);
                $stmt->execute();
                $countDeleted = $stmt->rowCount();
                if ($countDeleted > 0) {
                    return true;
                } else {
                    return false;
                }
            }catch
            (Exception $e) {
                writeError2Log(__FUNCTION__, $idSuspension, $e);
                return false;
            }
        }
    }
}