<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewWhgDetail extends JViewLegacy
{

    protected $wohnung;

    public function display($tpl = null)
    {
        $model = $this->getModel();
        $this->wohnung = $model->getWohnung(JRequest::getVar('whgnr'));
        parent::display($tpl);
    }
}
