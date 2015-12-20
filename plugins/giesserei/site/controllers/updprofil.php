<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');


/**
 * Controller zum Editieren des Profils eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdprofil extends GiessereiControllerUpdBase
{

    protected function getViewName()
    {
        return "updprofil";
    }

    protected function saveDataInSession()
    {
        return true;
    }

    protected function filterFormFields($data)
    {
        $dataAllowed = array();
        $dataAllowed['email'] = $data['email'];
        $dataAllowed['telefon'] = $data['telefon'];
        $dataAllowed['telefon_frei'] = $data['telefon_frei'];
        $dataAllowed['handy'] = $data['handy'];
        $dataAllowed['handy_frei'] = $data['handy_frei'];
        $dataAllowed['birthdate'] = $data['birthdate'];

        return $dataAllowed;
    }

    /**
     * Daten ggf. in die DB-Darstellung umformatieren.
     */
    protected function formatData($data)
    {
        // Checkboxen auf 0 setzen, wenn nicht abgefüllt
        if (empty($data['telefon_frei'])) {
            $data['telefon_frei'] = 0;
        }
        if (empty($data['handy_frei'])) {
            $data['handy_frei'] = 0;
        }

        // Geburtstag formatieren
        $data['birthdate'] = GiessereiFrontendHelper::viewDateToMySqlDate($data['birthdate']);

        return $data;
    }

}