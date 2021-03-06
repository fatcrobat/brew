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
               $objBrewTable = new BrewTable($objTables->id);
               $objBrewTable->loadDca($objTables->id);
            }
        }
    }

    public function initializeSystemHook()
    {
        // make sure, user object is loaded before database object
        // https://github.com/contao/core/issues/2236
        $this->import('BackendUser', 'User');
        // must catch Exceptions, because if fields do not exist in db, backend error will be thrown all time
        try{
            $this->addBackendModules();
        }
        catch (\Exception $e){}
    }

    public function sqlGetFromDcaHook($return)
    {
        $objTables = BrewTableModel::findAll();

        if($objTables === null) return;

        while($objTables->next())
        {
            $objExtract = new BrewDcaExtractor($objTables->name);

            if ($objExtract->isDbTable())
            {
                $return[$objTables->name] = $objExtract->getDbInstallerArray();
            }
        }

        return $return;
    }

}