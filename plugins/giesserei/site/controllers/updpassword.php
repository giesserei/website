<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.application.component.controllerform');

/**
 * Controller zum Ändern des Passworts eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdpassword extends JControllerForm {
  
  /**
   * Führt nach ein paar Vorarbeiten einen Redirect auf die View durch, welche das Passwort-Formular anzeigt.
   */
  public function edit() {
    GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdpassword', 'edit');
    
    if (!GiessereiFrontendHelper::checkAuth()) {
      return false;
    }
    
    $this->redirectEditView();
    
    return true;
  }
  
  /**
   * Speichert das neue Passwort in der Datenbank.
   */
  public function save() {
    GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdpassword', 'save');
    
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
      $this->redirectProfilView();
      return true;
    }
    
    return false;
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  
  /**
   * Holt die Formulardaten aus dem JInput. Es sind nur die Passwortfelder zulässig.
   */
  private function getFormData() {
    $app = JFactory::getApplication();
    $input = $app->input;
    $model = $this->getModel();
    $form = $model->getForm(array(), false);
    $data = $input->get($form->getFormControl(), '', 'array');
    
    $dataAllowed = array();
    $dataAllowed['password'] = $data['password'];
    $dataAllowed['password2'] = $data['password2'];
    
    return $dataAllowed;
  }
  
  /**
   * Prüft, ob die Eingaben korrekt sind. Validierungsmeldungen werden direkt ausgegeben.
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
    
      // Zurück zum Formular
      $this->redirectEditView();
    
      return false;
    }
    
    return true;
  }
  
  /**
   * Speichert das neue Passwort. Der Code entstammt teilweise vom Kunena-Plugin.
   * 
   * Fehlermeldungen werden direkt angezeigt.
   *
   * @return boolean True, wenn das Speichern erfolgreich war
   */
  private function processSave($data) {
    $app = JFactory::getApplication();
    $model = $this->getModel();
  
    // Fehlermeldung dem Benutzer anzeigen
    if (!$model->save($data)) {
      $errors = $model->getErrors();
      foreach ($errors as $error) {
        $app->enqueueMessage($error, 'warning');
      }
  
      // Zurück zum Formular
      $this->redirectEditView();
  
      return false;
    }
  
    return true;
  }
  
  /**
   * Auf die Edit-View weiterleiten. Es wird auch die Menü-Id der Profilseite gesetzt, damit das Menü sich nicht verstellt.
   */
  private function redirectEditView() {
    $app = JFactory::getApplication();
    $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
    $this->setRedirect(
        JRoute::_('index.php?option=com_giesserei&view=updpassword&layout=edit&Itemid=' . $menuId, false)
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