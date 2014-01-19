<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');

jimport('joomla.application.component.controllerform');

/**
 * Controller zum Editieren der Beschreibung eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiControllerUpdbeschreibung extends GiessereiControllerUpdBase {
  
  // -------------------------------------------------------------------------
  // protected section
  // -------------------------------------------------------------------------
  
  /**
   * @see GiessereiControllerUpdBase::getViewName()
   */
  protected function getViewName() {
    return "updbeschreibung";
  }
  
  /**
   * @see GiessereiControllerUpdBase::saveDataInSession()
   */
  protected function saveDataInSession() {
    return true;
  }
  
  /**
   * @see GiessereiControllerUpdBase::filterFormFields()
   */
  protected function filterFormFields($data) {
    $dataAllowed = array();
    $dataAllowed['zur_person'] = $data['zur_person'];
  
    return $dataAllowed;
  }
  
}