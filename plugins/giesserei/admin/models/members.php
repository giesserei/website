<?php
/*
 * Created on 27.12.2010
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class GiessereiModelMembers extends JModelList {
		//	var $_data;
	
		protected function getListQuery() {
			$db = $this->getDBO();
			$query = $db->getQuery(true);
			
			$query->from('#__mgh_mitglied as mgl');
			$query->select('mgl.*');
			
			$query->select('usr.email as email');
			$query->join('LEFT','#__users AS usr ON usr.id = mgl.userid');
			
			$query->select('kun.avatar as avatar');
			$query->join('LEFT','#__kunena_users AS kun ON mgl.userid = kun.userid');
			
			// $query->where('austritt >= NOW() OR austritt = "0000-00-00"');
			// 2013-12-29 chdh: Auskommentiert. Wir müssen die ausgetretenen Mitglieder im Backend bearbeiten können.
			// Ein Mitglied hatte z.B. noch eine Wohnung zugeordnet.
			
			$query->order('nachname ASC');

			return $query;
		}
}
?>
