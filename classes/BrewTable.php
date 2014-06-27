<?php

namespace Fatcrobat\Brew;

class BrewTable extends Brew
{

    public static function loadDca($varId)
    {
        $objResult = BrewTableModel::findByPk($varId);

        if($objResult === null) return;

        $GLOBALS['TL_DCA'][$objResult->name] = array
        (
            'config'    => static::createConfig($objResult),
            'list'      => static::createList($objResult),
            'palettes'  => static::createPalettes($objResult),
            'fields'    => static::createFields($objResult),
        );
    }

    protected static function createConfig($objResult)
    {
        $arrConfig = array();

        $arrConfig['dataContainer'] = 'Table';

        return $arrConfig;
    }

    protected static function createList($objResult)
    {
        $arrConfig = array();

        return $arrConfig;
    }


    protected static function createPalettes($objResult)
    {
        $arrConfig = array();

        return $arrConfig;
    }

    protected static function createFields($objResult)
    {
        $arrConfig = array();

        return $arrConfig;
    }
}