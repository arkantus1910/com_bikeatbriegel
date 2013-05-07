<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * UserProfile Model
 */
class BikeAtBriegelModelPlanAct extends JModelItem
{
        public function getBody()
        {
          $user =& JFactory::getUser();

          if(!$user->id)
          {
                 return "<b>Error</b>";
          }
          else
          {
                $actdate  = JRequest::getVar('actdate',  date('Y-m-d'), 'post');
                $acthour  = JRequest::getVar('acthour',  '00', 'post');
                $actmin   = JRequest::getVar('actmin' ,  '00', 'post');
                $actsport = JRequest::getVar('sport',    '1', 'post');
                $actdist  = JRequest::getVar('actdist',  '0', 'post');
                $actspeed = JRequest::getVar('actspeed', '0', 'post');
                $actdescr = JRequest::getVar('actdescr', 'Geef een korte beschrijving', 'post');

                $hourarr = array(
                   JHTML::_('select.option', '00', JText::_('00') ),
                   JHTML::_('select.option', '01', JText::_('01') ),
                   JHTML::_('select.option', '02', JText::_('02') ),
                   JHTML::_('select.option', '03', JText::_('03') ),
                   JHTML::_('select.option', '04', JText::_('04') ),
                   JHTML::_('select.option', '05', JText::_('05') ),
                   JHTML::_('select.option', '06', JText::_('06') ),
                   JHTML::_('select.option', '07', JText::_('07') ),
                   JHTML::_('select.option', '08', JText::_('08') ),
                   JHTML::_('select.option', '09', JText::_('09') ),
                   JHTML::_('select.option', '10', JText::_('10') ),
                   JHTML::_('select.option', '11', JText::_('11') ),
                   JHTML::_('select.option', '12', JText::_('12') ),
                   JHTML::_('select.option', '13', JText::_('13') ),
                   JHTML::_('select.option', '14', JText::_('14') ),
                   JHTML::_('select.option', '15', JText::_('15') ),
                   JHTML::_('select.option', '16', JText::_('16') ),
                   JHTML::_('select.option', '17', JText::_('17') ),
                   JHTML::_('select.option', '18', JText::_('18') ),
                   JHTML::_('select.option', '19', JText::_('19') ),
                   JHTML::_('select.option', '20', JText::_('20') ),
                   JHTML::_('select.option', '21', JText::_('21') ),
                   JHTML::_('select.option', '22', JText::_('22') ),
                   JHTML::_('select.option', '23', JText::_('23') )
                );

                $minarr = array(
                   JHTML::_('select.option', '00', JText::_('00') ),
                   JHTML::_('select.option', '15', JText::_('15') ),
                   JHTML::_('select.option', '30', JText::_('30') ),
                   JHTML::_('select.option', '45', JText::_('45') )
                );

                $sportarr = array(
                    JHTML::_('select.option', '1', JText::_('Koersfiets') ),
                    JHTML::_('select.option', '2', JText::_('MTB') )
                );


                $body =  '<form class="form-validate" action="'.JRoute::_('index.php').'" method="post" id="planact" name="planact">';
                $body .= ' <table border="0">';
                $body .= '  <tr>';
                $body .= '   <td>Datum : </td>';
                $body .= '   <td>'.JHtml::calendar($actdate, 'actdate', 'actdate', '%Y-%m-%d', 'size="2"').'</td>';
                $body .= '  </tr>';
                $body .= '  <tr>';
                $body .= '   <td>Vertrek tijd : </td>';
                $body .= '   <td>'.JHTML::_('select.genericlist', $hourarr, 'acthour', 'style="width:60px;"', 'value', 'text', $acthour).':'.JHTML::_('select.genericlist', $minarr, 'actmin', 'style="width:60px;"', 'value', 'text', $actmin).'</td>';
                $body .= '  </tr>';
                $body .= '  <tr><td colspan="2">&nbsp;</td></tr>';
                $body .= '  <tr>';
                $body .= '   <td>Type : </td>';
                $body .= '   <td>'.JHTML::_('select.genericlist', $sportarr, 'sport', null, 'value', 'text', $actsport).'</td>';
                $body .= '  </tr>';
                $body .= '  <tr><td colspan="2">&nbsp;</td></tr>';
                $body .= '  <tr>';
                $body .= '   <td>Afstand : </td>';
                $body .= '   <td><input type="text" name="actdist" size="5" value="'.$actdist.'"> km</td>';
                $body .= '  </tr>';
                $body .= '  <tr>';
                $body .= '   <td>Snelheid : </td>';
                $body .= '   <td><input type="text" name="actspeed" size="5" value="'.$actspeed.'"> km/h</td>';
                $body .= '  </tr>';
                $body .= '  <tr><td colspan="2">&nbsp;</td></tr>';
                $body .= '  <tr>';
                $body .= '   <td>Omschrijving : </td>';
                $body .= '   <td><textarea name="actdescr">'.$actdescr.'</textarea></td>';
                $body .= '  </tr>';
                $body .= '  <tr><td colspan="2">&nbsp;</td></tr>';
                $body .= '  <tr><td colspan="2"><input type="hidden" name="option" value="com_bikeatbriegel" /><input type="hidden" name="task" value="planact.submit" /><input type="submit" value="Plan">'.JHtml::_('form.token').'</td></tr>';
                $body .= ' </table>';
                $body .= '</form>';
                $body .= '<div class="clr"></div>';
          }

          return $body;

        }

        public function getTitle()
        {
            return "Plan een Activiteit";

        }
}