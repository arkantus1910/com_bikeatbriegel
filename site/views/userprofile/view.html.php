<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class BikeAtBriegelViewUserProfile extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null)
        {
                // Assign data to the view
                $this->msg = $this->get('Msg');
                $this->profile = $this->get('Profile');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
                        return false;
                }
                // Display the view
                parent::display($tpl);
        }
}
?>