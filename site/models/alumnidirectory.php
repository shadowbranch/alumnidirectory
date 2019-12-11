<?php
/**
 * com_alumnidirectory
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * AlumniDirectory Model
 */
class AlumniDirectoryModelAlumniDirectory extends JModelItem{
	/**
	 * Get the message
	 */
	public function getListing()
	{
		$jinput = JFactory::getApplication()->input;
		$alpha = strtoupper($jinput->get('alpha', 'a', 'WORD'));
		$search_term = $jinput->get('search_term', '', 'STRING');
		$search_field = $jinput->get('search_field', '', 'STRING');
 
		if(strlen($search_term) > 0 && strlen($search_field) > 0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('ID', 'First_Name', 'Last_Name', 'Class_Of', 'City', 'State'))
				  ->from('#__alumnidirectory')
				  ->where($search_field.' LIKE "%'.$search_term.'%"')
				  ->order('Last_Name');
			
			$db->setQuery($query);
			$result = $db->loadObjectList();
		}else{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('ID', 'First_Name', 'Last_Name', 'Class_Of', 'City', 'State'))
				  ->from('#__alumnidirectory')
				  ->where('Last_Name LIKE "'.$alpha.'%"')
				  ->order('Last_Name');
			
			$db->setQuery($query);
			$result = $db->loadObjectList();
		}
		
		return $result;
	}
	
	public function getFieldNames(){
		return array("First_Name", "Maiden_Name", "Last_Name", "Class_Of", "State");
	}
}