<?php


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['system'], 1, array
(
    'brew' => array
    (
        'tables'      => array('tl_brew', 'tl_brew_table', 'tl_brew_palette', 'tl_brew_field'),
        'icon'        => 'system/modules/brew/assets/icon.png'
    )
));


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('Fatcrobat\Brew\BrewHooks', 'initializeSystemHook');
$GLOBALS['TL_HOOKS']['loadDataContainer'][] = array('Fatcrobat\Brew\BrewHooks', 'loadDataContainerHook');

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_brew'] = 'Fatcrobat\Brew\BrewModel';
$GLOBALS['TL_MODELS']['tl_brew_table'] = 'Fatcrobat\Brew\BrewTableModel';
$GLOBALS['TL_MODELS']['tl_brew_field'] = 'Fatcrobat\Brew\BrewFieldModel';