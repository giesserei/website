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
    public static function addSubmenu($vName = 'members')
    {
        $user = JFactory::getUser();
        $assetname = 'com_giesserei';

        if ($user->authorise('view.member', $assetname)) {
            JHtmlSidebar::addEntry(
                JText::_('Mitgliederliste'),
                'index.php?option=com_giesserei&view=members', $vName == 'members'
            );
        }

        if ($user->authorise('view.kid', $assetname)) {
            JHtmlSidebar::addEntry(
                JText::_('Kinder'),
                'index.php?option=com_giesserei&view=kids', $vName == 'kids'
            );
        }

        if ($user->authorise('view.flat', $assetname)) {
            JHtmlSidebar::addEntry(
                JText::_('Wohnungen'),
                'index.php?option=com_giesserei&view=flats', $vName == 'flats'
            );
        }
    }
}