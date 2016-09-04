<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiControllerFlats extends JControllerAdmin
{

    public function getModel($name = 'flat', $prefix = 'GiessereiModel', $config = array())
    {
        // Model nicht automatisch mit Inhalten aus dem Request befüllen
        $config['ignore_request'] = true;

        // restliche Arbeit der Elternklasse überlassen
        return parent::getModel($name, $prefix, $config);
    }

}