<?php
// No direct access.
defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('Emptyadmin');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
