<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('giesserei');

$input = JFactory::getApplication()->input;
$controller->execute($input->get('task'));
$controller->redirect();