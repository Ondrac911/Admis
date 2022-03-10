<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 16.08.2019
 * Time: 12:33
 */

namespace ProjectObject;

class BridgeObject extends ProjectObject implements ObjectInterface
{
    private $attributes;

    public function __construct($idObject, $idProject, $name, $idObjectType, $attributes)
    {
        parent::__construct($idObject, $idProject, $name, $idObjectType);
        $this->attributes = $attributes;
    }

    public function getPrice()
    {
        //TODO Předělat
        return $this->attributes[0]['value'] ?? "Nezadaná";
    }

    private function getPriceAttributeId()
    {
        //TODO Předělat
        return $this->attributes[0]['idAttributeType'];
    }

    public function serialise($json)
    {
        $result = array(
            "idObject" => $this->getId(),
            "idObjectType" => $this->getIdObjectType(),
            "idProject" => $this->getIdProject(),
            "name" => $this->getName(),
            "attribute" => $this->attributes
        );

        if ($json) {
            $result = json_encode($result);
        }
        return $result;
    }

    public function htmlCard($style, $idPhase){
        $html = '';
        foreach (BridgeObject::getAttributeTemplateByPhase($idPhase) as $key => $priceType) {
            $price = ($this->getAttributeValueByType($priceType['idAttribute']) != null)?$this->getAttributeValueByType($priceType['idAttribute']) : '';
            $html.= $priceType['name'].": ".(is_numeric($price) ? number_format($price,2, ',', ' ') : $price)." Kč <br>";
        }

        return "<div class='col'>
                    <div class='card'>
                        <div class='card-header card-header-text card-header-$style'>
                            <div class='card-text'>
                                <h4 class='card-title'>Most - ".$this->getName()."</h4>
                            </div>
                        </div>
                        <div class='card-body'>
                            $html
                        </div>
                    </div>
                </div>";
    }

    public static function getAttributeTemplateByPhase($idPhase){
        $dbh = new \DatabaseConnector();
        $stmt = $dbh->getDbLink()->prepare('SELECT idAttribute, rangeAttributeTypes.name FROM objectType2Attribute JOIN rangeAttributeTypes ON objectType2Attribute.idAttribute = rangeAttributeTypes.idAttributeType WHERE idAttGroup = 1 AND idPhase =:idPhase ORDER BY rangeAttributeTypes.ordering DESC ');
        $stmt->bindParam(':idPhase', $idPhase, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getLatestPricePhase($idPhase){
        $template = array(
            5 => "1",
            4 => "1",
            3 => "2",
            2 => "3",
            1 => "3",
        );
        return $template[$idPhase];
    }

    function getAttributeValueByType($idAttributeType){
        foreach ($this->attributes as $key => $attribute){
            if($attribute['idAttributeType'] == $idAttributeType){
                return $attribute['value'];
            }
        }
        return null;
    }

    public function htmlFormFilled($num,$idPhase)
    {
        $brigePrices = "";
        $currentPrice = BridgeObject::getLatestPricePhase($idPhase);
        $template = BridgeObject::getAttributeTemplateByPhase($idPhase);
        foreach ($template as $key => $priceType){
            if ($priceType['idAttribute'] != $currentPrice){
                $brigePrices .="
                <input type='hidden' class='form-control' name='object[$num][attribute][$key][value]' value='" . $this->getAttributeValueByType($priceType['idAttribute']) . "' required>
                <input type='hidden' class='form-control' name='object[$num][attribute][$key][idAttributeType]' value='" . $priceType['idAttribute'] . "' required>
                ";
            }else{
                $price = ($this->getAttributeValueByType($priceType['idAttribute']) != null)?$this->getAttributeValueByType($priceType['idAttribute']) : '';
                $brigePrices .="
                <label for='name' class='bmd-label-floating'>".$priceType['name']."</label>
                <input type='number' class='form-control' name='object[$num][attribute][$key][value]' value='$price' required>
                <input type='hidden' class='form-control' name='object[$num][attribute][$key][idAttributeType]' value='" . $priceType['idAttribute'] . "' required>
                ";
            }
        }

        return "<div class='col-md-6 objectWrapper'>
                    <h5>
                        Most
                    </h5>
                    <div class='input-group form-control-lg'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>
                              <i class='material-icons'>import_contacts</i>
                            </span>
                        </div>
                        <div class='form-group col'>
                            <label for='name' class='bmd-label-floating'>Číslo mostu</label>
                            <input type='hidden' name='object[$num][idObject]' value='" . $this->idObject . "'>
                            <input type='hidden' name='object[$num][idObjectType]' value='" . $this->getIdObjectType() . "'>
                            <input type='text' class='form-control' name='object[$num][name]' required value='" . $this->getName() . "'>
                        </div>
                    </div>
                    <div class='input-group form-control-lg'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>
                              <i class='material-icons'>attach_money</i>
                            </span>
                        </div>
                        <div class='form-group col'>
                            $brigePrices
                        </div>
                    </div>
                    <div class='d-flex justify-content-center'>
                        <i class='removeObject material-icons active'>remove</i>
                    </div>
                </div>";
    }

    public static function htmlFormEmpty($num, $idPhase)
    {
        $currentPrice = BridgeObject::getLatestPricePhase($idPhase);
        $dbh = new \DatabaseConnector();
        $stmt = $dbh->getDbLink()->prepare('SELECT name FROM rangeAttributeTypes WHERE idAttributeType =:idAttributeType LIMIT 1');
        $stmt->bindParam(':idAttributeType', $currentPrice, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return "<div class='col-md-6 objectWrapper'>
                    <h5>
                        Most
                    </h5>
                    <div class='input-group form-control-lg'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>
                              <i class='material-icons'>import_contacts</i>
                            </span>
                        </div>
                        <div class='form-group col'>
                            <label for='name' class='bmd-label-floating'>Číslo mostu</label>
                            <input type='hidden' name='object[$num][idObjectType]' value='1'>
                            <input type='text' class='form-control' name='object[$num][name]' required>
                        </div>
                    </div>
                    <div class='input-group form-control-lg'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>
                              <i class='material-icons'>attach_money</i>
                            </span>
                        </div>
                        <div class='form-group col'>
                            <label for='name' class='bmd-label-floating'>".$result['name']."</label>
                            <input type='text' class='form-control' name='object[$num][attribute][0][value]' required>
                            <input type='hidden' class='form-control' name='object[$num][attribute][0][idAttributeType]' value='$currentPrice' required>
                        </div>
                    </div>
                    <div class='d-flex justify-content-center'>
                        <i class='removeObject material-icons active'>remove</i>
                    </div>
                </div>";
    }

}