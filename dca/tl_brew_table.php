<?php

$GLOBALS['TL_DCA']['tl_brew_table'] = array
(
    'config'    => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_brew',
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
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_table']['edit'],
                'href'                => 'table=tl_brew_table',
                'icon'                => 'edit.gif'
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
        'default'                     => '{name_legend},name'
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
            'foreignKey'              => 'tl_brew.title',
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

}