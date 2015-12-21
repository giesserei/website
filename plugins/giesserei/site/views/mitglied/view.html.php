<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewMitglied extends JViewLegacy
{

    protected $mitglied;

    public function display($tpl = null)
    {
        $model = $this->getModel();
        $this->mitglied = $model->getMitglied(JRequest::getVar('id'));
        parent::display($tpl);
    }
}
