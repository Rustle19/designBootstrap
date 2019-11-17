<?php

/**
 * Session Mock Object
 *
 * @author simplexi
 *
 */
class TSA_mockup_session
{

    private static $aData;

    public function set($sId, $mData)
    {
        if ($mData === null) {
            unset($this->aData[$sId]);
            return;
        }
        
        $this->aData[$sId] = $mData;
    }

    public function get($sId = null)
    {
        if ($sId === null) {
            return $this->aData;
        }
        
        return isset($this->aData[$sId]) ? $this->aData[$sId] : false;
    }

    public function sessionId($sSessId)
    {
        return null;
    }

    public function sessionIdRegenerate()
    {
        return null;
    }

    public function destruct()
    {
        $this->aData = null;
    }

    public function getSession()
    {
        return array(
            'session_id' => 'c2ca1ac5c92be3e98ee1dbeba3b0b6a8',
            'ip_addr' => '127.0.0.1',
            'init_access_time' => '1465890292',
            'access_time' => '1465890329',
            'member_info' => array(
                'no' => '5',
                'groupware_id' => 'jhwon',
                'name' => '원종현',
                'country' => 'KR',
                'authority' => '4',
                'team_no' => '5',
                'access_team' => '4,5,8,7,6,24,2,1,3',
                'apply_team' => '{"test1":["4","3","5","8","7","6","2","1"],"test7":["5","8","7"],"test2":[]}',
                'staff_level' => '사원',
                'ins_timestamp' => '2016-05-16 05:29:09',
                'upd_timestamp' => '2016-06-09 02:52:36',
                'team_depth_full' => '001001013005006',
                'team_navigation' => '심플렉스인터넷(주)::본사사업장::개발팀::CSD그룹::CSD5팀',
                'team_navi_idx' => '166::169::183::969::2035'
            ),
            'login_stat' => '1'
        );
    }
}