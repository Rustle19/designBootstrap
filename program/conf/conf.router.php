<?php if (!defined('__FW_RUN__')) exit('not found');
/**
 * conf.router.php
 */

/**
-- Code Samples --

//
// The following settings are effective only when the 'segment'(ROUTE MAP TYPE) set.
//

Router::mapper('/manager/editor/([0-9]+)[/]?$', array(
    'controller' => 'admin',
    'method' => 'editor',
    'params' => array('$1')
));

Router::mapper('/manager/login/([a-z]+)/([0-9]+)[/]?$', array(
    'controller' => 'admin/login',
    'method' => '$1',
    'params' => array('$2')
));

Router::mapper('/logeditor/([0-9]+)[/]?$', array(
    'controller' => 'admin/login/exec',
    'method' => 'editor',
    'params' => array('$1')
));

Router::filter('admin/login::methods', true);

Router::filter('admin/login::methodss', false);

*/