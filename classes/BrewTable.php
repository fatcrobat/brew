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

        // TODO: make editable,  just for testing
        $arrConfig = array
        (
            'global_operations' => array
            (
                'all' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                    'href'                => 'act=select',
                    'class'               => 'header_edit_all',
                    'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
                )
            ),
            'operations' => array
            (
                'editheader' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['edit'],
                    'href'                => 'act=edit',
                    'icon'                => 'header.gif',
                    'button_callback'     => array('tl_brew_table', 'editHeader')
                ),
                'copy' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['copy'],
                    'href'                => 'act=copy',
                    'icon'                => 'copy.gif',
                    'button_callback'     => array('tl_brew_table', 'copyTable')
                ),
                'delete' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['delete'],
                    'href'                => 'act=delete',
                    'icon'                => 'delete.gif',
                    'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                    'button_callback'     => array('tl_brew_table', 'deleteTable')
                ),
                'show' => array
                (
                    'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['show'],
                    'href'                => 'act=show',
                    'icon'                => 'show.gif'
                )
            )
        );

        // TODO Refactor
        if(!isset($this->arrFields['sorting']) && !is_array($this->arrFields['sorting']))
        {
            return $arrConfig;
        }

        foreach($this->arrFields['sorting'] as $name)
        {
            if(empty($this->objItem->{$name})) continue;
            $arrConfig['sorting'][$name] = $this->objItem->{$name};
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