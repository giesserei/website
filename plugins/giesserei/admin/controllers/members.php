<?php

defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

use Joomla\Utilities\ArrayHelper;

class GiessereiControllerMembers extends JControllerAdmin
{

    public function getModel($name = 'member', $prefix = 'GiessereiModel', $config = array())
    {
        // Model nicht automatisch mit Inhalten aus dem Request befüllen
        $config['ignore_request'] = true;

        return parent::getModel($name, $prefix, $config);
    }

}
