<?php
/*
 * Oktober 2013, JAL
 *
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMJournal extends JView {
	
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
		$app = JFactory::getApplication();  // für Fehlerausgabe mittels $app->close();	
		
 		$input = JFactory::getApplication()->input;
 		
 		// Muss ein neues Record erstellt werden? -> dann kommt userid via URL (GET)
        if($this->item->userid == 0) $this->item->userid = $input->get->get('userid');


		$isNew = ($this->item->id < 1); 
		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title( 'Mitglieder-Journal: <small>['.$text.']</small>');
		JToolBarHelper::save('mjournal.save','JTOOLBAR_SAVE');

		if($isNew):
			JToolBarHelper::back('Abbrechen');
		else:
			JToolBarHelper::back('Schliessen' );
		endif;	
		
	}

}
?>
