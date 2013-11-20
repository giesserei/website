<?php
/*
 * Oktober 2013, JAL
 *
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMember extends JView {
	
	protected $item;
	protected $form;
	
	public function display($tpl = null) {
		JFactory::getApplication()->input->set('hidemainmenu',true);
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		
		$this->addToolbar();
		parent::display($tpl);
	
	}
	
	
	protected function addToolbar() {
		$isNew = ($this->item->userid < 1); 
		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title( 'Mitglied: <small>['.$text.']</small>');
		JToolBarHelper::save('member.save','JTOOLBAR_SAVE');

		if($isNew):
			JToolBarHelper::cancel('member.cancel', 'Abbrechen');
		else:
			JToolBarHelper::cancel( 'member.cancel', 'Schliessen' );
		endif;	
		
	}
}
?>
