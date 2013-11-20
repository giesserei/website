<?php
/*
 * Created on 27.12.2010
 *
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewOJournal extends JView {
	
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
        if($this->item->objektid == 0) $this->item->objektid = $input->get->get('objektid');


		$isNew = ($this->item->id < 1); 
		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title( 'Objekt-Journal: <small>['.$text.']</small>');
		JToolBarHelper::save('ojournal.save','JTOOLBAR_SAVE');


		if($isNew):
			JToolBarHelper::back('Abbrechen');
		else:
			JToolBarHelper::back('Schliessen' );
		endif;	
		
	}

}
?>
