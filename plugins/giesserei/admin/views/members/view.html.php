<?php
/*
 * Oktober 2013, JAL
 *
 */
 defined('_JEXEC') or die('Restricted access');

 jimport('joomla.application.component.view');

 class GiessereiViewMembers extends JView {
 	protected $items;
 	protected $pagination;
 	protected $state;
 	protected $sortDirection;
 	protected $sortColumn;
 	
 	public function display($tpl = null) {
 		JToolBarHelper::title('Mitgliederlisten-Verwaltung','user.png');
 		JToolBarHelper::addNew('member.add','JTOOLBAR_NEW');
 		JToolBarHelper::editList('member.edit','JTOOLBAR_EDIT');
 		JToolBarHelper::deleteList('','members.delete','JTOOLBAR_DELETE');
 		JToolBarHelper::preferences('com_giesserei');
 		
 		$this->items = $this->get('Items');
 		
 		$this->state = $this->get('State');
 		$this->pagination = $this->get('Pagination');
 		
 		$this->sortDirection = $this->state->get('list.direction');
 		$this->sortColumn = $this->state->get('list.ordering');
 		
 		parent::display($tpl);
 	}
 }
  
?>
