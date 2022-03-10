<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.01.2020
 * Time: 13:42
 */

namespace Price;

class Price
{
    protected $type;
    protected $tax;
    protected $dbh;
    private $value;

    public function __construct($value, $type, $tax)
    {
        $this->dbh = new \DatabaseConnector();
        $this->value=$value;
        $this->type=$type;
        $this->tax=$tax;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getValueFormated(bool $dph){

        if ($dph){
            return number_format($this->getValueWithTax(),2,',',' ');
        }else{
            return number_format($this->getValue(),2,',',' ');
        }
    }

    public function getValueWithTax()
    {
        return $this->value * (1 + $this->tax);
    }

    public function getLabel(bool $dph){
        $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM rangePriceTypes WHERE idPriceType =:idPriceType LIMIT 1");
        $stmt->bindValue(':idPriceType', $this->type, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC)['name'];
        if($dph){
            return "{$result} s DPH";
        }else{
            return "{$result} bez DPH";
        }
    }

    public function formRepresenation(int $seed, $dph, $customClass = NULL){
        return
        "
        <div class='input-group form-control-lg'>
            <div class='input-group-prepend'>
                <span class='input-group-text'>
                    <i class='material-icons'>attach_money</i>
                </span>
            </div>
            <div class='form-group col'>
                <label class='bmd-label-floating'>".$this->getLabel($dph)."
                </label>
                <input type='number' step='any' min='0' class='form-control $customClass'
                       name='price[$seed][value]' value='" . $this->getValue() . "' required>
                <input type='hidden' class='form-control' name='price[$seed][idPriceType]' value='" . $this->type . "'>
            </div>
        </div>
         ";
    }
}