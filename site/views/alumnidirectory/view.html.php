<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_alumnidirectory
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class AlumniDirectoryViewAlumniDirectory extends JViewLegacy
{
	/**
	 * Display the Alumni Directory view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void echo JRoute::_('index.php?view=article&id=1&catid=20');
	 */
	function display($tpl = null){
		$user = JFactory::getUser();
		$this->state  = $this->get('State');
		$this->params = $this->state->get('parameters.menu');
		$active = JFactory::getApplication()->getMenu()->getActive();
		$this->title = $active->title;
		$jinput = JFactory::getApplication()->input;
		
		$this->alphalist = "";
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		for($i = 0; $i < strlen($alphabet); $i++){
			$this->alphalist .= "<div style='display: inline; padding: 5px; margin: 2px; background-color: #CCC; border-radius: 3px;'><a style='font-size: 1.2em;' href='".JRoute::_('index.php?view=alumnidirectory&alpha='.$alphabet[$i])."'>".$alphabet[$i]."</a></div>";
		}
		
		$search_term = $jinput->get('search_term', '', 'STRING');
		$search_field = $jinput->get('search_field', '', 'STRING');
		$alumni_fields = $this->get('FieldNames');
		$this->searchBox = "<div style=''><form action='".JRoute::_('index.php?view=alumnidirectory')."' method='post'>";
		$this->searchBox .= "<input type='text' name='search_term' value='".$search_term."'><select name='search_field'>";
		foreach($alumni_fields as $item){
			$selected = ($item == $search_field) ? " selected" : "";
			$this->searchBox .= "<option value='".$item."'".$selected.">".str_replace("_", " ", $item)."</option>";
		}
		$this->searchBox .= "</select>&nbsp;<input type='submit' value='Search'></form></div>";
		
		if(!$user->guest)
			$this->searchBox .= "<div><a href='".JRoute::_('index.php?view=editalumni&id=-1')."' class='btn'>New Record</a></div>";
		
		$alumnidata = $this->get('Listing');
		$this->data = "";
		foreach($alumnidata as $row){
			$this->data .= "<tr><td><a href='".JRoute::_('index.php?view=viewalumni&id='.$row->ID)."'>".$row->Last_Name.", ".$row->First_Name."</a></td><td>";
			if(strlen(trim($row->City)) > 0 && strlen(trim($row->State)) > 0){
				$this->data .= $row->City.", ".$row->State;
			}elseif(strlen(trim($row->City)) == 0 && strlen(trim($row->State)) > 0){
				$this->data .= $row->State;
			}
			$this->data .= "</td><td>".$row->Class_Of."</td></tr>";
		}
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 			return false;
		}
 
		// Display the view
		parent::display($tpl);
	}
}