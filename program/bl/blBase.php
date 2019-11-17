<?php

abstract class blBase
{
    //public function validateFormat($aUser)
    //{
    //
    //    //if ($aUser['sType'] === 'register') {
    //    //
    //    //}
    //
    //    return $this->validateRegister($aUser['user']);
    //}
    //
    //public function validateRegister($aInput)
    //{
    //    $aRegisterInputs = ['name', 'username', 'pw'];
    //    foreach ($aInput as $sKey => $sValue) {
    //        $iMin = ($sKey !== 'pw') ? 4 : 8;
    //        switch ($sKey) {
    //            case 'name':
    //                $iMax = 50;
    //                $mPattern = "/^[a-zA-Z'. ]+$/";
    //                break;
    //            case 'username':
    //                $iMax = 20;
    //                $mPattern = "/^([a-zA-Z])([0-9]?)+/";
    //                break;
    //            default:
    //                $iMax = 16;
    //                $mPattern = "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/";
    //        }
    //        //
    //        //$this->validateRange($sValue, $iMin, $iMax) === false &&$this->validatePattern($sValue, $mPattern) === false && $this->isEmpty($sValue)
    //        if (in_array($sKey, $aRegisterInputs) === true && $this->validateRange($sValue, $iMin, $iMax) === false) {
    //            return false;
    //        }
    //    }
    //
    //    return true;
    //}
    //
    //public function isEmpty($sInput)
    //{
    //    return trim($sInput) === '';
    //
    //}
    //
    //public function validateRange($sValue, $iMin, $iMax)
    //{
    //    return strlen($sValue) >= $iMin && strlen($sValue) <= $iMax;
    //}
    //
    //public function validatePattern($mPattern, $sValue)
    //{
    //    return preg_match($mPattern, $sValue) === 1 && strlen($sValue) > 0;
    //}

}
