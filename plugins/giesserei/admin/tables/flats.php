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
}
