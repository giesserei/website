<?php
defined('_JEXEC') or die;

/**
 * Tabelle zum Speichern der Historie der Mitglieder-Daten.
 */
class GiessereiTableMembersHistory extends JTable
{

    public $id_hist = 0; // Primary-Key

    public $id;
    public $userid = null;
    public $vorname = null;
    public $nachname = null;
    public $adresse = null;
    public $plz = null;
    public $ort = null;
    public $telefon = null;
    public $telefon_frei;
    public $handy = null;
    public $handy_frei;
    public $jahrgang;
    public $zur_person;
    public $funktion;
    public $eintritt;
    public $austritt;
    public $einzug;
    public $typ;
    public $update_userid;
    public $update_timestamp;
    public $dispension_grad;
    public $kommentar;
    public $zb_freistellung;
    public $zb_ausbildung_bis;

    private $id_to_save;

    public function __construct(&$db)
    {
        parent::__construct('#__mgh_mitglied_history', '$id_hist', $db);
    }

    /**
     * Setzt die id des Mitglieds, dessen Daten historisiert werden sollen.
     *
     * @param int $id ID des Mitglieds
     */
    public function setIdToSave($id)
    {
        $this->id_to_save = $id;
    }

    /**
     * Es kann nur ein neuer Datensatz angelegt werden.
     */
    public function store($updateNulls = false)
    {
        if (!empty($this->id_to_save) && $this->id_hist == 0) {
            $memberTable = JTable::getInstance('Members', 'GiessereiTable', array());
            $memberTable->load($this->id_to_save);
            $this->bind($memberTable);

            return parent::store($updateNulls);
        } else {
            return true;
        }
    }

}
