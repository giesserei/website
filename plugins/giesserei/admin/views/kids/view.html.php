<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewKids extends JView {
 	protected $items;
 	protected $pagination;
 	protected $state;
 	
 	public function display($tpl = null) {
 	  $user = JFactory::getUser();
 	  $canEditFull = $user->authorise('edit.member', 'com_giesserei');
 	  
 		JToolBarHelper::title('Mitgliederlisten-Verwaltung: Kinder','user.png');
 		if ($canEditFull) {
 		  JToolBarHelper::addNew('kid.add','JTOOLBAR_NEW');
 		}
 		
 		JToolBarHelper::editList('kid.edit','JTOOLBAR_EDIT');
 		
 		if ($canEditFull) {
 		  JToolBarHelper::deleteList('','kids.delete','JTOOLBAR_DELETE');
 		}
 		
 		$this->items = $this->get('Items');
 		$this->state = $this->get('State');
 		$this->pagination = $this->get('Pagination');
 		
 		parent::display($tpl);
 	}
}
  
?>
