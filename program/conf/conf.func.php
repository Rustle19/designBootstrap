<?php if (!defined('__FW_RUN__')) exit('not found');
/**
 * conf.func.php
 */

/**
-- Code Samples --

//
// Define a function to disclose here.
//
function foo()
{
    echo "hello, world";
}

*/

/**
 * get Database Dns
 *
 * @param string $sDsnKey
 * @return array
 */
function getDsn($sDsnKey)
{
    $sFile = FW_DIR_RESOURCE . DS . 'dsn.json';
    if (ENV === 'LOCAL') {
        $sFile = FW_DIR_RESOURCE . DS . 'dsn-local.json';
    }

    try {
        if (file_exists($sFile) === false) {
            throw new Exception($sFile . " File Not Found\nyou make this file");
        }

        $aDsnData = json_decode(file_get_contents($sFile), true);

        if ($aDsnData[$sDsnKey] === null) {
            throw new Exception($sDsnKey . ' DSN Not Found');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }

    return empty($aDsnData[$sDsnKey]) === true ? null : $aDsnData[$sDsnKey];
}
