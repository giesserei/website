<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewHausliste extends JViewLegacy
{

    protected $objekte;

    public function display($tpl = null)
    {
        $model = $this->getModel();
        $this->objekte = $model->getBelegung();
        parent::display($tpl);
    }
}
