<?php
/*
 * Created on 27.12.2010
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class GiessereiModelKids extends JModelList {
	
		protected function getListQuery() {
			$db = $this->getDBO();
			$query = $db->getQuery(true);
			
			$query->select('*');
			$query->from('#__mgh_kind');
			$query->order('nachname ASC');

			return $query;
		}	

}
?>
