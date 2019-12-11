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
class AlumniDirectoryViewEditAlumni extends JViewLegacy
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
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'INT');
		$active = JFactory::getApplication()->getMenu()->getActive();
		$this->title = $active->title;
		
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
		
		// Assign data to the view
		$alumnidata = $this->get('Information');
		
		if($alumnidata == NULL){
			$this->data = "UNKNOWN ID";
		}else{
			$this->data = "<form action='".JRoute::_('index.php?view=editalumni&id='.$id)."' method='POST'>";
			foreach($alumnidata as $row){
				$vars = get_object_vars($row);
				foreach($vars as $key => $var){
					if($key != "expired" && $key != "last_update" && $key != "ID"){
						$required = "";
						if($key == "First_Name" || $key == "Last_Name")
							$required = "<b>REQUIRED</b>";
						$this->data .= "<tr><td><b>".str_replace("_", " ", $key)."</b></td><td><input name='".$key."' value='".$var."' type='text'>".$required."</td></tr>";
					}elseif($key == "ID"){
						$var_mod = ($id == -1 && $var == '') ? "New Record" : $var;
						
						$this->data .= "<tr><td><b>".str_replace("_", " ", $key)."</b></td><td><input name='".$key."' value='".$var."' type='hidden'>".$var_mod."</td></tr>";
					}
				}
			}
			$this->data .= "<tr><td colspan='2' align='center'><input type='submit' name='save' value='Save Record'></td></tr>";
			$this->data .= "</form>";
		}
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
 			return false;
		}
		
		if($user->guest)
			$this->data = "You don't have permission to be here!";
 
		// Display the view
		parent::display($tpl);
	}
}