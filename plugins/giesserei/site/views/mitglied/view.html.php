<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMitglied extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
    $mitglied = $model->getMitglied(JRequest::getVar('id'));
    $this->assignRef('mitglied',$mitglied);
    parent::display($tpl);
  }
}
?>
