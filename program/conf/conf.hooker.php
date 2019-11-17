<?php if (!defined('__FW_RUN__')) exit('not found');
/**
 * conf.hooker.php
 */

/**
-- Code Samples --

$HOOKER['before_dispatcher_init'][]   = array(
    'class' => 'Classname1',
    'method' => 'foo',
    'params' => array('1','2')
);

$HOOKER['after_dispatcher_init'][]   = array(
    'class' => 'Classname2',
    'method' => 'bar'
);

$HOOKER['before_dispatcher_display'][]   = array(
    'class' => 'Classname4',
    'method' => 'foo',
    'params' => array('1','2', 'blah')
);

$HOOKER['after_dispatcher_display'][]   = array(
    'class' => 'Classname4',
    'method' => 'bar'
);

*/