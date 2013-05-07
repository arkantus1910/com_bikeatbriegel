<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by UserProfile
$controller = JControllerLegacy::getInstance('BikeAtBriegel');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>