<?php

/**
 * Vom Frontend verwendete Konstanten.
 */
class GiessereiConst
{

    /**
     * Unter diesem Key werden die Formulardaten des Profils gespeichert werden, wenn eine Validierung fehlschlägt.
     */
    const SESSION_KEY_PROFIL_DATA = 'com_giesserei.profil.data';

    /**
     * Unter diesem Key wird die ID zu einem dem Profil untergeordneten Datensatz in der Session gespeichert.
     */
    const SESSION_KEY_PROFIL_SUB_ID = 'com_giesserei.profil.sub.id';

    /**
     * Unter diesem Key wird die Menü-Id der Profilseite gespeichert.
     */
    const SESSION_KEY_PROFIL_MENU_ID = 'com_giesserei.profil.menuid';

    /**
     * Über dieses Flag wird gesteuert, ob die Debugging-Meldungen angezeigt werden sollen.
     */
    const METHOD_DEBUG = false;
}