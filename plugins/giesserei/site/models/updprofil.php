<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.application.component.modeladmin');
jimport('joomla.log.log');

/**
 * Model zum Editieren des Profils eines Mitglieds.
 * 
 * @author Steffen Förster
 */
class GiessereiModelUpdprofil extends JModelAdmin {

  /**
   * @see JModelAdmin::getItem()
   */
  public function getItem($pk = null) {
    $app = JFactory::getApplication();
    $user = JFactory::getUser();
    $item = parent::getItem($user->id);
    
    $db = & JFactory::getDBO();
    
    // E-Mailadresse zuweisen
    $query = 'SELECT * FROM #__users WHERE id=' . $item->userid;
    $db->setQuery($query);
    $userRow = $db->loadObject();
    $item->email = $userRow->email;
    
    // Geburtstag zuweisen
    $query = 'SELECT * FROM #__kunena_users WHERE userid=' . $item->userid;
    $db->setQuery($query);
    $kunenaRow = $db->loadObject();
    $item->birthdate = $kunenaRow->birthdate;
    $item->birthdate = GiessereiFrontendHelper::mysqlDateToViewDate($item->birthdate);
    
    return $item;
  }

  /**
   * @see JModel::getTable()
   */
  public function getTable($type = 'Profil', $prefix = 'GiessereiTable', $config = array()) {
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * @see JModelForm::getForm()
   */
  public function getForm($data = array(), $loadData = true) {
    GiessereiFrontendHelper::methodBegin('GiessereiModelUpdprofil', 'getForm', 'loadData:'.$loadData);
    
    $form = $this->loadForm('com_giesserei.updprofil', 'updprofil', array (
        'control' => 'jform',
        'load_data' => $loadData 
    ));
    
    if (empty($form)) {
      return false;
    }
    
    return $form;
  }
  
  /**
   * Nachdem die Regeln der Form-Validierung geprüft wurden, werden weitere Validierungen durchgeführt.
   * Liefert true, wenn alle Validierungen erfolgreich waren; sonst false. Die Fehlermeldungen sind im 
   * Model abgelegt.
   * 
   * @see JModelForm::validate()
   */
  public function validate($form, $data) {
    $result = parent::validate($form, $data);
    if ($result === false) {
      return false;
    }
    
    $valid = 1;
    $valid &= $this->validateBirthdate($data['birthdate']);
    $valid &= $this->validateEmail($data['email']);
    
    return (bool) $valid;
  }
  
  /**
   * Eigene Implementierung der save-Methode.
   * 
   * @return true, wenn das Speichern erfolgreich war, sonst false
   * 
   * @see JModelAdmin::save()
   */
  public function save($data) {
    GiessereiFrontendHelper::methodBegin('GiessereiModelUpdprofil', 'save');
    
    $user = JFactory::getUser();
    $table = $this->getTable();
  
    try {
      // Daten in die Tabellen-Instanz laden
      $table->load($user->id);
      
      // Properties mit neuen Daten überschreiben 
      // ID und User-ID nicht überschreiben -> sicherstellen, dass diese nicht verändert werden
      if (!$table->bind($data, "id, userid")) {
        $this->setError($table->getError());
        return false;
      }
  
      // Tabelle kann vor dem Speichern letzte Datenprüfung vornehmen
      if (!$table->check()) {
        $this->setError($table->getError());
        return false;
      }
  
      // Jetzt Daten speichern
      if (!$table->store()) {
        $this->setError($table->getError());
        return false;
      }
    }
    catch (Exception $e) {
      JLog::add($e->getMessage(), JLog::ERROR);
      $this->setError('Speichern fehlgeschlagen!');
      return false;
    }

    return true;
  }
  
  // -------------------------------------------------------------------------
  // protected section
  // -------------------------------------------------------------------------

  /**
   * @see JModelForm::loadFormData()
   */
  protected function loadFormData() {
    GiessereiFrontendHelper::methodBegin('GiessereiModelUpdprofil', 'loadFormData');

    $data = JFactory::getApplication()->getUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, array ());
    
    if (empty($data)) {
      $data = $this->getItem();
    }
    
    return $data;
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  
  /**
   * Liefert true, wenn das Geburtsdatum das korrekte Format hat; sonst false.
   * Die Fehlermeldung wird im Model gespeichert.
   */
  private function validateBirthdate($birthdate) {
    if (!empty($birthdate)) {
      $parsedDate = date_parse_from_format('d.m.Y', $birthdate);
      if ($parsedDate['error_count'] > 0 
        || !checkdate ($parsedDate['month'] , $parsedDate['day'] , $parsedDate['year'])
        || $parsedDate['year'] < 1900 
        ||  $parsedDate['year'] > 2100) {
        
        $this->setError('Dein Geburtstag hat ein falsches Format');
        return false;
      }
    }
    return true;
  }
  
  /**
   * Liefert true, wenn die E-Mail Adresse nicht bereits bei einem User gespeichert ist.
   * Das Format wurde bereits bei der Form-Validierung geprüft (client- und server-seitig).
   */
  private function validateEmail($email) {
    $db = & JFactory::getDBO();
    
    $user = JFactory::getUser();
    $query = sprintf("SELECT * FROM #__users WHERE id!=" . $user->id . " AND lower(email) = '%s'",
        mysql_real_escape_string($email)); // verhindert SQL-Injection
    
    $db->setQuery($query);
    $userRow = $db->loadObject();
    
    if ($userRow != null) {
      $this->setError('Diese E-Mail Adresse ist bereits vergeben');
      return false;
    }

    return true;
  }
}