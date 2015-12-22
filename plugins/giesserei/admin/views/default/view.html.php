<?php
defined('_JEXEC') or die();

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

/**
 * Default-Seite für die Vereinsverwaltung, wenn keine spezielle View gewählt wurde.
 *
 * @author Steffen Förster
 */
class GiessereiViewDefault extends JViewLegacy
{

    public function display($tpl = null)
    {
        JToolBarHelper::title('Vereinsverwaltung Giesserei');
        GiessereiHelper::addSubmenu('default');
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }
}