<?php
defined('_JEXEC') or die();

JLoader::register('GiessereiAuth', JPATH_COMPONENT . '/helpers/giesserei_auth.php');

/**
 * Controller für den Download von Listen.
 *
 * @author Steffen Förster
 */
class GiessereiControllerMitgliederliste extends JControllerLegacy
{

    /**
     * Liefert die aktuelle Adressliste aller aktiven Mitglieder und des Gewerbes.
     *
     * @return boolean
     */
    public function adressliste()
    {
        if (!GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_ADDRESS_LIST)) {
            return false;
        }

        $model = $this->getModel('mitgliederliste');
        return $model->exportAdresslisteToCSV();
    }

    /**
     * Liefert die aktuelle Adressliste aller aktiven Mitglieder und des Gewerbes.
     *
     * @return boolean false
     */
    public function listePassivmitglieder()
    {
        if (!GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_PASSIVE_LIST)) {
            return false;
        }

        $model = $this->getModel('mitgliederliste');
        return $model->exportListePassivmitgliederToCSV();
    }

}