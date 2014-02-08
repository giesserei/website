<?php

defined('_JEXEC') or die;

/**
 * Helperklasse für Mitglieder-Verwaltung
 * Oktober 2013, JAL
 */
class GiessereiHelper {

    /**
     * In der Listenansicht im Contenberich ein Submenü aufbauen
     * Damit ist ein Wechsel zwischen Kategorien und Things möglich.
     *
     * @param type $name
     */
    public static function addSubmenu($name) {

        /* Tab "Mitgliederliste" */
        JSubMenuHelper::addEntry(
            JText::_('Mitgliederliste'),
            'index.php?option=com_giesserei&view=members', $name == 'members'
        );

        /* Tab "Kinder" */
        JSubMenuHelper::addEntry(
            JText::_('Kinder'),
            'index.php?option=com_giesserei&view=kids', $name == 'kids'
        );

        /* Tab "Wohnungen"         */
        JSubMenuHelper::addEntry(
            JText::_('Wohnungen'),
            'index.php?option=com_giesserei&view=flats', $name == 'flats'
        );

        /* Tab "Mitglieder-Journal-Klassen"         */
        JSubMenuHelper::addEntry(
            JText::_('Mitglieder-Journal-Klassen'),
            'index.php?option=com_giesserei&view=mjournalclasses', $name == 'mjournalclasses'
        );
 
        /* Tab "Wohnungs-Journal-Klassen"         */
        JSubMenuHelper::addEntry(
            JText::_('Wohnungs-Journal-Klassen'),
            'index.php?option=com_giesserei&view=ojournalclasses', $name == 'ojournalclasses'
        );
 
    }

}
