<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.application.component.modeladmin');
jimport('joomla.log.log');

/**
 * Model zum Ändern des Passworts eines Mitglieds.
 * 
 * @author Steffen Förster
 */
class GiessereiModelUpdpassword extends JModelAdmin {

  /**
   * @see JModelAdmin::getItem()
   */
  public function getItem($pk = null) {
    $app = JFactory::getApplication();
    $user = JFactory::getUser();
    $item = parent::getItem($user->id);
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
    GiessereiFrontendHelper::methodBegin('GiessereiModelUpdpassword', 'getForm', 'loadData:'.$loadData);
    
    $form = $this->loadForm('com_giesserei.updpassword', 'updpassword', array (
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
    
    $result = $this->validatePassword($data['password'], $data['password2']);
    return $result;
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
    
    $app = JFactory::getApplication();
    $user = JFactory::getUser();
    $table = new JUser($user->id);
    
    try {
      // Passwortfelder an die Tabelle JUser binden
      if (!$table->bind($data)) {
        return false;
      }
      
      // User speichern -> nur Update
      if (!$table->save(true)) {
        JLog::add($table->getError(), JLog::ERROR);
        $this->setError('Speichern fehlgeschlagen!');
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
    GiessereiFrontendHelper::methodBegin('GiessereiModelUpdpassword', 'loadFormData');
    
    return array();
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  
  /**
   * Liefert true, wenn die beiden Passwörter gleich sind und mindestens 8 Zeichen lang sind.
   * Die Fehlermeldung wird im Model gespeichert.
   */
  private function validatePassword($password, $password2) {
    if(strlen($password) < 8) {
      $this->setError('Das Passwort ist zu kurz');
      return false;
    }
    if($password != $password2) {
      $this->setError('Die Passwörter sind nicht gleich');
      return false;
    }
    return true;
  }
  
}