<?php
defined('_JEXEC') or die();

JLoader::register('GiessereiAuth', JPATH_COMPONENT . '/helpers/giesserei_auth.php');

/**
 * Controller für die Anzeige der Alterstruktur als Histogramm.
 *
 * => RAW wird benötigt, da das Template noch nicht HTML5 kompatibel ist.
 */
class GiessereiControllerAlter extends JControllerLegacy
{
    /**
     * Liefert die aktuelle Adressliste aller aktiven Mitglieder und des Gewerbes.
     */
    public function alterKlassen()
    {
        $model = $this->getModel('alter');
        $model->getAlterKlassenHtml5();
    }

}