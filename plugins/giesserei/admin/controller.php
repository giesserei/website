<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiController extends JController
{
	/**
	 * @var string Standardview
	 */
	protected $default_view = 'members';

	/**
	 * Ausgabe der View members.
	 * @inherit
	 */
	public function display($cachable = false, $urlparams = false)
	{
		/* @var $input JInput Unsere Einnahmequelle */
		$input = JFactory::getApplication()->input;

		// alle Variablen mit Vorgabewerten initialisieren
		$view   = $input->get('view', $this->default_view);
		$layout = $input->get('layout', 'default');
		$id     = $input->get('id');

		// Bevor die View aufgebaut wird, erstellt die Helperklasse
		// ein Untermenü zum Wechseln zwischen Categories und Things
		GiessereiHelper::addSubmenu($view);

		if ($view == 'members' && $layout == 'edit')
		{
			// checkEditId() ist eine Methode von JController, die den Kontext prüft
			if (!$this->checkEditId('com_giesserei.edit.member', $id)) {
				// Kommentarlos zurück zur default-view
				$this->setRedirect(JRoute::_('index.php?option=com_giesserei&view=members', false));
				return false;
			}
		}

		// Alles geprüft und ok, die View kann ausgegeben werden
		parent::display($cachable, $urlparams);	
	}
}
?>