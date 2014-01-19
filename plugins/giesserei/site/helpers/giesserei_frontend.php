<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

/**
 * Helperklasse.
 *
 * @author Steffen Förster
 */
class GiessereiFrontendHelper {

  /**
   * Umwandlung der MySql-Datumsdarstellung (Y-m-d) in die benutzerfreundliche Darstellung.
   * 
   * @param string $dateDb Datum in der MySql-Datumsdarstellung
   */
  public static function mysqlDateToViewDate($dateDb) {
    if ($dateDb == '0001-01-01') {
      return '';
    }
    else {
      $date = DateTime::createFromFormat('Y-m-d', $dateDb);
      return $date->format('d.m.Y');
    }
  }
  
  /**
   * Umwandlung der View-Datumsdarstellung (d.m.Y) in die MySql-Darstellung.
   *
   * @param string $date Datum in der View-Datumsdarstellung (kann auch ein Leerstring sein)
   */
  public static function viewDateToMySqlDate($dateView) {
    $dateDb = '0001-01-01';
    if (!empty($dateView)) {
      $date = DateTime::createFromFormat('d.m.Y', $dateView);
      $dateDb = $date->format('Y-m-d');
    }
    return $dateDb;
  }
  
  /**
   * Fügt das Stylesheet dieser Komponente zum Dokument hinzu.
   */
  public static function addComponentStylesheet() {
    GiessereiFrontendHelper::addStylesheet('giesserei_default.css');
  }

  /**
   * Fügt das Stylesheet hinzu, welches das Header-Image ausblendet.
   */
  public static function hideHeaderImage() {
    GiessereiFrontendHelper::addStylesheet('no_header_immage.css');
  }
  
  /**
   * Liefert den Javascript-Code, welcher das Header-Image ausblendet.
   */
  public static function getScriptToHideHeaderImage() {
    return '<!-- Header-Images ausblenden -->'
         . '<script type="text/javascript">'
         . 'document.getElementById("header-image").style.display = "none";'
         . '</script>';
  }

  /**
   * Prüft ob der Benutzer angemeldet ist.
   * Wenn nicht, wird eine Systemmeldung hinzugefügt und false geliefert.
   */
  public static function checkAuth() {
    $user = JFactory::getUser();
    if ($user->guest) {
      JFactory::getApplication()->enqueueMessage('Die Registrierung ist abgelaufen. Bitte neu anmelden.');
      return false;
    } else {
      return true;
    }
  }

  public static function methodBegin($className, $methodName, $parameter = null) {
    if (GiessereiConst::METHOD_DEBUG) {
      JFactory::getApplication()->enqueueMessage('Class: ' . $className . ', Method: ' . $methodName . (isset($parameter) ? ', Parameter: ' . $parameter : ''));
    }
  }
  
  public static function debugTrace($message) {
    if (GiessereiConst::METHOD_DEBUG) {
      JFactory::getApplication()->enqueueMessage($message);
    }
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  private static function addStylesheet($stylesheetName) {
    $doc = JFactory::getDocument();
    $base = JURI::base(true);
    $doc->addStyleSheet($base . '/components/com_giesserei/template/' . $stylesheetName);
  }
}
