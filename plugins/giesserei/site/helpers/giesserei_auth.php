<?php
defined('_JEXEC') or die;

/**
 * Helperklasse für die Berechtigungsprüfung.
 *
 * @author Steffen Förster
 */
class GiessereiAuth {

    const ACTION_DOWNLOAD_ADDRESS_LIST = "member.download.address.list";

    const ACTION_DOWNLOAD_PASSIVE_LIST = "member.download.passive.list";

    /**
     * Prüft ob der Benutzer angemeldet ist und ob der Benutzer eine Berechtigung für die übergebene Action hat.
     */
    public static function hasAccess($action) {
        $user = JFactory::getUser();
        if (!self::checkSignedIn($user)) {
            return false;
        }
        return $user->authorise($action, 'com_giesserei');
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Liefert true, wenn der Benutzer angemeldet ist; sonst false.
     * Wenn false, dann wird eine Systemmeldung hinzugefügt.
     */
    private static function checkSignedIn($user) {
        if ($user->guest) {
            JFactory::getApplication()->enqueueMessage('Die Registrierung ist abgelaufen. Bitte neu anmelden.');
            return false;
        }
        return true;
    }

}