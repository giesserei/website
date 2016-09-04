<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewWohnungsliste extends JViewLegacy
{

    protected $wohnungen;

    public function display($tpl = null)
    {
        $model = $this->getModel();
        $this->wohnungen = $model->getWohnungen();
        parent::display($tpl);
    }
}
