<?php
/**
 * com_alumnidirectory
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * AlumniDirectory Model
 */
class AlumniDirectoryModelEditAlumni extends JModelItem{
	/**
	 * Get the message
	 */
	public function getInformation(){
		$user = JFactory::getUser();
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'INT');
		$save = $jinput->get('save', '', 'STRING');
		$delete = $jinput->get('delete', 0, 'INT');
 
		$result = new stdClass();
		$result->{'0'}->ID="";
		$result->{'0'}->First_Name="";
		$result->{'0'}->Maiden_Name="";
		$result->{'0'}->Last_Name="";
		$result->{'0'}->Address="";
		$result->{'0'}->City="";
		$result->{'0'}->State="";
		$result->{'0'}->Zip="";
		$result->{'0'}->Home_Phone="";
		$result->{'0'}->Employer="";
		$result->{'0'}->Occupation="";
		$result->{'0'}->Work_Phone="";
		$result->{'0'}->Cell_Phone="";
		$result->{'0'}->{'E-Mail'}="";
		$result->{'0'}->Class_Of="";
		$result->{'0'}->Spouse_Name="";
		$result->{'0'}->Spouse_Class="";
		$result->{'0'}->Religion="";
		
		if($delete == 1 && $id > 0 && !$user->guest){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$query->delete('#__alumnidirectory')
				  ->where('ID='.$id);
			$db->setQuery($query);
			$db->execute();
			header("Location: ".JRoute::_('index.php?view=alumnidirectory'));
			exit();
		}

		echo "ID: $id<br>SAVE: $save<br>USER: ".$user->guest;
		
		if($save == "Save Record" && $id > 0 && !$user->guest){
			echo "<pre>UPDATING RECORD</pre>";
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$update_vars = array();
			$vars = get_object_vars($result->{'0'});
			foreach($vars as $key => $var)
				array_push($update_vars, "`".$key."`='".$query->escape($jinput->get($key, '', 'STRING'))."'");
			
			$query->update('#__alumnidirectory')
				  ->set($update_vars)
				  ->set("last_update='".date('c')."'")
				  ->where('ID='.$id);
			$db->setQuery($query);
			if($jinput->get('First_Name', '', 'STRING') != '' && $jinput->get('Last_Name', '', 'STRING') != ''){
				$db->execute();
				header("Location: ".JRoute::_('index.php?view=viewalumni&id='.$id));
				exit();
			}
			exit();
		}elseif($save == "Save Record" && $id == -1 && !$user->guest){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$vars = get_object_vars($result->{'0'});
			$keys = array_keys($vars);
			$values = array();
			foreach($keys as $key)
				array_push($values, "'".$query->escape($jinput->get($key, '', 'STRING'))."'");
			
			for($i = 0; $i < count($keys); $i++){
				if($keys[$i] == "E-Mail")
					$keys[$i] = "`E-Mail`";
			}
				
			$query->insert('#__alumnidirectory')
				  ->columns($keys)
				  ->columns('last_update')
				  ->values(implode(',', $values).","."'".date('c')."'");
			$db->setQuery($query);
			if($jinput->get('First_Name', '', 'STRING') != '' && $jinput->get('Last_Name', '', 'STRING') != ''){
				$db->execute();
				$id = $db->insertid();
				header("Location: ".JRoute::_('index.php?view=viewalumni&id='.$id));
				exit();
			}
		}
 
		if($id == 0){
			$result = NULL;
		}elseif($id > 0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*')
				  ->from('#__alumnidirectory')
				  ->where('id="'.$id.'"');
			
			$db->setQuery($query);
			$result = $db->loadObjectList();
		}
 
		return $result;
	}
	
	public function getFieldNames(){
		return array("First_Name", "Maiden_Name", "Last_Name", "Class_Of", "State");
	}
}