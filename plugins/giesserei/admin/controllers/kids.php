<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiControllerKids extends JControllerAdmin
{

    public function getModel($name = 'kid', $prefix = 'GiessereiModel', $config = array())
    {
        // Model nicht automatisch mit Inhalten aus dem Request befüllen
        $config['ignore_request'] = true;

        return parent::getModel($name, $prefix, $config);
    }
}
