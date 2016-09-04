<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewMitgliederliste extends JViewLegacy
{

    public function display($tpl = null)
    {
        parent::display($tpl);
    }

    protected function getBewohner()
    {
        return $this->getModel()->getMitglieder(1);
    }

    protected function getGewerbe()
    {
        return $this->getModel()->getMitglieder(2);
    }

    protected function getPassivmitglieder()
    {
        return $this->getModel()->getMitglieder(3);
    }

    protected function getAnzahlBewohner()
    {
        return $this->getModel()->getAnzahlMitglieder(1);
    }

    protected function getAnzahlGewerbe()
    {
        return $this->getModel()->getAnzahlMitglieder(2);
    }

    protected function getAnzahlPassivmitglieder()
    {
        return $this->getModel()->getAnzahlMitglieder(3);
    }
}