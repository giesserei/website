<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');

jimport('joomla.application.component.controllerform');

/**
 * Controller zum Ändern des Passworts eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdpassword extends GiessereiControllerUpdBase {
  
  // -------------------------------------------------------------------------
  // protected section
  // -------------------------------------------------------------------------
  
  /**
   * @see GiessereiControllerUpdBase::getViewName()
   */
  protected function getViewName() {
    return "updpassword";
  }
  
  /**
   * @see GiessereiControllerUpdBase::saveDataInSession()
   */
  protected function saveDataInSession() {
    return false;
  }
  
  /**
   * @see GiessereiControllerUpdBase::filterFormFields()
   */
  protected function filterFormFields($data) {
    $dataAllowed = array();
    $dataAllowed['password'] = $data['password'];
    $dataAllowed['password2'] = $data['password2'];
  
    return $dataAllowed;
  }
  
}