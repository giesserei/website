<?php
/*
 * Created on 27.12.2010
 *
 */
 defined('_JEXEC') or die('Restricted access');

 jimport('joomla.application.component.view');

 class GiessereiViewKids extends JView {
 	protected $items;
 	protected $pagination;
 	protected $state;
 	
 	public function display($tpl = null) {
 		JToolBarHelper::title('Mitgliederlisten-Verwaltung: Kinder','user.png');
 		JToolBarHelper::addNew('kid.add','JTOOLBAR_NEW');
 		JToolBarHelper::editList('kid.edit','JTOOLBAR_EDIT');
 		JToolBarHelper::deleteList('','kids.delete','JTOOLBAR_DELETE');
 		
 		$this->items = $this->get('Items');
 		// $this->assignRef('items',$items);
 		
 		$this->state = $this->get('State');
 		$this->pagination = $this->get('Pagination');
 		
 		parent::display($tpl);
 	}
 }
  
?>
