<?php 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewAGListe extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
   
    $gruppen = $model->getGruppen();

    foreach ($gruppen as $ag):
    	$mitglieder[$ag->id] = $model->getMitglieder( $ag );
	endforeach;
    
    $this->assignRef('gruppen',$gruppen);
    $this->assignRef('mitglieder',$mitglieder);
    parent::display($tpl);
  }
}

?> 
