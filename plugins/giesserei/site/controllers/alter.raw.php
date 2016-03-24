<?php
defined('_JEXEC') or die();

JLoader::register('GiessereiAuth', JPATH_COMPONENT . '/helpers/giesserei_auth.php');

jimport('joomla.application.component.controller');

/**
 * Controller für die Anzeige der Alterstruktur als Histogramm.
 *
 * => RAW wird benötigt, da das Templete noch nicht HTML5 kompatibel ist.
 *
 * @author Steffen Förster
 */
class GiessereiControllerAlter extends JController
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