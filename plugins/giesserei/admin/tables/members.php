<?php
defined('_JEXEC') or die('Restricted access');

/**
 * Konkrete Implementierung der JTable für die Tabelle #__mgh_mitglied.
 * 
 * Changes:
 * - Refactoring + Format + Comments (SF, 2013-12-29)
 *
 * @author JAL, created on Oktober 2013
 */
class GiessereiTableMembers extends JTable {
  // Tabellenfelder
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
  
  // Zusätzliche Properties, die für die Bearbeitung eines Datensatzes benötigt werden
  protected $email;
  protected $wohnung;
  protected $kinder;
  protected $avatar;
  protected $birthdate;
  protected $websitename;
  protected $websiteurl;
  protected $gender;
  protected $status;
  
  public function __construct(&$db) {
    parent::__construct('#__mgh_mitglied', 'id', $db);
  }
  
  /**
   * Vor dem Speichern eines Datensatzes werden die Daten aus den zusätzlichen
   * Properties in andere Tabellen gespeichert.
   */
  public function store($updateNulls = false) {
    $app = JFactory::getApplication();
    $db = & JFactory::getDBO();
    
    $date = JFactory::getDate()->toMySQL();
    $userId = JFactory::getUser()->get('id');
    
    // Wohnungen in Kreuztabelle einspeisen
    // Aufsplitten in einzelne Einträge, falls durch Komma getrennt
    $wohnungen = explode(",", $this->wohnung);
    
    if (count($wohnungen) > 0) {
      // Zuerst alle Einträge des Mitgliedes löschen
      $query = "DELETE FROM #__mgh_x_mitglied_mietobjekt WHERE userid=" . $this->userid;
      $db->setQuery($query);
      if (! $db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }
      
      // dann alle neuen Mietobjekte schreiben
      foreach ( $wohnungen as $whg ) {
        if (strval($whg) > 2000 and strval($whg) < 3000) {
          $query = "INSERT INTO #__mgh_x_mitglied_mietobjekt (userid,objektid) VALUES ('" . $this->userid . "','" . $whg . "')";
          $db->setQuery($query);
          if (! $db->query()) {
            $this->setError($db->getErrorMsg());
            return false;
          }
        }
      }
    }
    
    return parent::store($updateNulls);
  }
}
?>
