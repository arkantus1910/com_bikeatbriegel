<?php
 
// No direct access.
defined('_JEXEC') or die;


// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');
 
class BikeAtBriegelControllerPlanAct extends JControllerForm
{
 
        public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
        {
                return parent::getModel($name, $prefix, array('ignore_request' => false));
        }
 
        public function submit()
        {
                // Check for request forgeries.
                JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

                // Initialise variables.
                $app    = JFactory::getApplication();
                $model  = $this->getModel('planact');

                // Get the data from the form POST
                $actdate  = JRequest::getVar('actdate',  '', 'post');
                $acthour  = JRequest::getVar('acthour',  '', 'post');
                $actmin   = JRequest::getVar('actmin' ,  '', 'post');
                $actsport = JRequest::getVar('sport',    '', 'post');
                $actdist  = JRequest::getVar('actdist',  '', 'post');
                $actspeed = JRequest::getVar('actspeed', '', 'post');
                $actdescr = JRequest::getVar('actdescr', '', 'post');

                list($day, $month, $year) = split('[/.-]', $actdate);
                $nactdate = mktime($acthour, $actmin, 0, $month, $day, $year);

                //  Verification
                $err=0;
                if($actdate == null)                                     {   $err=1;   echo '<span style="color:red"><b>Error : </b>Gelieve een datum in te geven</span><br />';   }
                if($actdate != null && $nactdate <= mktime() + 111600)   {   $err=1;   echo '<span style="color:red"><b>Error : </b>Je moet een activiteit minstens 24u op voorhand plannen</span><br />';  }
                if($actsport == null)                                    {   $err=1;   echo '<span style="color:red"><b>Error : </b>Gelieve een type te kiezen</span><br />';               }
                if($actdist  == null || $actdist <= 0 )                   {   $err=1;   echo '<span style="color:red"><b>Error : </b>Gelieve een geldige afstand in te geven</span><br />';  }
                if($actspeed  == null || $actspeed <= 0 )                 {   $err=1;   echo '<span style="color:red"><b>Error : </b>Gelieve een geldige snelheid in te geven</span><br />';  }

                // Now update the loaded data to the database via a function in the model
                //$upditem        = $model->updItem($data);

                // check if ok and display appropriate message.  This can also have a redirect if desired.
                if ($err == 0) 
                {
                   $db =& JFactory::getDBO();
                   $user =& JFactory::getUser();

                   $actdur = round(3600 * $actdist / $actspeed);
                   $dursec = $actdur % 60;
                   $durmin = (($actdur - $dursec)/60)%60;
                   $durhr  = ($actdur - 60*$durmin - $dursec)/3600;
                   if($dursec < 10)   {   $dursec = "0".$dursec;  }
                   if($durmin < 10)   {   $durmin = "0".$durmin;  }

                   if($actsport == 1)  {   $sport = "Koersfiets";   }
                   if($actsport == 2)  {   $sport = "MTB";          }

                   $query =  "INSERT INTO #__bikeatbriegel_activities (planner, date, distance, duration, speed, sport, descr) VALUES (";
                   $query .= "'".$user->id."', '".$actdate." ".$acthour.":".$actmin.":00', '".$actdist."', '".$actdur."', '".$actspeed."', '".$actsport."', '".$actdescr."');";
                   $db->setQuery( $query );
                   if($db->query())
                   {

                       echo "<h2>Activiteit opgeslaan</h2><br /><br />";
                       echo "De volgende activiteit is goed gepland:<br /><br />";
                       echo "<table border='0'>";
                       echo "<tr><td>Datum : </td><td><b>".$actdate."</b></td></tr>";
                       echo "<tr><td>Vertrektijd : </td><td><b>".$acthour.":".$actmin."</b></td></tr>";
                       echo "<tr><td colspan='2'>&nbsp;</td></tr>";
                       echo "<tr><td>Type : </td><td><b>".$sport."</b></td></tr>";
                       echo "<tr><td colspan='2'>&nbsp;</td></tr>";
                       echo "<tr><td>Afstand : </td><td><b>".$actdist." km</b></td></tr>";
                       echo "<tr><td>Snelheid : </td><td><b>".$actspeed." km/u</b></td></tr>";
                       echo "<tr><td>Duur : </td><td><b>".$durhr.":".$durmin.":".$dursec."</b></td></tr>";
                       echo "<tr><td colspan='2'>&nbsp;</td></tr>";
                       echo "<tr><td>Omschrijving : </td><td><b>".$actdescr."</b></td></tr>";
                       echo "</table><br /><br />";
                       echo "Have fun!";

                   }
                   else
                   {
                       echo "<h2>Er is een probleem opgetreden</h2><br /><br />";
                       echo "Er is een probleem opgetreden bij het opslaan van de activiteit.<br />Probeer aub nog eens.<br />Indien dit probleem zich blijft voordoen, contacteer Tim.";
                   }
                }
                else
                {
                     $this->display();
                }
                return true;
        }
 
}
?>