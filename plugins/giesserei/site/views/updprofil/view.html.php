<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

/**
 * View-Klasse für das Edit-Formular.
 */
class GiessereiViewUpdprofil extends JViewLegacy
{
    protected $item;

    protected $form;

    protected $menuId;

    public function display($tpl = null)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiViewUpdprofil', 'display');

        $app = JFactory::getApplication();

        // Item nur für Anzeige des Names holen
        $this->item = $this->get('Item');

        // Form holen für Aufbereitung des Formulars
        $this->form = $this->get('Form');

        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode('\n', $errors));
        }

        GiessereiFrontendHelper::addComponentStylesheet();

        // Ohne Wirkung nicht, da das CSS erst nach dem Template eingebunden wird
        // Im edit.php wird das Header-Image daher mit JS ausgeblendet
        //GiessereiFrontendHelper::hideHeaderImage();

        // Menü-Id wird in View im Form-Action gesetzt
        $this->menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);

        parent::display($tpl);
    }
}