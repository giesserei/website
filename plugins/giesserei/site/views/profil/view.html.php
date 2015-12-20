<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

/**
 * View-Klasse für die Profil-Ansicht.
 *
 * @author Steffen Förster
 */
class GiessereiViewProfil extends JViewLegacy
{

    protected $profilData;

    protected $menuId;

    function display($tpl = null)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiViewProfil', 'display');

        $app = JFactory::getApplication();

        if (!GiessereiFrontendHelper::checkAuth()) {
            return false;
        }

        // Form-Daten aus Session löschen -> User hat die letzte Eingabe vielleicht nicht abgeschlossen
        $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, null);
        $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID, null);

        // Profil aus Model laden
        $model = $this->getModel();
        $this->profilData = $model->getProfilData();

        GiessereiFrontendHelper::addComponentStylesheet();

        // Menü-Id in der User-Session speichern
        $jinput = $app->input;
        $menuId = $jinput->get("Itemid", "0", "INT");
        $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID, $menuId);

        parent::display($tpl);
    }
} 