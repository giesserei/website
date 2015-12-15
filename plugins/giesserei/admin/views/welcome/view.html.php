<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

/**
 * Welcome-Seite für die Vereinsverwaltung.
 * 
 * @author Steffen Förster
 */
class GiessereiViewWelcome extends JViewLegacy {
  
 	public function display($tpl = null) {
 		JToolBarHelper::title('Vereinsverwaltung Giesserei');
 		
 		$user = JFactory::getUser();
 		$assetname = 'com_giesserei';
 		
 		if ($user->authorise('core.manage', $assetname)) {
 		  JToolBarHelper::preferences('com_giesserei');
 		}
 		
 		parent::display($tpl);
 	}
}  
?>