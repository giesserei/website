<?php
/*
 * Oktober 2013, JAL
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GiessereiModelOJournalClasse extends JModelAdmin {

	public function getTable($type="OJournalClasses",$prefix="GiessereiTable",$config=array()) {
		return JTable::getInstance($type,$prefix,$config);
	}
	
	public function getForm($data = array(), $loadData = true) {
		$options = array('control' => 'jform', 'load_data' => $loadData);
		$form = $this->loadForm('ojounralclasses','ojournalclasse',$options);
		
		if(empty($form)) {
			return(false);
		}
		return $form;
	}

	protected function loadFormData() {
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_giesserei.edit.ojournalclasse.data',array());
		
		if(empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}

}

?>
