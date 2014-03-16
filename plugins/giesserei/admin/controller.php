<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiController extends JController {

	/**
	 * Wenn keine View gewählt wurde, wird die View "welcome" gezeigt.
	 *  
	 * @see JController::display()
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$input = JFactory::getApplication()->input;

		// alle Variablen mit Vorgabewerten initialisieren
		$view   = $input->get('view', "empty");
		$layout = $input->get('layout', 'default');
		$task   = $input->get('task', 'default');
		$id     = $input->get('id');

		if ($view === 'empty') {
		  $this->setRedirect(JRoute::_('index.php?option=com_giesserei&view=welcome', false));
		  return false;
		}
		
		// Zugriffe prüfen
		if (! $this->isAuthorised($view, $task)) {
		  return false;
		}
		
		// Submenü erstellen
		$this->addSubmenu($view);

		// Alles geprüft und ok, die View kann ausgegeben werden
		parent::display($cachable, $urlparams);	
	}
	
	// -------------------------------------------------------------------------
	// private section
	// -------------------------------------------------------------------------
	
	private function isAuthorised($view, $task) {
	  $user = JFactory::getUser();
	  $assetname = 'com_giesserei';
	  
	  if ($view === 'members') {
	    return $user->authorise('view.member', $assetname);
	  }
	  if (GiessereiHelper::startsWith($task, 'member')) {
	    return $user->authorise('edit.member', $assetname) || $user->authorise('edit.member.vkom', $assetname);
	  }
	  if ($view === 'kids') {
	    return $user->authorise('view.kid', $assetname);
	  }
	  if (GiessereiHelper::startsWith($task, 'kid')) {
	    return $user->authorise('edit.kid', $assetname) || $user->authorise('edit.kid.vkom', $assetname);
	  }
	  if ($view === 'flats') {
	    return $user->authorise('view.flat', $assetname);
	  }
	  if (GiessereiHelper::startsWith($task, 'flat')) {
	    return $user->authorise('edit.flat', $assetname);
	  }
	  
	  return true;
	}
	
	/**
	 * In der Listenansicht im Contentbereich ein Submenü aufbauen. Hierbei werden die vorhandenen Berechtigungen 
	 * berücksichtigt.
	 */
	private function addSubmenu($name) {
	  $user = JFactory::getUser();
	  $assetname = 'com_giesserei';
	  
    JSubMenuHelper::addEntry(
      JText::_('Start'),
      'index.php?option=com_giesserei&view=welcome', $name == 'welcome'
    );
	  
	  if ($user->authorise('view.member', $assetname)) {
	    JSubMenuHelper::addEntry(
	      JText::_('Mitgliederliste'),
	      'index.php?option=com_giesserei&view=members', $name == 'members'
	    );
	  }
	
	  if ($user->authorise('view.kid', $assetname)) {
	    JSubMenuHelper::addEntry(
	      JText::_('Kinder'),
	      'index.php?option=com_giesserei&view=kids', $name == 'kids'
	    );
	  }
	
	  if ($user->authorise('view.flat', $assetname)) {
	    JSubMenuHelper::addEntry(
	      JText::_('Wohnungen'),
	      'index.php?option=com_giesserei&view=flats', $name == 'flats'
	    );
	  }
	
	  // nutzen wir zunächst nicht -> Einsatz ist nicht geklärt
	  /*
	  JSubMenuHelper::addEntry(
	    JText::_('Mitglieder-Journal-Klassen'),
	    'index.php?option=com_giesserei&view=mjournalclasses', $name == 'mjournalclasses'
	  );
	  */
	
	  // nutzen wir zunächst nicht -> Einsatz ist nicht geklärt
	  /*
	  JSubMenuHelper::addEntry(
	    JText::_('Wohnungs-Journal-Klassen'),
	    'index.php?option=com_giesserei&view=ojournalclasses', $name == 'ojournalclasses'
	  );
	  */
	
	}
}
?>