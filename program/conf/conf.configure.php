<?php if (!defined('__FW_RUN__')) exit('not found');
/**
 * conf.configure.php
 */

/**
-- Code Samples --

//
// Default DSN - case, single connection
//
$CONFIGURE['FW.database'] = array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'id' => 'root',
    'dbname' => 'example',
    'passwd' => 'example',
    'port' => 3306
);

//
// Default DSN - case, replication connection
//
$CONFIGURE['FW.database'] = array(
    'driver' => 'mysql',
    'master' => array(
        'host' => 'localhost',
        'id' => 'root',
        'dbname' => 'example',
        'passwd' => 'example',
        'port' => 3306
    ),
    'slave' => array (
        'host' => 'localhost2',
        'id' => 'root',
        'dbname' => 'example',
        'passwd' => 'example',
        'port' => 3306
    )
);

//
// Default DSN - case, option set
//
$CONFIGURE['FW.database'] = array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'id' => 'root',
    'dbname' => 'example',
    'passwd' => 'example',
    'port' => 3306,
    'options' => array(
        PDO::MYSQL_ATTR_READ_DEFAULT_FILE => '/etc/my.cnf'
    )
);

//
// Session - type (cookie, memcache, php, files)
//
$CONFIGURE['FW.session_type'] = 'cookie';

//
// Session - session id cookie name
//
$CONFIGURE['FW.session_name'] = 'FW';

//
// Session - data expire
//
$CONFIGURE['FW.session_expire'] = 3600;

//
// Session - garbage collection
//
$CONFIGURE['FW.session_gc_probability'] = 1;

//
// Session - data encrypt enabled
//
$CONFIGURE['FW.session_encrypt'] = true;

//
// Session - memcache host (only memcache type)
//
$CONFIGURE['FW.session_memcache_host'] = localhost;

//
// Session - memcache port (only memcache type)
//
$CONFIGURE['FW.session_memcache_port'] = 11211;

//
// I18N - enabled
//
$CONFIGURE['FW.i18n_enabled'] = true;

//
// I18N - locale
//
$CONFIGURE['FW.i18n_locale'] = 'en_US';

//
// I18N - domain
//
$CONFIGURE['FW.i18n_domain'][] = 'foo';

//
// I18N - bind domain
//
$CONFIGURE['FW.i18n_bind_domain'] = 'foo';

*/

$CONFIGURE['FW.session_type'] = 'php';
