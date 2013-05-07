<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * UserProfile Model
 */
class BikeAtBriegelModelUserProfile extends JModelItem
{
        public function getProfile()
        {
          $user =& JFactory::getUser();

          // Default show an error, if all goes ok, this will be overwritten
          $body = "<b>Error</b>";

          // Make sure that either a logged-in user is checking his profile, or someone (logged-in or not) is checking a (his/hers own or not) profile
          if($user->id || JRequest::getVar('id'))
          {
              if(JRequest::getVar('id'))
              {
                  $id = JRequest::getVar('id');
              }
              else
              {
                  $id = $user->id;
              }


              $db =& JFactory::getDBO();

              $query = "SELECT u.username, u.name, u.email, DATE_FORMAT( u.registerDate, '%d.%m.%Y' ) AS registerDate, DATE_FORMAT( u.lastVisitDate, '%d.%m.%Y' ) AS lastVisitDate,";
              $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='1') AS avatar,";
              $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='2') AS mobile,";
              $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='3') AS birthday";
              $query .= " FROM #__users u WHERE u.id='".$id."' AND u.block='0'";

              $db->setQuery( $query );
              $rows = $db->loadObjectList();
              foreach($rows as $row)
              {

                 $body = '<h2>'.$row->name.'</h2>';
                 $body .= '<table id="userprofiletable" width="50%">';
                 if($row->avatar)
                      $body .= '<tr><td colspan="2"><img src="images/avatar/'.$row->avatar.'" width="120px" height="128px" /><br/><br/>&nbsp;</td></tr>';
                 else
                      $body .= '<tr><td colspan="2"><img src="images/avatar/no_img.gif" width="120px" height="120px" /><br/><br/>&nbsp;</td></tr>';
                 $body .= '<tr><td>Gebruikersnaam :</td><td><b>'.$row->username.'</b></td></tr>';
                 $body .= '<tr><td>Naam :</td><td><b>'.$row->name.'</b></td></tr>';
                 if($user->id)
                 {
                    $body .= '<tr><td>E-mail :</td><td><b>'.$row->email.'</b></td></tr>';
                    $body .= '<tr><td>GSM Nummer :</td><td><b>'.$row->mobile.'</b></td></tr>';
                 }
                 $body .= '<tr><td>Verjaardag :</td><td><b>'.$row->birthday.'</b></td></tr>';
                 $body .= '<tr><td>Geregistreerd op :</td><td><b>'.$row->registerDate.'</b></td></tr>';
                 $body .= '<tr><td>Laatst ingelogged :</td><td><b>'.$row->lastVisitDate.'</b></td></tr>';
                 $body .= '</table><br/><br/>&nbsp;';
              }
          }
          return $body;

        }

        public function getMsg()
        {
            return "Gebruikersprofiel";

        }
}