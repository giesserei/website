<?php 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMitgliederliste extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
    $mitglieder = $model->getMitglieder();
    $this->assignRef('mitglieder',$mitglieder);
    parent::display($tpl);
  }
}
?> 
