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

    /**
     * Kürzt den übergebenen Text, wenn erforderlich.
     *
     * @param string $text
     * @param int $maxLength
     * @return string
     */
    public static function cropText($text, $maxLength)
    {
        $result = $text;
        if (!empty($text) && strlen($text) > $maxLength) {
            $result = substr($text, 0, $maxLength);
        }
        return $result;
    }

    public static function debug ( $varName, $varValue, $row = "", $file = "" )
    {
        $debug = '<blockquote style="border:1px dotted red; 
                  border-left:10px solid red; padding-left:1em;">';
        $debug .= "Debug-Output: ";
        $debug .= "<pre>";
        $debug .= '$'. $varName  .' = ';
        $debug .= $varValue;
        $debug .= "</pre>";
        if ( $row OR $file ) {
            $debug .= "<br> (Row: $row - $file)";
        }
        $debug .= "</blockquote>";
        JFactory::getApplication()->enqueueMessage($debug, 'error');
    }
}