<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');

jimport('joomla.application.component.controller');

/**
 * Globaler Controller für das Frontend der Giesserei-Komponente.
 */
class GiessereiController extends JControllerLegacy
{

    public function execute($task)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiController', 'execute');
        return parent::execute($task);
    }

    function display($cachable = false, $urlparams = array())
    {
        GiessereiFrontendHelper::methodBegin('GiessereiController', 'display');
        parent::display($cachable, $urlparams);
    }

    function detail()
    {
        global $mainframe;
        JRequest::setVar('view', 'detail');
        parent::display();
        $mainframe->close();
    }
}