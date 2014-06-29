<?php

$GLOBALS['TL_DCA']['tl_leisuretip_archive'] = array
(
    'config' => Array
(
    'sql' => Array
        (
            'keys' => Array
            (
                'id' => primary
            )

        ),

        'dataContainer' => table,
            'switchToEdit' => 1,
            'enableVersioning' => 1,
        ),

    'list' => Array
(
    'mode' => 1,
            'flag' => 1,
            'panelLayout' => 'sort,filter;search,limit',
            'root' => 0,
        ),

    'palettes' => Array
(
),

'fields' => Array
(
    'id' => Array
    (
        'sql' => "int(10) unsigned NOT NULL auto_increment"
                ),

            'tstamp' => Array
(
    'sql' => "int(10) unsigned NOT NULL default '0'"
                ),

            'test' => Array
(
    'inputType' => text
),

        )

);