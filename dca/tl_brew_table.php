<?php

$GLOBALS['TL_DCA']['tl_brew_table'] = array
(
    'config'    => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_brew',
        'ctable'                      => array('tl_brew_field', 'tl_brew_palette'),
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'onload_callback' => array
        (
        ),
        'onsubmit_callback' => array
        (
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('name'),
            'headerFields'            => array('name'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_brew_table', 'listTables'),
            'disableGrouping'         => true,
            'child_record_class'      => 'no_padding'
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
            'editFields' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['editFields'],
                'href'                => 'table=tl_brew_field',
                'icon'                => '/system/modules/brew/assets/icon-field.png'
            ),
            'editPalettes' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['editPalettes'],
                'href'                => 'table=tl_brew_palette',
                'icon'                => '/system/modules/brew/assets/icon-palette.png'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['editheader'],
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
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array(),
        'default'                     => '{name_legend},name;
                                          {config_legend},dataContainer,closed,notEditable,notDeletable,notSortable,notCopyable,notCreatable,switchToEdit,enableVersioning,doNotCopyRecords,doNotDeleteRecords;
                                          {list_legend},mode,flag,panelLayout,fields,headerFields,icon,root,filter,disableGrouping,child_record_class'
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
        'pid' => array
        (
            'foreignKey'              => 'tl_brew.name',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'default'                 => 'tl_',
            'eval'                    => array
            (
                'mandatory'=>true,
                'maxlength'=>255,
                'unique' => true,
                'nospace' => true
            ),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'dataContainer'  => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['dataContainer'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'select',
            'default'                 => 'table',
            'options'                 => array('table'),
            'eval'                    => array
            (
                'mandatory'=>true,
            ),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
        'closed' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['closed'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'notEditable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notEditable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'notDeletable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notDeletable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'notSortable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notSortable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'notCopyable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notCopyable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'notCreatable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notCreatable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'switchToEdit' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['switchToEdit'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'default'                 => true,
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'enableVersioning' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['enableVersioning'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'default'                 => true,
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'doNotCopyRecords' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notEditable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'doNotDeleteRecords' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['notEditable'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'mode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['mode'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'select',
            'default'                 => 1,
            'options'                 => range(0,6),
            'eval'                    => array
            (
                'mandatory'=>true,
            ),
            'sql'                     => "int(1) unsigned NULL"
        ),
        'flag' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['flag'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'select',
            'default'                 => 1,
            'options'                 => range(0,12),
            'eval'                    => array
            (
                'mandatory'=>true,
            ),
            'sql'                     => "int(2) unsigned NULL"
        ),
        'panelLayout' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['panelLayout'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'default'                 => 'sort,filter;search,limit',
            'eval'                    => array
            (
                'mandatory'=>true,
            ),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'fields' => array(),
        'headerFields' => array(),
        'icon' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['icon'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL",
        ),
        'root' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['root'],
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_page.title',
            'eval'                    => array('fieldType'=>'radio'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'eager')
        ),
        'filter' => array(),
        'disableGrouping' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['disableGrouping'],
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array
            (
            ),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'child_record_class' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_table']['child_record_class'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array
            (
            ),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
    )
);

class tl_brew_table extends Backend
{
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
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
    public function copyTable()
    {

    }

    /**
     * Return the delete table button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function deleteTable($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'brewp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }


    public function listTables($arrRow)
    {
        return '<div class="tl_content_left">' . $arrRow['name'] . '</div>';
    }
}