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
                JText::_('Mitglieder'),
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

    /**
     * Zeigt das übergebene Feld schreibgeschützt an und verhindert das Speichern von Werten für dieses Feld.
     * Das Attribut "required" wird auf false gesetzt, sonst kann nicht gespeichert werden.
     *
     * @param JForm     $form
     * @param string    $fieldName
     * @return void
     */
    public static function disableField($form, $fieldName)
    {
        $form->setFieldAttribute($fieldName, 'disabled', 'true');
        $form->setFieldAttribute($fieldName, 'required', 'false');
        $form->setFieldAttribute($fieldName, 'filter', 'unset');
    }
}