<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Tabelle zum Speichern der Wohnungen.
 */
class GiessereiTableFlats extends JTable
{
    public $id;
    public $typid;
    public $miete;
    public $subventioniert;
    public $nk;
    public $nk_stadtwerk;
    public $flaeche;
    public $maisonette;
    public $grundriss;
    public $anmerkung;
    public $freiab;
    public $kz_frei;
    public $nasszellen;
    public $reduit;
    public $mietvertrag_beginn;
    public $gewerbe_flaeche;
    public $oto;
    protected $bezeichnung;
    protected $zimmerbezeichnung;

    public function __construct(&$db)
    {
        parent::__construct('#__mgh_mietobjekt', 'id', $db);
    }

    public function store($updateNulls = true)
    {
        return parent::store($updateNulls);
    }

    public function bind($src, $ignore = array())
    {
        if (!parent::bind($src, $ignore)) {
           return false;
        }
        $this->fixUpDateValues();
        return true;
    }

    private function fixUpDateValues() {
        $this->fixUpDateValue('freiab');
        $this->fixUpDateValue('mietvertrag_beginn');
    }

    private function fixUpDateValue($fieldName) {
        if (empty($this->$fieldName) || str_starts_with($this->$fieldName, '0000-')) {
            $this->$fieldName = null;
        }
    }


}
