<?php
include FW_DIR_PROJECT . DS . 'vendor' . DS . 'groupware' . DS . 'api.client.class.php';
include FW_DIR_PROJECT . DS . 'vendor' . DS . 'groupware' . DS . 'xmlparser.class.php';

/**
 * this class is groupware login
 *
 * @package lib
 * @subpackage Groupware
 * @author 정현 <hjung01@simplexi.com>
 * @since 2014. 2. 11.
 * @version 1.0
 *
 */
class libGroupware
{
    const API_KEY = "\$_simplex_\$\0\0\0\0\0\0\0\0\0\0\0\0\0";

    /**
     * constructor
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 그룹웨어 로그인 처리하기
     *
     * @param string $sEmpId
     *            아이디
     * @param string $sPassword
     *            패스워드
     * @return array
     */
    public function login($sEmpId, $sPassword)
    {
        $sId = trim($sEmpId);

        $sPasswd = trim($sPassword);
        $key = $this->getEncryptKey($sId);
        $passwd = md5($sPasswd);

        $passwd = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $passwd, MCRYPT_MODE_CBC, '_cafe24_solution'));
        $requestURI = 'https://api.gsimplexi.cafe24.com/groupware/api/GroupwareLogin.php?';
        $requestURI .= '&userId=gsimplexi';
        $requestURI .= '&resellerId=hosting';
        $requestURI .= '&empId=' . $sId;
        $requestURI .= '&passwd=' . $passwd;
        $mResult = $this->_request($requestURI);

        return $mResult;
    }

    /**
     * groupware bug fixed
     *
     * @param unknown $sId
     * @return string
     */
    private function getEncryptKey($sId)
    {
        $sKey = 'gsimplexi_' . $sId;
        $iLen = strlen($sKey);

        if (in_array($iLen, array(16, 24, 32)) === true) {
            return $sKey;
        }

        if ($iLen > 0 && $iLen < 16) {
            $sKey = str_pad($sKey, 16, "\0");
        } else if ($iLen < 24) {
            $sKey = str_pad($sKey, 24, "\0");
        } else if ($iLen < 32) {
            $sKey = str_pad($sKey, 32, "\0");
        } else {
            $sKey = substr($sKey, 0, 32);
        }

        return $sKey;
    }

    /**
     * 그룹웨어 사용정보 데이터 얻어오기
     *
     * @param string $sEmpId
     *            그룹웨어 아이디
     * @return array
     */
    public function getSelEmpList($sEmpId)
    {
        if (empty($sEmpId) === true) {
            return false;
        }
        $sUrl = 'http://api.gsimplexi.cafe24.com/groupware/api/GroupwareSelEmpList.php?';
        $sUrl .= '&userId=gsimplexi';
        $sUrl .= '&resellerId=hosting';
        $sUrl .= '&empId=' . $sEmpId;
        $mResult = $this->_request($sUrl, 'utf-8');
        $aData = $mResult['data'][0];

        return $aData;
    }

    /**
     * 쪽지 전송
     *
     * @param string $sFromId
     *            송신
     * @param array  $aToId
     *            수신
     * @param string $sMsg
     *            메세지
     */
    public function sendMemo($sFromId, $aToId, $sMsg)
    {
        // 받는 사람이 여러명일 경우 콤마(,)로 구분
        if (is_array($aToId) === true) {
            $sToId = implode(',', $aToId);
        } else {
            $sToId = $aToId;
        }

        $key = "gsimplexi";
        $sMsg = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $sMsg, MCRYPT_MODE_CBC, '_cafe24_solution'));

        $sUrl = 'http://api.gsimplexi.cafe24.com/groupware/api/GroupwareAlarm.php?';
        $sUrl .= '&userId=' . $key;

        $sUrl .= '&resellerId=hosting';
        $sUrl .= '&from_id=' . $sFromId;
        $sUrl .= '&to_id=' . $sToId;
        $sUrl .= '&msg=' . urlencode($sMsg);
        // 저장여부
        // $requestURI .= '&gw_save=Y';

        $mResult = $this->_request($sUrl, 'utf-8');

        // 전송성공
        if ($mResult['data'][0]['result'] === 'true') {
            return true;
        } // 실패
        else {
            return false;
        }
    }

    /**
     * 전송
     *
     * @param string $sUrl
     *            url
     * @param string $sInputCharset
     *            캐셋
     */
    private function _request($sUrl, $sInputCharset = 'utf-8')
    {
        $xml = apiRequest(self::API_KEY, $sUrl, $sInputCharset);
        // parser
        $oParser = new xmlParser($sInputCharset);
        $oParser->_create();
        $oParser->parse($xml);
        $mData = $oParser->getStructure();
        unset($oParser, $xml, $sUrl);

        return $mData;
    }
}
