<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');
JLoader::register('GiessereiControllerUpdBase', JPATH_COMPONENT . '/controllers/upd_base.php');


/**
 * Controller zum Ändern des Passworts eines Mitglieds.
 */
class GiessereiControllerUpdpassword extends GiessereiControllerUpdBase
{
    protected function getViewName()
    {
        return "updpassword";
    }

    protected function saveDataInSession()
    {
        return false;
    }

    protected function filterFormFields($data)
    {
        $dataAllowed = array();
        $dataAllowed['password'] = $data['password'];
        $dataAllowed['password2'] = $data['password2'];

        return $dataAllowed;
    }

}