<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');


/**
 * Controller zum Editieren der Stammdaten eines Kindes.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdkind extends GiessereiControllerUpdBase {
  
  /**
   * Bevor die Basisklasse ausgeführt wird, wird die ID des zu ändernden Kindes in der Session gespeichert.
   * Asserdem wird die Berechtigung zum Bearbeiten der Daten geprüft.
   */
  public function edit() {
    $app = JFactory::getApplication();
    $input = $app->input;
    $kindId = $input->get("kind_id");
    
    $model = $this->getModel();
    if (!$model->isOwner($kindId)) {
      $app->enqueueMessage('Keine Berechtigung!', 'warning');
      return false;
    } 
    
    $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID, $kindId);
    return parent::edit();
  }
  
  /**
   * Bevor die Daten vom Kind gespeichert werden, wird geprüft, ob der Benutzer die Berechtigung hierfür hat.
   */
  public function save() {
    $app = JFactory::getApplication();
    $model = $this->getModel();
    
    if (!$model->isOwner()) {
      $app->enqueueMessage('Keine Berechtigung!', 'warning');
      return false;
    }
    
    $result = parent::save();
    
    if ($result) {
      // ID nach dem Speichern wieder löschen aus der Session
      $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID, null);
    }
  }
  
  // -------------------------------------------------------------------------
  // protected section
  // -------------------------------------------------------------------------

  protected function getViewName() {
    return "updkind";
  }

  protected function saveDataInSession() {
    return true;
  }

  protected function filterFormFields($data) {
    $dataAllowed = array();
    $dataAllowed['name_frei'] = $data['name_frei'];
    $dataAllowed['jahrgang_frei'] = $data['jahrgang_frei'];
    $dataAllowed['handy'] = $data['handy'];
    $dataAllowed['handy_frei'] = $data['handy_frei'];
    
    return $dataAllowed;
  }
  
  /**
   * Daten ggf. in die DB-Darstellung umformatieren.
   */
  protected function formatData($data) {
    // Checkboxen auf 0 setzen, wenn nicht abgefüllt
    if (empty($data['name_frei'])) {
      $data['name_frei'] = 0;
    }
    if (empty($data['jahrgang_frei'])) {
      $data['jahrgang_frei'] = 0;
    }
    if (empty($data['handy_frei'])) {
      $data['handy_frei'] = 0;
    }
  
    return $data;
  }
  
}