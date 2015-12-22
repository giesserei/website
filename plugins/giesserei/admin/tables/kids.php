<?php
defined('_JEXEC') or die('Restricted access');

/**
 * Tabelle zum Speichern der Kinder.
 */
class GiessereiTableKids extends JTable
{

    public $id;
    public $vorname;
    public $nachname;
    public $name_frei;
    public $jahrgang;
    public $jahrgang_frei;
    public $handy;
    public $handy_frei;
    public $objektid;

    public function __construct(&$db)
    {
        parent::__construct('#__mgh_kind', 'id', $db);
    }
}
