<?php 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewWohnungsliste extends JView {
  function display($tpl = null) {
    $model =& $this->getModel();
    $wohnungen = $model->getWohnungen();
    $this->assignRef('wohnungen',$wohnungen);
    parent::display($tpl);
  }
}
?> 
