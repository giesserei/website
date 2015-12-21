<?php
/*
 * Oktober 2013, JAL
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

class GiessereiControllerKids extends JControllerAdmin
{

    /**
     * Verbindung zu MyThingsModelMyThing, damit die dort
     * enthaltenen Methoden zum Lesen von Datensätzen
     * verwendet werden können.
     *
     * @return MyThingsModelMyThings Das Model für die Listenansicht
     */
    public function getModel($name = 'kid', $prefix = 'GiessereiModel', $config = array())
    {
        // Model nicht automatisch mit Inhalten aus dem Request befüllen
        $config['ignore_request'] = true;

        // restliche Arbeit der Elternklasse überlassen
        return parent::getModel($name, $prefix, $config);
    }
}
