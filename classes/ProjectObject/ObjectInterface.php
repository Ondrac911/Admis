<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 16.08.2019
 * Time: 12:31
 */

namespace ProjectObject;


interface ObjectInterface{
    public function serialise($json);
    public function htmlFormFilled($num, $idPhase);
    public static function htmlFormEmpty($num, $idPhase);
}
