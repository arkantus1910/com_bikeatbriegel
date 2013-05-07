<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * UserProfile Model
 */
class BikeAtBriegelModelMemberlist extends JModelItem
{
     public function getUserlist()
     {
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        
        $query = "SELECT u.id, u.username, u.name, u.email, DATE_FORMAT( u.registerDate, '%d.%m.%Y' ) AS registerDate, DATE_FORMAT( u.lastVisitDate, '%d.%m.%Y' ) AS lastVisitDate,";
        $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='1') AS avatar,";
        $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='2') AS mobile,";
        $query .= " (SELECT d.value FROM #__bikeatbriegel_userdata d WHERE d.user_id=u.id AND d.data_id='3') AS birthday";
        $query .= " FROM #__users u WHERE u.block='0'";
        
        $db->setQuery( $query );
        $rows = $db->loadObjectList();

        $html = '<table id="userprofiletable" width="100%">';
        $html .= '<tr><th>Afbeelding</th>';
        $html .= '<th align="left">Naam</th>';
        $html .= '<th align="left">Volledige naam</th>';
        if($user->id)
        {
           $html .= '<th align="left">E-mail</th>';
           $html .= '<th align="left">GSM nummer</th>';
        }
        $html .= '<th align="left">Verjaardag</th>';
        $html .= '<th align="left">Geregistreerd op</th>';
        $html .= '<th align="left">Laatst ingelogged</th>';
        $html .= '</tr>';
        
        foreach($rows as $row)
        {
            $html .= '<tr>';
            if($row->avatar)
            {
               $html .= '<td align="center"><img src="images/avatar/'.$row->avatar.'" width="60px" height="64px" /></td>';
            }
            else
            {
               $html .= '<td align="center"><img src="images/avatar/no_img.gif" width="60px" height="60px" /></td>';
            }
            $html .= '<td align="left"><a href="index.php?option=com_bikeatbriegel&view=userprofile&id='.$row->id.'">'.$row->username.'</a></td>';
            $html .= '<td align="left"><a href="index.php?option=com_bikeatbriegel&view=userprofile&id='.$row->id.'">'.$row->name.'</a></td>';

            if($user->id)
            {
               $html .= '<td align="left">'.$row->email.'</td>';
               $html .= '<td align="left">'.$row->mobile.'</td>';
            }
            $html .= '<td align="left">'.$row->birthday.'</td>';
            $html .= '<td align="left">'.str_replace('.', '/', $row->registerDate).'</td>';
            $html .= '<td align="left">'.str_replace('.', '/', $row->lastVisitDate).'</td>';

            $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
     }

        public function getMsg($id = 1)
        {
                return "Ledenlijst";
        }
}