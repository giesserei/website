<?php
/*
 * Created on 27.12.2010
 *
 */
 defined('_JEXEC') or die('Restricted access');

 jimport('joomla.application.component.view');

 class GiessereiViewFlats extends JView {
 	protected $items;
 	protected $pagination;
 	protected $state;
 	
 	public function display($tpl = null) {
 		JToolBarHelper::title('Wohnungslisten-Verwaltung','user.png');
 		JToolBarHelper::addNew('flat.add','JTOOLBAR_NEW');
 		JToolBarHelper::editList('flat.edit','JTOOLBAR_EDIT');
 		JToolBarHelper::deleteList('','flats.delete','JTOOLBAR_DELETE');
 		
 		$this->items = $this->get('Items');
 		
 		$this->state = $this->get('State');
 		$this->pagination = $this->get('Pagination');
 		
 		parent::display($tpl);
 	}
 }
  
?>
