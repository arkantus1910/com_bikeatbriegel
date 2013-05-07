<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class BikeAtBriegelViewShowDay extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null)
        {
                // Assign data to the view
                $this->Title = 'Activiteiten op 2013-05-07';
                $this->Body = 'Test';

                parent::display($tpl);
        }
}
?>
