<?php
// No direct access.
defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

if (!JFactory::getLanguage()->load('lang', JPATH_COMPONENT)) {
  JFactory::getLanguage()->load('lang', JPATH_COMPONENT, 'en-GB');
}

// Execute the task.
$controller	= JController::getInstance('Emptyadmin');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
