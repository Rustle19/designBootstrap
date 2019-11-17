<?php

/**
 * Session Mock Object
 *
 * @author simplexi
 *
 */
class TSA_mockup_groupware
{

    public function __construct()
    {}

    public function login($sEmpId, $sPassword)
    {
        $aData = $this->getData();
        
        if (empty($aData[$sEmpId]) === null) {
            return $aData['faillogin'];
        } else {
            return $aData[$sEmpId];
        }
    }

    public function getSelEmpList($sEmpId)
    {
        return 0;
    }

    public function sendMemo($sFromId, $aToId, $sMsg)
    {
        return 0;
    }

    /**
     * groupware api return data
     */
    private function getData()
    {
        $aData = array();
        
        // 성공
        $aData['success'] = array(
            'code' => '0000',
            'time' => 1461717620,
            'dataCnt' => 1,
            'data' => array(
                array(
                    'userflag' => true,
                    'regflag' => false,
                    'pwdChangeflag' => false
                )
            )
        );
        
        $aData['testcase'] = $aData['success'];
        
        // 비번 변경
        $aData['pwdchange'] = $aData['success'];
        $aData['pwdchange']['data'][0]['pwdChangeflag'] = true;
        
        // fail login
        $aData['faillogin'] = $aData['success'];
        $aData['faillogin']['data'][0]['userflag'] = false;
        
        // invalid data
        $aData['invalid'] = array(
            'code' => '2001'
        );
        
        return $aData;
    }
}