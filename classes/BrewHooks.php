<?php

namespace Fatcrobat\Brew;

class BrewHooks extends Brew
{

    public function loadDataContainerHook($strTable)
    {
        // when tl_brew_table is loaded --> include our custom tables as well
        if($strTable == 'tl_brew_table')
        {
            $objTables = BrewTableModel::findAll();

            if($objTables === null) return;

            while($objTables->next())
            {
               BrewTable::loadDca($objTables->id);
            }
        }
    }

    public function initializeSystemHook()
    {
        // make sure, user object is loaded before database object
        // https://github.com/contao/core/issues/2236
        $this->import('BackendUser', 'User');
        $this->addBackendModules();
    }


}