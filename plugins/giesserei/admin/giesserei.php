<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('giesserei');
$input = JFactory::getApplication()->input;
$controller->execute($input->get('task'));
$controller->redirect();

?>