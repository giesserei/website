<?php
/*
 * Created on 27.12.2010; Sub?
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GiessereiModelKid extends JModelAdmin {

	public function getTable($type="Kids",$prefix="GiessereiTable",$config=array()) {
		return JTable::getInstance($type,$prefix,$config);
	}
	
	public function getForm($data = array(), $loadData = true) {
		$options = array('control' => 'jform', 'load_data' => $loadData);
		$form = $this->loadForm('kids','kid',$options);
		
		if(empty($form)) {
			return(false);
		}
		return $form;
	}

	protected function loadFormData() {
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_giesserei.edit.kid.data',array());
		
		if(empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}

}

?>
