<?php
defined('_JEXEC') or die('Restricted access');

//require_once (JPATH_COMPONENT.DS.'controller.php');
jimport ('joomla.application.component.controller');

//$controller = new GiessereiController();
$controller = JController::getInstance('giesserei');

//$controller->execute(JRequest::getVar('task'));
$input = JFactory::getApplication()->input;
$controller->execute($input->get('task'));


// $controller->redirect();
?>