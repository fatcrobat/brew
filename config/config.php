<?php


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['system'], 1, array
(
    'brew' => array
    (
        'tables'      => array('tl_brew'),
        'icon'        => 'system/modules/brew/assets/icon.png'
    )
));

/**
 * Hooks
 */