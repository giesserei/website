<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.log.log');

/**
 * JTable für die Profilbearbeitung.
 *
 * @author Steffen Förster
 */
class GiessereiTableProfil extends JTable {
  
  const MSG_ERROR_STORE = 'Speichern fehlgeschlagen!';
  
  // Benötigte Tabellenfelder aus der Tabelle #__mgh_mitglied
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
  public $zur_person = null;
  
  // Zusätzliche Properties aus anderen Tabellen
  protected $email;
  protected $birthdate;
  
  public function __construct(&$db) {
    parent::__construct('#__mgh_mitglied', 'userid', $db);
  }
  
  /**
   * Vor dem Speichern eines Datensatzes werden die Daten aus den zusätzlichen
   * Properties in andere Tabellen gespeichert.
   */
  public function store($updateNulls = false, $otherTables = true) {
    $app = JFactory::getApplication();
    $db = & JFactory::getDBO();
    
    if ($otherTables) {
      // E-Mail speichern
      $query = sprintf("UPDATE #__users SET email = '%s' WHERE id=" . $this->userid,
          mysql_real_escape_string($this->email));
      $db->setQuery($query);
      if (! $db->query()) {
        JLog::add($db->getErrorMsg(), JLog::ERROR);
        $this->setError(GiessereiTableProfil::MSG_ERROR_STORE);
        return false;
      }
      
      // Geburtstag speichern
      $query = sprintf("UPDATE #__kunena_users SET birthdate = '%s' WHERE userid=" . $this->userid,
          $this->birthdate);
      $db->setQuery($query);
      if (! $db->query()) {
        JLog::add($db->getErrorMsg(), JLog::ERROR);
        $this->setError(GiessereiTableProfil::MSG_ERROR_STORE);
        return false;
      }
    }
    
    // restliche Daten speichern
    return parent::store(true);
  }
}  
?>
