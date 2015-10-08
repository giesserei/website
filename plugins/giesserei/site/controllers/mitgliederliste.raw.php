<?php
defined('_JEXEC') or die();

JLoader::register('GiessereiAuth', JPATH_COMPONENT . '/helpers/giesserei_auth.php');

jimport('joomla.application.component.controller');

/**
 * Controller für den Download von Listen.
 *
 * @author Steffen Förster
 */
class GiessereiControllerMitgliederliste extends JController {

    /**
     * Liefert die aktuelle Adressliste aller aktiven Mitglieder und des Gewerbes.
     */
    public function adressliste()
    {
        if (!GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_ADDRESS_LIST)) {
            return false;
        }

        $model = $this->getModel('mitgliederliste');
        $model->exportAdresslisteToCSV();
    }

    /**
     * Liefert die aktuelle Adressliste aller aktiven Mitglieder und des Gewerbes.
     */
    public function listePassivmitglieder()
    {
        if (!GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_PASSIVE_LIST)) {
            return false;
        }

        $model = $this->getModel('mitgliederliste');
        $model->exportListePassivmitgliederToCSV();
    }

}