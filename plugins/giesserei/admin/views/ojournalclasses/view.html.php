<?php
/*
 * Oktober 2013, JAL
 *
 */
 defined('_JEXEC') or die('Restricted access');

 jimport('joomla.application.component.view');

 class GiessereiViewOJournalClasses extends JViewLegacy {
 	protected $items;
 	protected $pagination;
 	protected $state;
 	
 	public function display($tpl = null) {
 		JToolBarHelper::title('Wohnungslisten-Verwaltung: Journal-Klassen','user.png');
 		JToolBarHelper::addNew('ojournalclasse.add','JTOOLBAR_NEW');
 		JToolBarHelper::editList('ojournalclasse.edit','JTOOLBAR_EDIT');
 		JToolBarHelper::deleteList('','ojournalclasses.delete','JTOOLBAR_DELETE');
 		
 		$this->items = $this->get('Items');
 		
 		$this->state = $this->get('State');
 		$this->pagination = $this->get('Pagination');
 		
 		parent::display($tpl);
 	}
 }
  
?>
