<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewWhgDetail extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
    $wohnung = $model->getWohnung(JRequest::getVar('whgnr'));
    $this->assignRef('wohnung',$wohnung);
    parent::display($tpl);
  }
}
?>
