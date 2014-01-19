<?php
defined('_JEXEC') or die('Restricted access');

jimport ('joomla.application.component.controller');

$controller = JController::getInstance('giesserei');

$input = JFactory::getApplication()->input;
$controller->execute($input->get('task'));

// Redirect wieder aktiviert (SF, 2014-01-04)
$controller->redirect();
?>