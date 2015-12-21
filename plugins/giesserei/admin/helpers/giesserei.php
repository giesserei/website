<?php
defined('_JEXEC') or die;

/**
 * Giesserei helper.
 */
class GiessereiHelper
{
    /**
     * Defines the valid request variables for the reverse lookup.
     */
    protected static $_filter = array('option', 'view', 'layout');

    /**
     * Configure the Linkbar.
     *
     * @param   string $vName The name of the active view.
     *
     * @return  void
     */
    public static function addSubmenu($vName = 'kategorien')
    {
        JHtmlSidebar::addEntry(
            'Kategorien',
            'index.php?option=com_zeitbank&view=kategorien',
            $vName == 'kategorien'
        );
    }
}