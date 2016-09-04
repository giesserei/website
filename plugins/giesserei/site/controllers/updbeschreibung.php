<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');

/**
 * Controller zum Editieren der Beschreibung eines Mitglieds.
 */
class GiessereiControllerUpdbeschreibung extends GiessereiControllerUpdBase
{

    /**
     * Führt nach ein paar Vorarbeiten einen Redirect auf die View durch, von welcher der Absprung auf
     * die Profil-Seite des Forums erfolgt.
     */
    public function jumpToPhoto()
    {
        GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdbeschreibung', 'jumpToPhoto');

        if (!GiessereiFrontendHelper::checkAuth()) {
            return false;
        }

        $app = JFactory::getApplication();
        $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
        $this->setRedirect(
            JRoute::_('index.php?option=com_giesserei&view=updbeschreibung&layout=jump_to_photo&Itemid=' . $menuId, false)
        );

        return true;
    }

    // -------------------------------------------------------------------------
    // protected section
    // -------------------------------------------------------------------------

    protected function getViewName()
    {
        return "updbeschreibung";
    }

    protected function saveDataInSession()
    {
        return true;
    }

    protected function filterFormFields($data)
    {
        $dataAllowed = array();
        $dataAllowed['zur_person'] = $data['zur_person'];

        return $dataAllowed;
    }

}