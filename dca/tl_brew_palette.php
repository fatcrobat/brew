<?php

$GLOBALS['TL_DCA']['tl_brew_palette'] = array
(
    'config'    => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_brew_table',
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
            'child_record_callback'   => array('tl_brew_palette', 'listPalette'),
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
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_palette']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_palette']['editheader'],
                'href'                => 'table=tl_brew_table',
                'icon'                => 'header.gif',
                'button_callback'     => array('tl_brew_palette', 'editHeader')
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_palette']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif',
                'button_callback'     => array('tl_brew_palette', 'copyPalette')
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_palette']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback'     => array('tl_brew_palette', 'deletePalette')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_brew_palette']['show'],
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_brew_palette']['name'],
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

class tl_brew_palette extends Backend
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
     * Return the delete palette button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function deletePalette($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'brewp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }


    public function listPalette($arrRow)
    {
        return '<div class="tl_content_left">' . $arrRow['name'] . '</div>';
    }
}