<?php
/*
 * Created on 27.12.2010
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport ('joomla.application.component.controlleradmin');

class GiessereiControllerMembers extends JControllerAdmin {

  /**
   * Verbindung zu MyThingsModelMyThing, damit die dort
   * enthaltenen Methoden zum Lesen von Datensätzen
   * verwendet werden können.
   *
   * @return MyThingsModelMyThings Das Model für die Listenansicht
   */
  public function getModel($name = 'Member', $prefix = 'GiessereiModel', $config = array())
  {
    // Model nicht automatisch mit Inhalten aus dem Request befüllen
    $config['ignore_request'] = true;

    // restliche Arbeit der Elternklasse überlassen
    return parent::getModel($name, $prefix, $config);
  }


}

?>
