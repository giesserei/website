<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.application.component.controllerform');

/**
 * Controller zum Editieren des Profils eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdprofil extends JControllerForm {
  
  /**
   * Führt nach ein paar Vorarbeiten einen Redirect auf die View durch, welche das Profil-Formular anzeigt.
   */
  public function edit() {
    GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdprofil', 'edit');
    
    if (!GiessereiFrontendHelper::checkAuth()) {
      return false;
    }
    
    $this->redirectEditView();
    
    return true;
  }
  
  /**
   * Speichert die Formulardaten des Profils in der Datenbank.
   */
  public function save() {
    GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdprofil', 'save');
    
    $app = JFactory::getApplication();
    
    // Form-Token prüfen -> Token wird in Template gesetzt
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
    
    $formData = $this->getFormData();

    // Validierung -> Validierungsmeldungen werden direkt ausgegeben
    if (!$this->validateData($formData)) {
      return false;
    }
    
    // Daten Speichern
    if ($this->processSave($formData)) {
      // Daten in der Session löschen
      $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, null);
      $this->redirectProfilView();
      return true;
    }
    
    return false;
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  
  /**
   * Holt die Formulardaten des Profilformulars aus dem JInput.
   */
  private function getFormData() {
    $app = JFactory::getApplication();
    $input = $app->input;
    $model = $this->getModel();
    $form = $model->getForm(array(), false);
    $data = $input->get($form->getFormControl(), '', 'array');
    
    $dataAllowed = array();
    $dataAllowed['email'] = $data['email'];
    $dataAllowed['telefon'] = $data['telefon'];
    $dataAllowed['telefon_frei'] = $data['telefon_frei'];
    $dataAllowed['handy'] = $data['handy'];
    $dataAllowed['handy_frei'] = $data['handy_frei'];
    $dataAllowed['birthdate'] = $data['birthdate'];
    
    return $dataAllowed;
  }
  
  /**
   * Prüft, ob die Eingaben korrekt sind. Sind die Eingaben nicht korrekt, werden die 
   * Eingaben in der Session gespeichert, damit diese erneut angezeigt werden können.
   * 
   * Validierungsmeldungen werden direkt ausgegeben.
   * 
   * @return boolean True, wenn alle Eingaben korrekt sind.
   */
  private function validateData($data) {
    $app = JFactory::getApplication();
    $model = $this->getModel();
    $form = $model->getForm($data, false);
    
    $result = $model->validate($form, $data);
    
    // Nur die ersten drei Fehler dem Benutzer anzeigen
    if ($result === false) {
      $errors = $model->getErrors();
    
      for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
        if ($errors[$i] instanceof Exception) {
          $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
        }
        else {
          $app->enqueueMessage($errors[$i], 'warning');
        }
      }
    
      // Daten in der Session speichern
      $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, $data);
    
      // Zurück zum Formular
      $this->redirectEditView();
    
      return false;
    }
    
    return true;
  }
  
  /**
   * Speichert die Daten. Tritt ein Fehler auf, werden die Eingaben in der Session gespeichert, 
   * damit diese erneut angezeigt werden können. 
   * 
   * Fehlermeldungen werden direkt angezeigt.
   *
   * @return boolean True, wenn das Speichern erfolgreich war
   */
  private function processSave($data) {
    $app = JFactory::getApplication();
    $model = $this->getModel();
    
    $data = $this->formatData($data);
  
    // Fehlermeldung dem Benutzer anzeigen
    if (!$model->save($data)) {
      $errors = $model->getErrors();
      foreach ($errors as $error) {
        $app->enqueueMessage($error, 'warning');
      }
  
      // Daten in der Session speichern
      $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, $data);
  
      // Zurück zum Formular
      $this->redirectEditView();
  
      return false;
    }
  
    return true;
  }
  
  /**
   * Daten ggf. in die DB-Darstellung umformatieren.
   */
  private function formatData($data) {
    // Checkboxen auf 0 setzen, wenn nicht abgefüllt
    if (empty($data['telefon_frei'])) {
      $data['telefon_frei'] = 0;
    }
    if (empty($data['handy_frei'])) {
      $data['handy_frei'] = 0;
    }
    
    // Geburtstag formatieren
    $data['birthdate'] = GiessereiFrontendHelper::viewDateToMySqlDate($data['birthdate']);
    
    return $data;
  }
  
  /**
   * Auf die Edit-View weiterleiten. Es wird auch die Menü-Id der Profilseite gesetzt, damit das Menü sich nicht verstellt.
   */
  private function redirectEditView() {
    $app = JFactory::getApplication();
    $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
    $this->setRedirect(
        JRoute::_('index.php?option=com_giesserei&view=updprofil&layout=edit&Itemid=' . $menuId, false)
    );
  }
  
  /**
   * Auf die Profilansicht weiterleiten.
   */
  private function redirectProfilView() {
    $app = JFactory::getApplication();
    $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
    $this->setRedirect(
        JRoute::_('index.php?option=com_giesserei&view=profil&layout=view', false)
    );
  }
  
}