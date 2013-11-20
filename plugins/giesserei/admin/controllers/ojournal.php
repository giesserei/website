<?php
defined('_JEXEC') or die('Restricted access');

jimport ('joomla.application.component.controllerform');

class GiessereiControllerOJournal extends JControllerForm {
	
	// Eigene Speicher-Funktion mit automatischer Rückkehr zur Mitgliederliste
	public function save($key=null,$url=null) {
		$cache = parent::save($key,$url);		
		$this->setRedirect(JRoute::_('index.php?option=com_members&view=flats', false));
		return $cache;
	}

}

?>