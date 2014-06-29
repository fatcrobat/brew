<?php

namespace Fatcrobat\Brew;

class Brew extends \Controller
{

    public function addBackendModules()
    {
        $objBrew = BrewModel::findAll();

        if($objBrew === null) return;

        $arrBackendModules = $GLOBALS['BE_MOD'];

        while($objBrew->next())
        {
            $objTables = BrewTableModel::findBy('pid', $objBrew->id);

            if($objTables === null) continue;

            foreach($arrBackendModules as $strGroupName => $arrModules)
            {
                $i = 0;

                foreach($arrModules as $strModuleName => $config)
                {
                    if($strModuleName == $objBrew->beInsertAfter)
                    {
                        $arrTables = $objTables->fetchEach('name');

                        array_insert($GLOBALS['BE_MOD'][$strGroupName], $i + 1, array
                        (
                            $objBrew->name  => array
                            (
                                'tables'      => array_values($arrTables),
                               // 'icon'        => 'system/modules/brew/assets/icon.png'
                            )
                        ));
                    }

                    $i++;
                }

            }

            if($objBrew->isBeIndependent)
            {
                $arrBackendModules['brew_' . $objBrew->id] = array('FOO');
            }
        }
    }

}