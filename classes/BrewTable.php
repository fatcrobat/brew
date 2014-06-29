<?php

namespace Fatcrobat\Brew;

class BrewTable extends Brew
{
    protected $objItem;

    protected $arrFields = array();

   public function __construct($varId)
   {
       parent::__construct();

       \Controller::loadDataContainer('tl_brew_table');

       $this->objItem = BrewTableModel::findByPk($varId);
   }

    public function loadDca()
    {
        if($this->objItem === null) return;

        $this->initConfigPalette();

        $GLOBALS['TL_DCA'][$this->objItem->name] = array
        (
            'config'    => $this->createConfig(),
            'list'      => $this->createList(),
            'palettes'  => $this->createPalettes(),
            'fields'    => $this->createFields(),
        );
        
        print '<pre>';
        print_r($GLOBALS['TL_DCA'][$this->objItem->name]);
        print '</pre>';
    }

    protected function createConfig()
    {
        $arrConfig = array();

        if(!isset($this->arrFields['config']) && !is_array($this->arrFields['config']))
        {
            return $arrConfig;
        }

        // TODO: make editable via fields
        $arrConfig['sql']['keys'] = array('id' => 'primary');

        foreach($this->arrFields['config'] as $name)
        {
            if($this->objItem->{$name} == '') continue;
            $arrConfig[$name] = $this->objItem->{$name};
        }

        return $arrConfig;
    }

    protected function createList()
    {
        $arrConfig = array();

        if(!isset($this->arrFields['list']) && !is_array($this->arrFields['list']))
        {
            return $arrConfig;
        }

        foreach($this->arrFields['list'] as $name)
        {
            if($this->objItem->{$name} == '') continue;
            $arrConfig[$name] = $this->objItem->{$name};
        }

        return $arrConfig;
    }


    protected function createPalettes()
    {
        $arrConfig = array();

        return $arrConfig;
    }

    protected function createFields()
    {
        $arrConfig = array();

        $objFields = BrewFieldModel::findBy('pid', $this->objItem->id);

        if($objFields === null) return $arrConfig;

        // base fields
        $arrConfig = array
        (
           'id' => array(
               'sql'                     => "int(10) unsigned NOT NULL auto_increment"
           ),
           'tstamp' => array
            (
                'sql'                     => "int(10) unsigned NOT NULL default '0'"
            ),
        );


        while($objFields->next())
        {
            $arrConfig[$objFields->name] = array
            (
                'inputType' => $objFields->type,
            );
        }

        return $arrConfig;
    }

    protected function createField($objField)
    {

    }

    protected function initConfigPalette()
    {
        $strPalette = $GLOBALS['TL_DCA']['tl_brew_table']['palettes']['default'];

        $boxes = trimsplit(';', $strPalette);
        $legends = array();

        if (!empty($boxes))
        {
            foreach ($boxes as $k=>$v)
            {
                $eCount = 1;
                $boxes[$k] = trimsplit(',', $v);

                foreach ($boxes[$k] as $kk=>$vv)
                {
                    if (preg_match('/^\[.*\]$/', $vv))
                    {
                        ++$eCount;
                        continue;
                    }

                    if (preg_match('/^\{.*\}$/', $vv))
                    {
                        $legends[$k] = substr($vv, 1, -1);
                        unset($boxes[$k][$kk]);
                    }
                }

                // Unset a box if it does not contain any fields
                if (count($boxes[$k]) < $eCount)
                {
                    unset($boxes[$k]);
                }
            }

            $blnIsFirst = true;

            // Render boxes
            foreach ($boxes as $k=>$v)
            {
                $strAjax = '';
                $blnAjax = false;
                $key = '';
                $cls = '';
                $legend = '';

                if (isset($legends[$k]))
                {
                    list($key, $cls) = explode(':', $legends[$k]);
                    $arrKey = trimsplit('_', $key);
                }

                // Build rows of the current box
                foreach ($v as $vv)
                {
                    $this->arrFields[$arrKey[0]][] = $vv;
                }

            }
        }
    }
}