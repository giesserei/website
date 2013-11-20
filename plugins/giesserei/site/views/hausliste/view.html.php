<?php 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewHausliste extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
    $objekte = $model->getBelegung();
    $this->assignRef('objekte',$objekte);
    parent::display($tpl);
  }
}
?> 
