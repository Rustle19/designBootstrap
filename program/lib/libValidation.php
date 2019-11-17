<?php

class libValidation
{
    private $oAllErrors;
    private $aInputs = ['username', 'name', 'pw', 'confirmPw'];
    private $sPassword;

    public function validateFormat($aUser)
    {
        $this->sPassword = $aUser['user']['pw'];
        foreach ($aUser['user'] as $sKey => $sValue) {
            //get method name e.g (validateRegName)
            $sMethodName = 'validate' . substr(ucfirst($aUser['sType']), 0, 3) . ucfirst($sKey);
            //store errors
            if (in_array($sKey, $this->aInputs) === true) {
                $this->oAllErrors[$sKey] = $this->{$sMethodName}($sValue);
                if ($this->oAllErrors['bErrorExist'] !== true) {
                    $this->oAllErrors['bErrorExist'] = (!($this->{$sMethodName}($sValue)) === false) ? true : false;
                }
            }
        }

        return $this->oAllErrors;
    }

    public function validatePattern($sValue, $mPattern)
    {
        return preg_match($mPattern, $sValue) === 1 && strlen($sValue) > 0;
    }

    public function validateRegName($sValue)
    {
        $aErrors = [];
        $mPattern = "/^[a-zA-Z'. ]+$/";
        if (strlen($sValue) < 4 || strlen($sValue) === 0) {
            $aErrors[] = 'Please input at least 4 character(s)';
        } else if (strlen($sValue) > 50 && strlen($sValue) > 0) {
            $aErrors[] = ' Please input at most 50 characters';
        } else if ($this->validatePattern($sValue, $mPattern) === false) {
            $aErrors[] = 'Name must be alphabetic . It does not accept numbers and special characters except \' and .';
        }

        return $aErrors;

    }

    //
    public function validateRegUsername($sValue)
    {
        $aErrors = [];

        $mPattern = "/^(\d*[A-Za-z]+\d*)+$/";
        // alert(this.oCommon.checkUserName($sValue));

        if (strlen($sValue) < 4 || strlen($sValue) === 0) {
            $aErrors[] = 'Please input at least 4 character(s)';
        } else if (strlen($sValue) > 20 && strlen($sValue) > 0) {
            $aErrors[] = ' Please input at most 20 characters';
        } else if ($this->validatePattern($sValue, $mPattern) === false) {
            $aErrors[] = 'Username should only be alphabetic or alphanumeric';
        }

        return $aErrors;
    }

    //
    public function validateRegPw($sValue)
    {
        $aErrors = [];
        $sConfirmPw = '#reg_confirm_pw';
        $mPattern = "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/";
        if (strlen($sValue) < 8 || strlen($sValue) === 0) {
            $aErrors[] = 'Please input at least 8 character(s)';
        } else if (strlen($sValue) > 16 && strlen($sValue) > 0) {
            $aErrors[] = ' Please input at most 20 characters';
        } else if ($this->validatePattern($sValue, $mPattern) === false) {
            $aErrors[] = 'Password must be alphanumeric only';
        }

        return $aErrors;
    }

    //
    public function validateRegConfirmPw($sValue)
    {
        $aErrors = [];
        if ($sValue !== $this->sPassword) {
            $aErrors[] = 'Password did not match';
        } else if (strlen($sValue) === 0) {
            $aErrors[] = 'Please input at least 8 character(s)';
        }

        return $aErrors;
    }

    public function isEmpty($sInput)
    {
        return trim($sInput) === '';
    }
}
