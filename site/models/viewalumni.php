<?php
/**
 * com_alumnidirectory
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * AlumniDirectory Model
 */
class AlumniDirectoryModelViewAlumni extends JModelItem{
	/**
	 * Get the message
	 */
	public function getInformation()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'INT');
 
		if($id == 0){
			$result = NULL;
		}else{
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