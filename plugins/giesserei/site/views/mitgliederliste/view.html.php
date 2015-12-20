<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewMitgliederliste extends JViewLegacy
{

    protected $mitglieder;

    public function display($tpl = null)
    {
        $model = $this->getModel();
        $this->mitglieder = $model->getMitglieder();
        parent::display($tpl);
    }
}