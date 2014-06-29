<?php

$GLOBALS['TL_DCA']['tl_brew'] = array
(
    'config'    => array
    (
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_brew_table'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_brew', 'adjustDca')
        ),
        'onsubmit_callback' => array
        (
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('name'),
            'format'                  => '%s'
        ),
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
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew']['edit'],
                'href'                => 'table=tl_brew_table',
                'icon'                => 'edit.gif'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.gif',
                'button_callback'     => array('tl_brew', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif',
                'button_callback'     => array('tl_brew', 'copyBrew')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_brew', 'deleteBrew')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array(''),
        'default'                     => '{name_legend},name;{backend_legend},isBeIndependent,beInsertAfter,icon'
    ),

    // Subpalettes
    'subpalettes' => array
    (
    ),
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'rgxp' => 'alias', 'unique'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'icon' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew']['icon'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>false, 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL",
        ),
        'isBeIndependent' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew']['isBeIndependent'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'beInsertAfter' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew']['beInsertAfter'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_brew', 'getActiveBackendModules'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'includeBlankOption' => true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        )
    )
);

class tl_brew extends Backend
{
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    public function adjustDca(DataContainer $dc)
    {
        $objResult = \Database::getInstance()->prepare('SELECT * FROM tl_brew WHERE id = ?')->execute($dc->id);

        if($objResult === null) return;

        if($objResult->tstamp > 0)
        {
            // disable key fields if once created
            $GLOBALS['TL_DCA']['tl_brew']['fields']['name']['eval']['disabled'] = true;
        }
    }

    public function getActiveBackendModules(DataContainer $dc)
    {
        $arrOptions = array();
        $arrModules = array();

        if($dc->activeRecord->isBeIndependent)
        {
            $arrModules = array_keys($GLOBALS['BE_MOD']);

            foreach($arrModules as $key => $strGroupName)
            {
                $arrOptions[$strGroupName] = (($label = is_array($GLOBALS['TL_LANG']['MOD'][$strGroupName]) ? $GLOBALS['TL_LANG']['MOD'][$strGroupName][0] : $GLOBALS['TL_LANG']['MOD'][$strGroupName]) != false) ? $label : $strGroupName;
            }
        }
        else
        {
            foreach($GLOBALS['BE_MOD'] as $strGroupName => $arrModuleNames)
            {
                $arrModules = array_keys($arrModuleNames);

                $groupLabel = (($label = is_array($GLOBALS['TL_LANG']['MOD'][$strGroupName]) ? $GLOBALS['TL_LANG']['MOD'][$strGroupName][0] : $GLOBALS['TL_LANG']['MOD'][$strGroupName]) != false) ? $label : $strGroupName;

                foreach($arrModules as $strModuleName)
                {
                    $arrOptions[$groupLabel][$strModuleName] = (($label = is_array($GLOBALS['TL_LANG']['MOD'][$strModuleName]) ? $GLOBALS['TL_LANG']['MOD'][$strModuleName][0] : $GLOBALS['TL_LANG']['MOD'][$strModuleName]) != false) ? $label : $strModuleName;
                }
            }
        }

        return $arrOptions;
    }

    /**
     * Return the edit header button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function editHeader($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_brew') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }

    // TODO
    public function copyBrew()
    {

    }

    /**
     * Return the delete brew button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function deleteBrew($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'brewp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }
}