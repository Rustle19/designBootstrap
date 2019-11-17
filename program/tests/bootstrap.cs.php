<?php
/**
 * 마켓존 케이스 공통 bootstrap
 * @editor jsyang
 * @date 2016.01.29
 */
define('FW_ERROR_REPORTING', E_ALL ^ E_NOTICE);
// error_reporting(E_ALL ^ E_NOTICE);

// ob_start();
ini_set('memory_limit', '1024M');

// 디파인 정의하기
define('TESTS_ROOT_PATH', dirname(__FILE__));
define('FW_PROJECT_NICK', "program");
define('TESTS_MOCKDATA_PATH', TESTS_ROOT_PATH . '/mockdata');

include dirname(TESTS_ROOT_PATH) . '/framework/tsa/bootstrap.utf8.php';

// 초기화
Model::getInstance();
spl_autoload_register('__unitAutoload');

/**
 * 유닛테스트 전용 AUTOLOAD
 */
function __unitAutoload($sClass)
{
    $sClass = preg_replace('/^TSA_/', '', $sClass);
    $sFile = str_replace('_', '/', $sClass);
    $sFile .= '.php';
    $sFile = TESTS_ROOT_PATH . '/' . $sFile;

    if (file_exists($sFile)) {
        require_once $sFile;
    }
}

/**
 * get val from array by key
 *
 * $aArr = array('a' => 1); getVal('a', $aArr);
 * $aArr = array(
 * 'a' => array(
 * 'b' => array(
 * 'c' => array('id' => 11, 'name' => 'test')
 * )
 * )
 * );
 * $sName = getVal(array('a', 'b', 'c', 'name'), $aArr, 'empty name');
 *
 *
 * @param
 *            mixed
 * @param
 *            $aArr
 * @param string $mDefault
 * @return mixed
 */
function getVal($mKeys, $aArr, $mDefault = '')
{
    if (is_array($aArr) === false)
        return $mDefault;

    if (is_array($mKeys) === false)
        $mKeys = array(
            $mKeys
        );

    $mResult = $aArr;
    foreach ($mKeys as $sKey) {
        if (is_array($mResult) && array_key_exists($sKey, $mResult)) {
            $mResult = $mResult[$sKey];
        } else {
            return $mDefault;
        }
    }

    return $mResult;
}

include TESTS_ROOT_PATH . '/inc/testconfig.php';
include TESTS_ROOT_PATH . '/inc/testcase.php';
include TESTS_ROOT_PATH . '/inc/testsuite.php';
